<?php

namespace App\Controller\Component;

use Cake\Log\Log;
use Cake\I18n\Time;
use \Cake\ORM\Query;
use RuntimeException;
use Cake\Mailer\Email;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component;
use Cake\Mailer\MailerAwareTrait;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ConnectionManager;
use App\Controller\ApiGooglesController;
use App\Controller\Component\UtilComponent;
use App\Controller\Component\S3ClientComponent;

class BatchComponent extends Component {
    //public $components = ['S3Client'];

    use MailerAwareTrait; // メールクラス
    public function initialize(array $config) {
        // コンポーネント
        $this->Instagram = new InstagramComponent(new ComponentRegistry());
        $this->Util = new UtilComponent(new ComponentRegistry());
        $this->S3Client = new S3ClientComponent(new ComponentRegistry());
    }

    /**
     * mysqldumpを実行する
     * @return mixed
     */
    public function backup() {
        $result = true; // 正常終了フラグ
        // コネクションオブジェクト取得
        $con = ConnectionManager::get('default');
        // バックアップファイルを何日分残しておくか
        $period = '+30';
        // ルートディレクトリ
        $root = ROOT;
        // 日付
        $date = date('Ymd');
        // バックアップファイルを保存するディレクトリ
        $dirpath = $root . DS . 'np_backup' . DS . $date;
        // mysqldumpパス
        $mysqldump_path = '/usr/bin/mysqldump ';

        // バックアップディクレトリ作成
        exec('mkdir -p ' . $root . DS . 'np_backup', $output, $result_code);
        // パーミッション変更
        exec('chmod 700 ' . $root . DS . 'np_backup');

        // バックアップディクレトリ作成
        exec('mkdir -p ' . $dirpath, $output, $result_code);
        // パーミッション変更
        exec('chmod 700 ' . $dirpath);

        // コマンド
        $command = sprintf(
            $mysqldump_path . '--no-tablespaces -h %s -u %s -p%s %s | gzip > %sbackup.sql.gz',
            $con->config()['host'],
            $con->config()['username'],
            $con->config()['password'],
            $con->config()['database'],
            $dirpath . DS . $date
        );

        // データベースバックアップ
        exec($command, $output, $result_code);

        Log::info(__LINE__ . '::' . __METHOD__ . '::' . "アウトプット:" . print_r($output) . "結果コード:" . $result_code, 'batch_bk');
        return $result;
    }

    /**
     * ディクレトリバックアップを実行する
     * @return mixed
     */
    public function dirBackup() {
        $result = true; // 正常終了フラグ
        // バックアップファイルを何日分残しておくか
        $period = '+7';
        // ルートディレクトリ
        $root = dirname(ROOT);
        // 日付
        $date = date('Ymd');
        // バックアップファイルを保存するディレクトリ
        $dirpath = $root . DS . 'np_backup';
        // バックアップ元フォルダ
        $backupfolder = $root . DS . 'img';
        // ファイル名を定義(※ファイル名で日付がわかるようにしておきます)
        $filename = 'images_' . $date . 'tar.gz ';
        // バックアップ実行
        exec('tar -zcvf ' . $dirpath . DS . $filename . $backupfolder, $output, $result_code);
        // パーミッション変更
        exec('chmod 700 ' . $dirpath . DS . $filename);
        // 古いバックアップファイルを削除
        exec('find ' . $dirpath . ' -type f -mtime ' . $period . " -exec rm {} \\;");
        // 結果コードが0以外の場合FALSEを設定する
        if ($result_code != 0) {
            $result = false;
        }
        Log::info(__LINE__ . '::' . __METHOD__ . '::' . "アウトプット:" . $output . "結果コード:" . $result, 'batch_bk');
        return $result;
    }

    /**
     * サービスプラン期間適応外をフリープランに変更する処理
     *
     * @param [type] $id
     * @param [type] $diaryPath
     * @return array
     */
    public function changeServicePlan() {

        $result = true; // 正常終了フラグ
        $action_name = "changeServicePlan,";

        $servece_plans = TableRegistry::get('servece_plans');
        $owners        = TableRegistry::get('owners');
        $plans = $servece_plans->find("all")
            ->where(['NOW() > to_end', 'to_end !=' => '0000-00-00'])
            ->contain(['owners'])
            ->toArray();

        $update_entities = array();

        foreach ($plans as $key => $plan) {
            $update_entity = [];
            $update_entity['id'] = $plan->id;
            $update_entity['course'] = 0;
            $update_entity['previous_plan'] = $plan->current_plan;
            $update_entity['current_plan'] = SERVECE_PLAN['free']['label'];
            $update_entity['from_start'] = '0000-00-00';
            $update_entity['to_end'] = '0000-00-00';
            array_push($update_entities, $update_entity);
        }
        $entities = $servece_plans->patchEntities(
            $servece_plans,
            $update_entities,
            ['validate' => false]
        );
        // プラン変更なし
        if (empty($entities)) {
            Log::info(__LINE__ . '::' . __METHOD__ . ":: プラン変更該当なし", 'batch_csp');
            return $result;
        }

        try {
            // レコード更新実行
            if (!$servece_plans->saveMany($entities)) {
                throw new RuntimeException('レコードの更新ができませんでした。,' . $entities);
            }
            // プラン変更通知メール送信
            foreach ($plans as $key => $plan) {
                $email = new Email('default');
                $email->setFrom([MAIL['SUPPORT_MAIL'] => MAIL['FROM_NAME']])
                    ->setSubject(MAIL['AUTO_FREE_PLAN_CHANGE_SUCCESS'])
                    ->setTo($plan->Owners['email'])
                    ->setBcc(MAIL['SUPPORT_MAIL'])
                    ->setTemplate("expired_service_plan")
                    ->setLayout("simple_layout")
                    ->emailFormat("html")
                    ->viewVars(['plan' => $plan])
                    ->send();

                Log::info(__LINE__ . '::' . __METHOD__ . "::" . "ID：【" . $plan->Owners['id']
                    . "】アドレス：【" . $plan->Owners['email'] . "】"
                    . RESULT_M['AUTO_FREE_PLAN_CHANGE_SUCCESS'], 'batch_csp');
            }

        } catch (RuntimeException $e) {
            $result = false; // 異常終了フラグ
            Log::error(__LINE__ . '::' . __METHOD__ . "::" . $e , 'batch_csp');
        }
        return $result;
    }

    /**
     * 新着画像投稿を集計する処理
     *
     * @param [type] $id
     * @param [type] $diaryPath
     * @return array
     */
    public function saveNewPhotosRank() {
        $this->NewPhotosRank   = TableRegistry::get('new_photos_rank');
        $this->Snss            = TableRegistry::get('snss');
        $this->Shops           = TableRegistry::get('shops');

        $result = true; // 正常終了フラグ
        $action_name = "saveNewPhotosRank,";
        // webroot/img/配下のinstaキャッシュを取得する
        // $dir = WWW_ROOT . PATH_ROOT['IMG'];
        // $dir = PATH_ROOT['SHOPS'];
        // $exp = "*.dat";
        // $files = $this->S3Client->getListObjects(null, $dir, 100);

        $shops = $this->Shops->find('all')
            ->contain([
                'Casts' => function (Query $q) {
                    return $q
                        ->where(['Casts.status = 1 AND Casts.delete_flag = 0']);
                }, 'Casts.Diarys' => function (Query $q) {
                    return $q
                        ->order(['Diarys.created' => 'DESC'])
                        ->limit(5);
                }, 'ShopInfos' => function (Query $q) {
                    return $q
                        ->order(['ShopInfos.created' => 'DESC'])
                        ->limit(5);
                }
            ])
            ->where(['shops.status = 1 AND shops.delete_flag = 0'])->limit("200")->toArray();

        $snss   =  $this->Snss->find("all", ["DISTINCT instagram"])
            ->where(["instagram != ''"])
            ->contain(['Shops' => function (Query $q) {
                return $q
                    ->where(['Shops.status = 1 AND Shops.delete_flag = 0']);
            }, 'shops.Owners.ServecePlans' => function (Query $q) {
                return $q
                    ->where(['current_plan is not' => SERVECE_PLAN['free']['label']]);
            }])->limit(199)->toArray();

        // 店舗,スタッフ情報をセット
        foreach ($shops as $key => $shop) {

            $shop->set('shopInfo', $this->Util->getShopInfo($shop));
            foreach ($shop->casts as $key => $cast) {
                $cast->set('castInfo', $this->Util->getCastInfo($cast, $shop));
            }
        }

        // 店舗,スタッフ情報をセット
        foreach ($snss as $key => $sns) {
            $shop = $sns->shop;
            // ナイプラ自身のインスタの場合
            if ($shop->ig_data['business_discovery']['username'] == API['INSTAGRAM_USER_NAME']) {
                continue;
            }

            $shop->set('shopInfo', $this->Util->getShopInfo($shop));
            if ($shop->casts != null && is_array($shop->casts)) {
                foreach ($shop->casts as $key => $cast) {
                    $cast->set('castInfo', $this->Util->getCastInfo($cast, $shop));
                }
            }
        }

        // ナイプラのsnsエンティティ作成
        $sns = $this->Snss->newEntity();
        $sns->set("shop", $this->Shops->newEntity());
        $sns->set("instagram", API['INSTAGRAM_USER_NAME']);
        $sns->shop->set(
            "shopInfo",
            array(
                'area' => REGION['okinawa'], 'genre' => array('label' => 'ナイプラ')
            )
        );
        array_push($snss, $sns);

        // Instagram情報セット
        foreach ($snss as $key => $sns) {

            $insta_user_name = $sns->instagram;
            $shop = $sns->shop;

            // インスタのキャッシュパス
            $cache_path = PATH_ROOT['TMP'] . DS . PATH_ROOT['CACHE'];
            $datFile = $insta_user_name . '-instagram_graph_api.dat';
            // インスタ情報を取得
            $tmp_ig_data = $this->Instagram->getInstagram(
                $insta_user_name,
                null,
                $shop->shopInfo['current_plan'],
                $cache_path,
                $datFile
            );
            // データ取得に失敗した場合
            if (!$tmp_ig_data) {
                Log::warning(__LINE__ . '::' . __METHOD__ . '::' . '【' . AREA[$shop->area]['label']
                    . GENRE[$shop->genre]['label'] . $shop->name
                    . '】のインスタグラムのデータ取得に失敗しました。', "batch_snpr");
            }
            $ig_data = $tmp_ig_data->business_discovery;
            // インスタユーザーが存在しない場合
            if (!empty($tmp_ig_data->error)) {
                // エラーメッセージをセットする
                $insta_error = $tmp_ig_data->error->error_user_title;
                $this->set(compact('ig_error'));
            }
            //$cache_file = $this->Util->scanDir($cache_path, $exp);
            $shop->set('ig_data', $ig_data);
            // キャッシュファイルの最終更新日時を取得
            $shop->set('ig_date',  date('Y-m-d H:i:s', @filemtime('s3://' . env('AWS_BUCKET') . DS . $cache_path . DS . $datFile)));
            //$shop->set('ig_path', $cache_file[0]);
            array_push($shops, $shop);
        }

        $sort_lists = array();
        foreach ($shops as $key => $shop) {
            array_push($sort_lists, $shop);
            if ($shop->casts != null && is_array($shop->casts)) {
                foreach ($shop->casts as $key => $cast) {
                    array_push($sort_lists, $cast);
                }
            }
        }
        $newPhotosRankEntityList = array();
        // エンティティを配列に詰め込む
        foreach ($sort_lists as $key => $sort_list) {
            //モデル名取得
            $alias = str_replace('_', '', strtolower($sort_list->registry_alias));

            if ($alias == 'shops') {

                if ($sort_list->__isset('ig_data')) {
                    $shop = $sort_list;
                    $ig_data = json_decode(json_encode($shop->ig_data), true);

                    // 最大５件までデータ取得
                    foreach ($ig_data['media']['data'] as $key => $value) {
                        if ($key == 5) {
                            break;
                        }
                        $newPhotosRankEntity = $this->NewPhotosRank->newEntity();
                        // メディアURLが取得出来ない場合があるのでその際は、ログ出してスルーする
                        if (empty($value['media_url'])) {
                            Log::warning(__LINE__ . '::' . __METHOD__ . '::' . '【' . AREA[$shop->area]['label']
                                . GENRE[$shop->genre]['label'] . $shop->name
                                . '】のインスタグラム【 media_url 】が存在しませんでした。', "batch_snpr");
                            continue;
                        }
                        $newPhotosRankEntity->set('shop_id', $shop->id);
                        $newPhotosRankEntity->set('name', $ig_data['username']);
                        $newPhotosRankEntity->set('area', $shop->shopInfo['area']['label']);
                        $newPhotosRankEntity->set('genre', $shop->shopInfo['genre']['label']);
                        $newPhotosRankEntity->set('is_insta', 1);
                        $newPhotosRankEntity->set('media_type', $value['media_type']);
                        $newPhotosRankEntity->set('like_count', is_null($value['like_count']) ? '-' : $value['like_count']);
                        $newPhotosRankEntity->set('comments_count', $value['comments_count']);
                        $newPhotosRankEntity->set('photo_path', $value['media_url']);
                        // ナイプラ自身のインスタの場合
                        if ($ig_data['username'] == API['INSTAGRAM_USER_NAME']) {
                            $newPhotosRankEntity->set('details', 'https://www.instagram.com/' . $ig_data['username']);
                        } else {
                            $newPhotosRankEntity->set('details', $shop->shopInfo['shop_url']);
                        }
                        $newPhotosRankEntity->set('content', $value['caption']);
                        $newPhotosRankEntity->set('post_date', date("Y-m-d H:i:s", strtotime($value['timestamp'])));

                        array_push($newPhotosRankEntityList, $newPhotosRankEntity);
                    }
                } else if (is_countable($sort_list->shop_infos)) {
                    $shop = $sort_list;
                    foreach ($sort_list->shop_infos as $key => $value) {
                        if ($key == 5) {
                            break;
                        }

                        $photo_path = $shop->shopInfo['notice_path'] . $value['dir'];
                        $filePath = $this->S3Client->getList(null, $photo_path, 1);
                        if ($filePath == null) {
                            $filePath = PATH_ROOT['NO_IMAGE06'];
                        } else {
                            $filePath = PATH_ROOT['URL_S3_BUCKET'] . '/' . $filePath[0];
                        }

                        $newPhotosRankEntity = $this->NewPhotosRank->newEntity();
                        $newPhotosRankEntity->set('shop_id', $shop->id);
                        $newPhotosRankEntity->set('name', $shop->name);
                        $newPhotosRankEntity->set('area', $shop->shopInfo['area']['label']);
                        $newPhotosRankEntity->set('genre', $shop->shopInfo['genre']['label']);
                        $newPhotosRankEntity->set('is_insta', 0);
                        $newPhotosRankEntity->set('media_type', 'IMAGE');
                        $newPhotosRankEntity->set('like_count', 0);
                        $newPhotosRankEntity->set('comments_count', 0);
                        $newPhotosRankEntity->set('photo_path', $filePath);
                        $newPhotosRankEntity->set('details', $shop->shopInfo['shop_url']);
                        $newPhotosRankEntity->set('content', $value->content);
                        $newPhotosRankEntity->set('post_date', $value->modified->format("Y-m-d H:i:s"));
                        array_push($newPhotosRankEntityList, $newPhotosRankEntity);
                    }
                }
            } else if ($alias == 'casts') {

                if ($sort_list->__isset('ig_data')) {
                    $cast = $sort_list;
                    $ig_data = json_decode(json_encode($cast->ig_data), true);

                    // 最大５件までデータ取得
                    foreach ($ig_data['media']['data'] as $key => $value) {
                        if ($key == 5) {
                            break;
                        }
                        $newPhotosRankEntity = $this->NewPhotosRank->newEntity();
                        // メディアURLが取得出来ない場合があるのでその際は、ログ出してスルーする
                        if (empty($value['media_url'])) {
                            Log::warning(__LINE__ . '::' . __METHOD__ . '::' . '【' . AREA[$cast->area]['label']
                                . GENRE[$cast->genre]['label'] . $cast->name
                                . '】のインスタグラム【 media_url 】が存在しませんでした。', "batch_snpr");
                            continue;
                        }
                        $newPhotosRankEntity->set('cast_id', $cast->id);
                        $newPhotosRankEntity->set('name', $ig_data['username']);
                        $newPhotosRankEntity->set('area', $cast->castInfo['area']['label']);
                        $newPhotosRankEntity->set('genre', $cast->castInfo['genre']['label']);
                        $newPhotosRankEntity->set('is_insta', 1);
                        $newPhotosRankEntity->set('media_type', $value['media_type']);
                        $newPhotosRankEntity->set('like_count', is_null($value['like_count']) ? '-' : $value['like_count']);
                        $newPhotosRankEntity->set('comments_count', $value['comments_count']);
                        $newPhotosRankEntity->set('photo_path', $value['media_url']);
                        // ナイプラ自身のインスタの場合
                        if ($ig_data['username'] == API['INSTAGRAM_USER_NAME']) {
                            $newPhotosRankEntity->set('details', 'https://www.instagram.com/' . $ig_data['username']);
                        } else {
                            $newPhotosRankEntity->set('details', $cast->castInfo['cast_url']);
                        }
                        $newPhotosRankEntity->set('content', $value['caption']);
                        $newPhotosRankEntity->set('post_date', date("Y-m-d H:i:s", strtotime($value['timestamp'])));

                        array_push($newPhotosRankEntityList, $newPhotosRankEntity);
                    }
                } else if (is_countable($sort_list->diarys) > 0) {
                    $cast = $sort_list;
                    foreach ($sort_list->diarys as $key => $value) {
                        if ($key == 5) {
                            break;
                        }

                        $photo_path = $cast->castInfo['diary_path'] . $value['dir'];
                        $filePath = $this->S3Client->getList(null, $photo_path, 1);
                        if ($filePath == null) {
                            $filePath = PATH_ROOT['NO_IMAGE06'];
                        } else {
                            $filePath = PATH_ROOT['URL_S3_BUCKET'] . '/' . $filePath[0];
                        }

                        $newPhotosRankEntity = $this->NewPhotosRank->newEntity();
                        $newPhotosRankEntity->set('cast_id', $cast->id);
                        $newPhotosRankEntity->set('name', $cast->nickname);
                        $newPhotosRankEntity->set('area', $cast->castInfo['area']['label']);
                        $newPhotosRankEntity->set('genre', $cast->castInfo['genre']['label']);
                        $newPhotosRankEntity->set('is_insta', 0);
                        $newPhotosRankEntity->set('media_type', 'IMAGE');
                        $newPhotosRankEntity->set('like_count', 0);
                        $newPhotosRankEntity->set('comments_count', 0);
                        $newPhotosRankEntity->set('photo_path', $filePath);
                        $newPhotosRankEntity->set('details', $cast->castInfo['cast_url']);
                        $newPhotosRankEntity->set('content', $value->content);
                        $newPhotosRankEntity->set('post_date', $value->modified->format("Y-m-d H:i:s"));
                        array_push($newPhotosRankEntityList, $newPhotosRankEntity);
                    }
                }
            }
        }
        foreach ($newPhotosRankEntityList as $key => $entity) {
            $updated[$key] = $entity['post_date'];
        }
        //配列のkeyのupdatedでソート
        array_multisort($updated, SORT_DESC, $newPhotosRankEntityList);

        try {
            // レコードが存在した場合は削除する
            if ($this->NewPhotosRank->find('all')->count() > 0) {
                // 新着フォトランキングレコード削除
                if (!$this->NewPhotosRank->deleteAll([""])) {
                    Log::error(__LINE__ . '::' . __METHOD__ . "::レコードの削除に失敗しました。", "batch_snpr");
                    throw new RuntimeException($action_name . 'レコードの削除に失敗しました。');
                }
            }
            // レコードを一括登録する
            if (!$this->NewPhotosRank->saveMany($newPhotosRankEntityList)) {
                Log::error(__LINE__ . '::' . __METHOD__ . "::レコードの登録に失敗しました。", "batch_snpr");
                throw new RuntimeException($action_name . 'レコードの登録に失敗しました。');
            }
        } catch (RuntimeException $e) {
            Log::error(__LINE__ . '::' . __METHOD__ . "::バッチ処理が失敗しました。" . $e, "batch_snpr");
            $result = false; // 異常終了フラグ
        }

        return $result;
    }

    /**
     * 各店舗のアクセスレポートを集計する処理
     *
     * @return array
     */
    public function analyticsReport(string $startDate = null, string $endDate = null) {

        $isZenjitsu = true;
        $isHosyu = false;
        $this->ApiGoogles = new ApiGooglesController();
        // バッチ手動実行時に日付が指定されている場合はチェックする
        if (isset($startDate)) {
            if (!isset($endDate)) {
                throw new RuntimeException(__LINE__ . '::' . __METHOD__ . "::バッチ処理が失敗しました。終了日を指定してください。【開始日：" . $startDate . "】【終了日：" . $endDate . "】");
            }
            $startTime = Time::parse($startDate);
            $endTime = Time::parse($endDate);
            // 開始日が終了日より前であるか判定
            if (!$startTime->lte($endTime)) {
                throw new RuntimeException(__LINE__ . '::' . __METHOD__ . "::バッチ処理が失敗しました。日付の前後が不正です。【開始日：" . $startDate . "】【終了日：" . $endDate . "】");
            }
            $isHosyu = true;
        }

        // 保守以外の場合
        if (!$isHosyu) {

            // 現在日付
            $now_date = new Time(date('Y-m-d'));
            // チェック用
            $data_check = $now_date->format('Y-m-d');

            $range_start  = $data_check . ' 0:00:00';
            $range_end    = $data_check . ' 1:00:00';
            $range_target = $data_check . ' ' . Time::now()->i18nFormat('HH:mm:ss');
            // 年別、週別を更新するかチェックする
            $isZenjitsu = $this->Util->check_in_range($range_start, $range_end, $range_target);

            // 前日データを取得するか
            if ($isZenjitsu) {
                // 前日アナリティクスレポート取得
                $reports = $this->ApiGoogles->index($isHosyu, $isZenjitsu);
            } else {
                // 当日アナリティクスレポート取得
                $reports = $this->ApiGoogles->index($isHosyu, $isZenjitsu);
            }
            // タスクの実行
            $result = $this->calculateAnalyticsReport($reports,  $startDate);
            Log::info(__LINE__ . '::' . __METHOD__ . "::" . $startDate . '~' . $endDate . '1日分処理しました。', "batch_ar");
        } else {
            // 前日アナリティクスレポート取得
            $reports = $this->ApiGoogles->index($isHosyu, null, $startDate, $endDate);
        }

        return true;
    }

    /**
     * 各店舗のアクセスレポートを集計する処理 保守用
     *
     * @return array
     */
    public function calculateAnalyticsReport($reports,  $start_date) {

        $this->AccessYears  = TableRegistry::get('access_years');
        $this->AccessMonths = TableRegistry::get('access_months');
        $this->AccessWeeks  = TableRegistry::get('access_weeks');
        $this->Shops        = TableRegistry::get('shops');
        $this->Casts        = TableRegistry::get('casts');

        $result = true; // 正常終了フラグ
        $action_name = "analyticsReport,";
        // テーブル格納用
        $entities_year  = array();
        $entities_month = array();
        $entities_week  = array();
        $dimensionHeaders = $reports->getDimensionHeaders();
        $metricHeaders = $reports->getMetricHeaders();

        foreach ($reports->getRows() as $reportIdx => $reportRow) {
            $dimensionValues = $reportRow->getDimensionValues();
            $metricValues = $reportRow->getMetricValues();

            // 各ディメンションを取得する
            $date = $pageTitle = $pagePath = $landingPagePlusQueryString = $dayOfWeek = $dayOfWeekName = null;
            foreach ($dimensionHeaders as $dimensionHeadIdx => $dimensionHeadRow) {
                if ($dimensionHeadRow->getName() == 'date') {
                    $date = $dimensionValues[$dimensionHeadIdx]->getValue();
                } else if ($dimensionHeadRow->getName() == 'pageTitle') {
                    $pageTitle = $dimensionValues[$dimensionHeadIdx]->getValue();
                } else if ($dimensionHeadRow->getName() == 'pagePath') {
                    $pagePath = $dimensionValues[$dimensionHeadIdx]->getValue();
                } else if ($dimensionHeadRow->getName() == 'landingPagePlusQueryString') {
                    $landingPagePlusQueryString = $dimensionValues[$dimensionHeadIdx]->getValue();
                } else if ($dimensionHeadRow->getName() == 'dayOfWeek') {
                    $dayOfWeek = $dimensionValues[$dimensionHeadIdx]->getValue();
                } else if ($dimensionHeadRow->getName() == 'dayOfWeekName') {
                    $dayOfWeekName = $dimensionValues[$dimensionHeadIdx]->getValue();
                }
            }
            // 各メトリクスを取得する
            $screenPageViews = $newUsers = $activeUsers = $sessions = null;
            foreach ($metricHeaders as $metricHeadIdx => $metricHeadRow) {
                if ($metricHeadRow->getName() == 'screenPageViews') {
                    $screenPageViews = $metricValues[$metricHeadIdx]->getValue();
                } else if ($metricHeadRow->getName() == 'newUsers') {
                    $newUsers = $metricValues[$metricHeadIdx]->getValue();
                } else if ($metricHeadRow->getName() == 'activeUsers') {
                    $activeUsers = $metricValues[$metricHeadIdx]->getValue();
                } else if ($metricHeadRow->getName() == 'sessions') {
                    $sessions = $metricValues[$metricHeadIdx]->getValue();
                }
            }

            // 曜日を取得する
            $week = $this->Util->getWeek($dayOfWeek);

            $entityYear  = null;
            $entityMonth = null;
            $entityWeek  = null;
            $isFirstYearData  = true; // 対象年のデータ存在有無
            $isFirstMonthData = true; // 対象月のデータ存在有無
            $isFirstWeekData  = true; // 対象週のデータ存在有無

            /**
             * dimension filter を作成
             */
            $area = "";
            // エリア
            foreach (AREA as $index => $value) {
                if ($index === array_key_first(AREA)) {
                    $area .= "\/(";
                }
                $area .= $value['path'] . '|';
                if ($index === array_key_last(AREA)) {
                    $area .= ")";
                    $area = str_replace('|)', ')', $area);
                }
            }
            $genre = "";
            // スタッフとジャンル
            foreach (GENRE as $index => $value) {
                if ($index === array_key_first(GENRE)) {
                    $genre .= "\/(cast|";
                }
                $genre .= $value['path'] . '|';
                if ($index === array_key_last(GENRE)) {
                    $genre .= ")\/[0-9]{1,9}$";
                    $genre = str_replace('|)', ')', $genre);
                }
            }
            $dimensionFilter = $area . $genre;

            // 店舗、スタッフページの場合
            if (preg_match('/^' . $dimensionFilter . '/', $pagePath, $matches)) {

                $url_aplit = explode('/', $pagePath);
                $delimitCount = count($url_aplit);
                $now_date   = new Time($start_date);
                // 年別アクセスエンティティ
                $y   = $now_date->format('Y');
                $ym  = $now_date->format('Y-m');
                $day = $now_date->format('j');

                // ジャンルが存在している場合 ⇒ 店舗
                if (count(array_intersect(array_keys(GENRE), $url_aplit))) {
                    $shop_id = $url_aplit[$delimitCount - 1];

                    $shop = $this->Shops->find()
                        ->where(['id' => $shop_id])
                        ->first();
                    $patch_data = array(
                        'shop_id' => (int) $shop_id, 'owner_id' => $shop->owner_id, 'name' => $shop->name, 'area' => $shop->area, 'genre' => $shop->genre, 'pagePath' => $pagePath
                    );

                    $logInfo = 'start_date:: ' . $start_date . ', 年月日:: ' . $date . ' , URL:: ' . $pagePath . ' , 店舗名:: ' . $shop->name;

                    // 月別アクセスエンティティ
                    $entityYear = $this->AccessYears->find()
                        ->where(['shop_id' => $shop_id, 'owner_id' => $shop->owner_id, 'y' => $y])
                        ->first();
                    // 日別アクセスエンティティ
                    $entityMonth = $this->AccessMonths->find()
                        ->where(['shop_id' => $shop_id, 'owner_id' => $shop->owner_id, 'ym' => $ym])
                        ->first();
                    // 曜日別アクセスエンティティ
                    $entityWeek = $this->AccessWeeks->find()
                        ->where(['shop_id' => $shop_id, 'owner_id' => $shop->owner_id])
                        ->first();
                } else if ('cast' == $url_aplit[$delimitCount - 2]) {
                    // スタッフの場合
                    $cast_id = $url_aplit[$delimitCount - 1];

                    $cast = $this->Casts->find('all')
                        ->contain(['Shops'])
                        ->where(['casts.id' => $cast_id])
                        ->first();
                    $patch_data = array(
                        'cast_id' => (int) $cast_id, 'owner_id' => $cast->shop->owner_id, 'name' => $cast->name, 'area' => $cast->shop->area, 'genre' => $cast->shop->genre, 'pagePath' => $pagePath
                    );

                    $logInfo = 'start_date:: ' . $start_date . ', 年月日:: ' . $date . ' , URL:: ' . $pagePath . ' , スタッフ名:: ' . $cast->name;

                    // 月別アクセスエンティティ
                    $entityYear = $this->AccessYears->find()
                        ->where(['cast_id' => $cast_id, 'owner_id' => $cast->shop->owner_id, 'y' => $y])
                        ->first();
                    // 日別アクセスエンティティ
                    $entityMonth = $this->AccessMonths->find()
                        ->where(['cast_id' => $cast_id, 'owner_id' => $cast->shop->owner_id, 'ym' => $ym])
                        ->first();
                    // 曜日別アクセスエンティティ
                    $entityWeek = $this->AccessWeeks->find()
                        ->where(['cast_id' => $cast_id, 'owner_id' => $cast->shop->owner_id])
                        ->first();
                }

                Log::info($logInfo, "batch_ar");

                // 取得出来なかったら新規エンティティ
                if (empty($entityYear)) {

                    $isFirstYearData = false;

                    $patch_year =  $patch_data;
                    $patch_year['y'] = $y;
                    $entityYear = $this->AccessYears->newEntity();
                    $entityYear = $this->AccessYears
                        ->patchEntity(
                            $entityYear,
                            $patch_year,
                            ['validate' => false]
                        );
                }

                // 取得出来なかったら新規エンティティ
                if (empty($entityMonth)) {

                    $isFirstMonthData = false;

                    $patch_month =  $patch_data;
                    $patch_month['ym'] = $ym;
                    $entityMonth = $this->AccessMonths->newEntity();
                    $entityMonth = $this->AccessMonths
                        ->patchEntity(
                            $entityMonth,
                            $patch_month,
                            ['validate' => false]
                        );
                }

                // 取得出来なかったら新規エンティティ
                if (empty($entityWeek)) {

                    $isFirstWeekData = false;

                    $entityWeek  = $this->AccessWeeks->newEntity();
                    $entityWeek = $this->AccessWeeks
                        ->patchEntity(
                            $entityWeek,
                            $patch_data,
                            ['validate' => false]
                        );
                }

                // 年別アクセスエンティティ
                $entityYear->set($now_date->month . '_sessions', $this->Util
                    ->addVal($entityYear->get(
                        $now_date->month . '_sessions'
                    ), (int) $sessions));
                $entityYear->set($now_date->month . '_pageviews', $this->Util
                    ->addVal($entityYear->get(
                        $now_date->month . '_pageviews'
                    ), (int) $screenPageViews));
                $entityYear->set($now_date->month . '_users', $this->Util
                    ->addVal($entityYear->get(
                        $now_date->month . '_users'
                    ), (int) $newUsers));

                // 月別アクセスエンティティ
                $entityMonth->set($day . '_sessions', $this->Util
                    ->addVal($entityMonth->get(
                        $day . '_sessions'
                    ), (int) $sessions));
                $entityMonth->set($day . '_pageviews', $this->Util
                    ->addVal($entityMonth->get(
                        $day . '_pageviews'
                    ), (int) $screenPageViews));
                $entityMonth->set($day . '_users', $this->Util
                    ->addVal($entityMonth->get(
                        $day . '_users'
                    ), (int) $newUsers));

                // 曜日別アクセスエンティティ
                $entityWeek->set($week['en'] . '_sessions', $this->Util
                    ->addVal($entityWeek->get(
                        $week['en'] . '_sessions'
                    ), (int) $sessions));
                $entityWeek->set($week['en'] . '_pageviews', $this->Util
                    ->addVal($entityWeek->get(
                        $week['en'] . '_pageviews'
                    ), (int) $screenPageViews));
                $entityWeek->set($week['en'] . '_users', $this->Util
                    ->addVal($entityWeek->get(
                        $week['en'] . '_users'
                    ), (int) $newUsers));

                // データが存在しない場合は先にインサートする
                if (!$isFirstYearData) {
                    if (!$this->AccessYears->save($entityYear)) {
                        throw new RuntimeException($action_name . 'レコードの登録に失敗しました。');
                    }
                } else {
                    array_push($entities_year,  $entityYear);
                }
                if (!$isFirstWeekData) {
                    if (!$this->AccessWeeks->save($entityWeek)) {
                        throw new RuntimeException($action_name . 'レコードの登録に失敗しました。');
                    }
                } else {
                    array_push($entities_week,  $entityWeek);
                }
                if (!$isFirstMonthData) {
                    if (!$this->AccessMonths->save($entityMonth)) {
                        throw new RuntimeException($action_name . 'レコードの登録に失敗しました。');
                    }
                } else {
                    array_push($entities_month, $entityMonth);
                }
            } else {
                // それ以外のURLの場合
                continue;
            }

            try {
                // レコードを一括登録する
                if (count($entities_year) > 0) {
                    if (!$this->AccessYears->saveMany($entities_year)) {
                        throw new RuntimeException($action_name . 'レコードの登録に失敗しました。');
                    }
                }
                if (count($entities_week) > 0) {
                    if (!$this->AccessWeeks->saveMany($entities_week)) {
                        throw new RuntimeException($action_name . 'レコードの登録に失敗しました。');
                    }
                }
                if (count($entities_month) > 0) {
                    if (!$this->AccessMonths->saveMany($entities_month)) {
                        throw new RuntimeException($action_name . 'レコードの登録に失敗しました。');
                    }
                }
            } catch (RuntimeException $e) {
                Log::error(__LINE__ . '::' . __METHOD__ . "::バッチ処理が失敗しました。" . $e, "batch_ar");
                $result = false; // 異常終了フラグ
            }
        }

        return $result;
    }
}
