<?php

namespace App\Controller\Component;

use Cake\Log\Log;
use Cake\I18n\Time;
use RuntimeException;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component;
use Cake\Database\Schema\TableSchema;

class UtilComponent extends Component {

    public $components = ['S3Client'];

    /**
     * arrの指定keyで同じ値をグループ化する
     *
     * @param [type] $arr
     * @param [type] $key
     * @return void
     */
    public function groupArray($arr, $key) {
        $retval = array();

        foreach ($arr as $value) {
            $group = $value[$key];

            if (!isset($retval[$group])) {
                $retval[$group] = array();
            }

            $retval[$group][] = $value;
        }

        return $retval;
    }
    /**
     * 更新日時順で並び替える関数
     * @param mixed
     * @param mixed
     * @return mixed
     */
    public function sortByLastmod($a, $b) {
        return filemtime($b) - filemtime($a);
    }

    /**
     * 引数の値を合算する
     *
     * @param mixed
     * @param mixed
     * @return mixed
     */
    public function addVal($val = null, $addVal = null) {
        if (is_null($val)) {
            $val = 0;
        }
        $val = $val + $addVal;
        return $val;
    }

    /**
     * null値の時にデフォルト値を返却する
     *
     * 引数1がnull値なら戻り値は引数2の値を返す。
     * 引数1がnull値じゃない場合は戻り値は引数1の値を返す。
     *
     * @param mixed
     * @param mixed
     * @return mixed
     */
    public function ifnull($target = null) {
        if (!is_null($target)) {
            return $target;
        }

        return '';
    }

    /**
     * null値の時にデフォルト値を返却する
     *
     * 引数1がnull値なら戻り値は引数2の値を返す。
     * 引数1がnull値じゃない場合は戻り値は引数1の値を返す。
     *
     * @param mixed
     * @param mixed
     * @return mixed
     */
    public function ifnullString($target = null) {
        if ($target !== '') {
            return $target;
        }

        return null;
    }

    /**
     * ランダム文字列生成 (英数字)
     * $length: 生成する文字数
     */
    public function makeRandStr($length) {
        $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $r_str = null;
        for ($i = 0; $i < $length; $i++) {
            $r_str .= $str[rand(0, count($str) - 1)];
        }
        return $r_str;
    }

    /**
     * ユーザー情報を取得する。
     *
     * @return void
     */
    public function getUserInfo($user) {
        // TODO: Authセッションからオーナー情報を取得せず、shopsテーブルから取る？
        $userInfo = array();

        $userInfo = $userInfo + array(
            'id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'created' => $user['created']->format('Y年m月d日')
        );
        return  $userInfo;
    }


    /**
     * オーナー情報を取得する。
     *
     * @return void
     */
    public function getOwnerInfo($owner) {
        // TODO: Authセッションからオーナー情報を取得せず、shopsテーブルから取る？
        $ownerInfo = array();

        $ownerInfo = $ownerInfo + array('id' => $owner['id']);
        $ownerInfo = $ownerInfo + array(
            'current_plan' => $owner->servece_plans[0]->current_plan
            , 'previous_plan' => $owner->servece_plans[0]->previous_plan
        );

        return  $ownerInfo;
    }

    /**
     * オーナー情報を取得する。
     *
     * @return void
     */
    public function getDeveloperInfo($developer) {
        // TODO: Authセッションからオーナー情報を取得せず、shopsテーブルから取る？
        $developerInfo = array();
        $developerInfo = $developerInfo + array(
            'news_path' => DS . PATH_ROOT['URL_S3_BUCKET']
                . DS . PATH_ROOT['DEVELOPER'] . DS . PATH_ROOT[NEWS], 'id' => $developer['id']
        );
        return  $developerInfo;
    }

    /**
     * 店舗情報を取得する。
     *
     * @return void
     */
    public function getShopInfo($shop) {
        // TODO: Authセッションからオーナー情報を取得せず、shopsテーブルから取る？
        $shopArea = $shop['area'];
        $shopGenre = $shop['genre'];
        $shopDir = $shop['dir'];
        $areas = AREA;
        $genres = GENRE;
        $shopInfo = array();
        foreach ($areas as $area) {
            if ($area['path'] == $shopArea) {
                $shopInfo = $shopInfo + array('area' => $area);
                break;
            }
        }
        foreach ($genres as $genre) {
            if ($genre['path'] == $shopGenre) {
                $shopInfo = $shopInfo + array('genre' => $genre);
                break;
            }
        }
        $shopInfo = $shopInfo + array(
            'id' => $shop['id'], 'dir' => $shop['dir'], 'name' => $shop['name']
        );
        $path = PATH_ROOT['SHOPS'] . DS . $shop['dir'];

        $shop_url = PUBLIC_DOMAIN . DS . $shopInfo['area']['path']
            . DS . $shopInfo['genre']['path'] . DS . $shop['id'];

        $shopInfo = $shopInfo + array(
            'shop_path' => $path, 'cast_path' => $path . DS . PATH_ROOT['CAST'],
            'top_image_path' => $path . DS . PATH_ROOT['TOP_IMAGE'],
            'image_path' => $path . DS . PATH_ROOT['IMAGE'],
            'notice_path' => $path . DS . PATH_ROOT['NOTICE'],
            'cache_path' => $path . DS . PATH_ROOT['CACHE'],
            'tmp_path' => $path . DS . PATH_ROOT['TMP'],
            'shop_url' => $shop_url,
            'current_plan' => $shop->owner->servece_plan->current_plan, 'previous_plan' => $shop->owner->servece_plan->previous_plan
        );
        return  $shopInfo;
    }

    /**
     * スタッフ情報を取得する。
     *
     * @return void
     */
    public function getCastInfo($cast, $shop) {
        // TODO: Authセッションからオーナー情報を取得せず、shopsテーブルから取る？
        $shopArea = $shop['area'];
        $shopGenre = $shop['genre'];
        $shopDir = $shop['dir'];
        $areas = AREA;
        $genres = GENRE;
        $castInfo = array();
        foreach ($areas as $area) {
            if ($area['path'] == $shopArea) {
                $castInfo = $castInfo + array('area' => $area);
                break;
            }
        }
        foreach ($genres as $genre) {
            if ($genre['path'] == $shopGenre) {
                $castInfo = $castInfo + array('genre' => $genre);
                break;
            }
        }
        $castInfo = $castInfo + array(
            'id' => $cast['id'],
            'shop_id' => $shop['id'],
            'dir' => $cast['dir'],
            'shop_dir' => $shopDir
        );
        $path = PATH_ROOT['SHOPS'] . DS . $shop['dir']
            . DS . PATH_ROOT['CAST'] . DS . $cast['dir'];

        $shop_url = PUBLIC_DOMAIN . DS . $castInfo['area']['path']
            . DS . $castInfo['genre']['path'] . DS . $shop['id'];
        $cast_url = PUBLIC_DOMAIN . DS . $castInfo['area']['path']
            . DS . PATH_ROOT['CAST'] . DS . $castInfo['id'];

        $castInfo = $castInfo + array(
            'cast_path' => $path,
            'top_image_path' => $path . DS . PATH_ROOT['TOP_IMAGE'],
            'image_path' => $path . DS . PATH_ROOT['IMAGE'],
            'icon_path' => $path . DS . PATH_ROOT['ICON'],
            'schedule_path' => $path . DS . PATH_ROOT['SCHEDULE'],
            'diary_path' => PATH_ROOT['SHOPS'] . DS . $shop['dir'] . DS . PATH_ROOT['DIARY'],
            // 'tmp_path' => $path . DS . PATH_ROOT['TMP'],
            // 'cache_path' => $path . DS . PATH_ROOT['CACHE'],
            'shop_url' => $shop_url, 'cast_url' => $cast_url,
            'current_plan' => $shop->owner->servece_plan->current_plan, 'previous_plan' => $shop->owner->servece_plan->previous_plan
        );

        return  $castInfo;
    }

    /**
     * クレジットリストを作成する
     *
     * @param object $credit
     * @param array $masCredit
     * @return void
     */
    public function getCredit($credit, $masCredit) {
        $creditsList = array();
        // クレジットが登録されてる場合は配列にセットする
        !empty($credit) ? $array = explode(',', $credit) : $array = array();

        for ($i = 0; $i < count($array); $i++) {
            foreach ($masCredit as $key => $value) {
                if ($array[$i] == $value->code) {
                    $creditsList[] = array('tag' => $value->code, 'image' => PATH_ROOT['CREDIT'] . $value->code . ".png", 'id' => $value->id);
                    continue;
                }
            }
        }
        return $creditsList;
    }

    /**
     * 待遇リストを作成する
     *
     * @param [type] $treatment
     * @param [type] $query
     * @return void
     */
    public function getTreatment($treatment, $masTreatment) {
        $treatmentsList = array();
        // 待遇が登録されてる場合は配列にセットする
        !empty($treatment) ? $array = explode(',', $treatment) : $array = array();

        for ($i = 0; $i < count($array); $i++) {
            foreach ($masTreatment as $key => $value) {
                if ($array[$i] == $value->code_name) {
                    $treatmentsList[] = array('tag' => $value->code_name, 'id' => $value->code);
                    continue;
                }
            }
        }
        return $treatmentsList;
    }

    /**
     * セレクトボックス用リストを作成する
     *
     * @param [type] $masterCodesFind
     * @param [type] $masterCodeEntity
     * @param [type] $flag
     * @return void
     */
    public function getSelectList($masterCodesFind = null, $masterCodeEntity = null, $flag = null) {
        $result = array();
        for ($i = 0; $i < count($masterCodesFind); $i++) {
            $query = $masterCodeEntity->find('list', [
                'keyField' => 'code',
                'valueField' => 'code_name'
            ])->where(['code_group' => $masterCodesFind[$i]]);
            $result = array_merge($result, array($masterCodesFind[$i] => $query->toArray()));
        }
        // 年齢リストを作成するか
        if (!empty($flag)) {
            $ageList = array();
            for ($i = 18; $i <= 99; $i++) {
                $ageList[$i] = $i;
            }
            $result = array_merge($result, array('age' => $ageList));
        }

        return $result;
    }

    /**
     * スタッフの全ての日記情報を取得する処理
     *
     * @param [type] $cast_id
     * @param [type] $diary_path
     * @param [type] $user_id
     * @return array
     */
    public function getDiarys($cast_id, $diary_path, $user_id = null) {
        $diarys = TableRegistry::get('diarys');

        $subquery = TableRegistry::get('users')->find()
            ->distinct()
            ->select(['like' => 'd.id'])
            ->join([
                'dl' => [
                    'table' => 'diary_likes',
                    'type' => 'INNER',
                    'conditions' => 'dl.user_id = ' . $user_id,
                ],
                'd' => [
                    'table' => 'diarys',
                    'type' => 'INNER',
                    'conditions' => 'd.id = dl.diary_id',
                ],
                's' => [
                    'table' => 'shops',
                    'type' => 'INNER',
                    'conditions' => ['s.status = 1 AND s.delete_flag = 0'],
                ],
                'c' => [
                    'table' => 'casts',
                    'type' => 'INNER',
                    'conditions' => ['c.id = ' . $cast_id,
                        'c.status = 1 AND c.delete_flag = 0'],
                ]
            ]);

        // スタッフ情報、最新の日記情報とイイネの総数取得
        // 過去の日記をアーカイブ形式で取得する
        $query = $diarys->find('all')
            ->select($diarys->Schema()->columns())
            ->contain(['DiaryLikes' => function ($q) use ($user_id) {
                return $q
                ->select([
                    'DiaryLikes.diary_id', 'total' => $q->func()->count('DiaryLikes.diary_id')
                ])
                ->group('DiaryLikes.diary_id')
                ->where(['DiaryLikes.diary_id']);
            }])
            ->where(['cast_id' => $cast_id])
            ->order(['created' => 'DESC']);
        $ym = $query->func()->date_format([
            'created' => 'identifier',
            "'%Y/%c'" => 'literal'
        ]);
        $md = $query->func()->date_format([
            'created' => 'identifier',
            "'%c/%e'" => 'literal'
        ]);
        $archives = $query->select([
            'ym_created' => $ym,
            'md_created' => $md
        ])
        ->select('your_like.like')
        ->leftJoin(
            ['your_like' => $subquery],
            ['your_like.like = diarys.id']
        )
        ->toArray();

        $archives = $this->groupArray($archives, 'ym_created');
        $archives = array_values($archives);

        foreach ($archives as $key => $archive) {
            foreach ($archive as $key => $value) {
                $gallery = array();

                // 画像数をセット
                $listObjects = $this->S3Client->getListObjects($this->s3Backet, $diary_path . $value->dir);

                foreach ($listObjects['Contents'] as $Contents) {
                    $timestamp = date('Y/m/d H:i', strtotime($Contents['LastModified']));
                    array_push($gallery, array(
                        "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $Contents['Key'], "date" => $timestamp
                    ));
                    continue; // １件のみ取得できればよい
                }
                $value->set('gallery', $gallery);
                // 画像数をセット
                $value->set('gallery_count', count($listObjects['Contents']));
            }
        }


        return $archives;
    }

    /**
     * 指定した１件の日記情報を取得する処理
     *
     * @param [type] $id
     * @param [type] $diary_path
     * @param [type] $user_id
     * @return array
     */
    public function getDiary($id, $diary_path, $user_id) {
        $diary = TableRegistry::get('diarys');
        $query = $diary->find('all')
            ->select($diary)
            ->contain(['DiaryLikes' => function ($q) use ($user_id) {
                $main = $q
                    ->select([
                       'diary_id', 'user_id', 'total' => $q->func()->count('DiaryLikes.diary_id')
                    ])
                    ->group('diary_id', 'user_id');

                return $main->leftJoinWith('Users', function ($sub) use ($user_id) {
                    return $sub->select(['is_like' => $sub->func()->count('Users.id')])
                        ->where(['Users.id' => $user_id]);
                });
            }]);
        $ymd = $query->func()->date_format([
            'created' => 'identifier',
            "'%Y年%c月%e日'" => 'literal'
        ]);
        $diary = $query->select([
            'ymd_created' => $ymd
        ])
            ->where(['id' => $id])
            ->first();

        $listObjects = $this->S3Client->getListObjects($this->s3Backet, $diary_path . $diary->dir);

        $gallery = array();

        foreach ($listObjects['Contents'] as $Contents) {
            $timestamp = date('Y/m/d H:i', strtotime($Contents['LastModified']));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $Contents['Key'], "date" => $timestamp
            ));
        }

        $diary->set('gallery', $gallery);

        return $diary;
    }


    /**
     * 日記テーブルから最新の日記情報とイイネの総数を取得する処理
     *
     * @param [type] $row_num
     * @param [type] $is_area
     * @param [type] $shop_id
     * @return array
     */
    public function getNewDiarys($row_num, $is_area = null, $shop_id = null, $user_id) {
        $this->Diarys = TableRegistry::get('diarys');
        $this->Casts = TableRegistry::get('Casts');
        $this->Shops = TableRegistry::get('Shops');
        $this->DiaryLikes = TableRegistry::get('DiaryLikes');

        if (!empty($shop_id)) {
            $subquery = TableRegistry::get('users')->find()
                ->distinct()
                ->select(['like' => 'd.id'])
                ->join([
                    'dl' => [
                        'table' => 'diary_likes',
                        'type' => 'INNER',
                        'conditions' => 'dl.user_id = ' . $user_id,
                    ],
                    'd' => [
                        'table' => 'diarys',
                        'type' => 'INNER',
                        'conditions' => 'd.id = dl.diary_id',
                    ],
                    's' => [
                        'table' => 'shops',
                        'type' => 'INNER',
                        'conditions' => ['s.id = ' . $shop_id . ' AND s.status = 1 AND s.delete_flag = 0'],
                    ],
                    'c' => [
                        'table' => 'casts',
                        'type' => 'INNER',
                        'conditions' => ['c.status = 1 AND c.delete_flag = 0'],
                    ]
                ]);

            // 最新のスタッフブログ情報とイイネの総数取得
            $diarys = $this->Diarys->find()
                ->contain(['Casts.Shops' => function ($q) use ($shop_id) {
                    $conditions = 'Shops.id = ' . $shop_id
                        . ' AND Shops.status = 1 AND Shops.delete_flag = 0'
                        . ' AND Casts.status = 1 AND Casts.delete_flag = 0';
                    return $q
                        ->where([$conditions]);
                }, 'DiaryLikes' => function ($q) use ($user_id) {
                    $main = $q
                        ->select([
                            'diary_id', 'user_id', 'total' => $q->func()->count('diary_id')
                        ])
                        ->group('diary_id')
                        ->where(['diary_id']);
                    return $main;
                }])
                ->select()
                ->select(['your_like.like'])
                ->leftJoin(
                    ['your_like' => $subquery],
                    ['your_like.like = diarys.id']
                )
                ->select($this->Diarys)
                ->select($this->Casts)
                ->select($this->Shops)
                ->order(['diarys.created' => 'DESC'])
                ->limit($row_num)->toArray();
        } else {

            $subquery = TableRegistry::get('users')->find()
                ->distinct()
                ->select(['like' => 'd.id'])
                ->join([
                    'dl' => [
                        'table' => 'diary_likes',
                        'type' => 'INNER',
                        'conditions' => ['dl.user_id = ' . $user_id],
                    ],
                    'd' => [
                        'table' => 'diarys',
                        'type' => 'INNER',
                        'conditions' => ['d.id = dl.diary_id'],
                    ],
                    's' => [
                        'table' => 'shops',
                        'type' => 'INNER',
                        'conditions' => ['s.status = 1 AND s.delete_flag = 0'],
                    ],
                    'c' => [
                        'table' => 'casts',
                        'type' => 'INNER',
                        'conditions' => ['c.status = 1 AND c.delete_flag = 0'],
                    ]
                ]);

            // 最新のスタッフブログ情報とイイネの総数取得
            $diarys = $this->Diarys->find()
                ->contain(['Casts' => function ($q) { return $q->select(); },
                    'Casts.Shops' => function ($q) use ($is_area) {
                        // トップページ
                        if (empty($is_area)) {
                            $conditions = 'Shops.status = 1 AND Shops.delete_flag = 0'
                                . ' AND Casts.status = 1 AND Casts.delete_flag = 0';
                        } else {
                            // エリアトップページ
                            $conditions = 'area = "' . $is_area . '" AND '
                                . 'Shops.status = 1 AND Shops.delete_flag = 0'
                                . ' AND Casts.status = 1 AND Casts.delete_flag = 0';
                        }
                        return $q
                            ->where([$conditions]);
                    }, 'DiaryLikes' => function ($q) {
                        $main = $q
                            ->select([
                                'diary_id', 'user_id', 'total' => $q->func()->count('diary_id')
                            ])
                            ->group('diary_id')
                            ->where(['diary_id']);
                        return $main;
                    }
                ])
                ->select()
                ->select(['your_like.like'])
                ->leftJoin(
                    ['your_like' => $subquery],
                    ['your_like.like = diarys.id']
                )
                ->select($this->Diarys)
                ->select($this->Casts)
                ->select($this->Shops)
                ->order(['diarys.created' => 'DESC'])
                ->limit($row_num)->toArray();
        }

        foreach ($diarys as $key => $diary) {
            $diaryPath = PATH_ROOT['SHOPS'] . DS . $diary->cast->shop->dir
                . DS . PATH_ROOT['CAST']
                . DS . $diary->cast->dir
                . DS . PATH_ROOT['DIARY'] . $diary->dir;

            // 画像数をセット
            $imgCount = $this->S3Client->getList($this->s3Backet, $diaryPath);
            $diary->set('gallery_count', is_countable($imgCount) ? count($imgCount) : 0);

            $profilePath = PATH_ROOT['SHOPS'] . DS . $diary->cast->shop->dir
                . DS . PATH_ROOT['CAST']
                . DS . $diary->cast->dir
                . DS . PATH_ROOT['ICON'];

            $files = $this->S3Client->getList($this->s3Backet, $profilePath, 1);
            (is_countable($files) ? count($files) : 0 > 0) ? $icon = PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0] : $icon = PATH_ROOT['NO_IMAGE01'];
            // アイコン画像をセット
            $diary->set('icon', $icon);
        }

        return $diarys;
    }

    /**
     * 店舗の全てのお知らせ情報を取得する処理
     *
     * @param [type] $shop_id
     * @param [type] $notice_path
     * @param [type] $user_id
     * @return array
     */
    public function getNotices($shop_id, $notice_path, $user_id = null) {
        $shopInfos = TableRegistry::get('shop_infos');

        $subquery = TableRegistry::get('users')->find()
            ->distinct()
            ->select(['like' => 'si.id'])
            ->join([
                'sil' => [
                    'table' => 'shop_info_likes',
                    'type' => 'INNER',
                    'conditions' => 'sil.user_id = ' . $user_id,
                ],
                'si' => [
                    'table' => 'shop_infos',
                    'type' => 'INNER',
                    'conditions' => 'si.id = sil.Shop_info_id',
                ],
                's' => [
                    'table' => 'shops',
                    'type' => 'INNER',
                    'conditions' => ['s.status = 1 AND s.delete_flag = 0'],
                ]
            ]);

        // 最新の店舗ニュース情報とイイネの総数取得
        // 過去のニュースをアーカイブ形式で取得する
        $query = $shopInfos->find('all')
            ->select($shopInfos->Schema()->columns())
            ->contain(['ShopInfoLikes' => function ($q) {
                $main = $q
                    ->select([
                        'shop_info_id', 'user_id', 'total' => $q->func()->count('shop_info_id')
                    ])
                    ->group('shop_info_id')
                    ->where(['shop_info_id']);
                return $main;
            }])
            ->where(['shop_id' => $shop_id])
            ->select()
            ->select(['your_like.like'])
            ->leftJoin(
                ['your_like' => $subquery],
                ['your_like.like = shop_infos.id']
            )
            ->select(TableRegistry::get('shop_infos'))
            ->order(['created' => 'DESC']);
        $ym = $query->func()->date_format([
            'created' => 'identifier',
            "'%Y/%c'" => 'literal'
        ]);
        $md = $query->func()->date_format([
            'created' => 'identifier',
            "'%c/%e'" => 'literal'
        ]);
        $archives = $query->select([
            'ym_created' => $ym,
            'md_created' => $md
        ])
            ->toArray();

        $archives = $this->groupArray($archives, 'ym_created');
        $archives = array_values($archives);

        foreach ($archives as $key => $archive) {
            foreach ($archive as $key => $value) {
                $gallery = array();

                // 画像数をセット
                $listObjects = $this->S3Client->getListObjects($this->s3Backet, $notice_path . $value->dir);

                foreach ($listObjects['Contents'] as $Contents) {
                    $timestamp = date('Y/m/d H:i', strtotime($Contents['LastModified']));
                    array_push($gallery, array(
                        "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $Contents['Key'], "date" => $timestamp
                    ));
                    continue; // １件のみ取得できればよい
                }
                $value->set('gallery', $gallery);
                // 画像数をセット
                $value->set('gallery_count', count($listObjects['Contents']));
            }
        }

        return $archives;
    }

    /**
     * 指定した１件のお知らせ情報を取得する処理
     *
     * @param [type] $id
     * @param [type] $notice_path
     * @param [type] $user_id
     * @return array
     */
    public function getNotice($id, $notice_path, $user_id = null) {
        $shopInfo = TableRegistry::get('shop_infos');

        $query = $shopInfo->find('all')
            ->select($shopInfo->getSchema()->columns())
            ->contain(['ShopInfoLikes' => function ($q) use ($user_id) {
                $main = $q
                    ->select([
                       'shop_info_id', 'user_id', 'total' => $q->func()->count('shop_info_id')
                    ])
                    ->group('shop_info_id', 'user_id');

                return $main->leftJoinWith('Users', function ($sub) use ($user_id) {
                    return $sub->select(['is_like' => $sub->func()->count('Users.id')])
                        ->where(['Users.id' => $user_id]);
                });
            }]);
        $ymd = $query->func()->date_format([
            'created' => 'identifier',
            "'%Y年%c月%e日'" => 'literal'
        ]);
        $shopInfo = $query->select([
            'ymd_created' => $ymd
        ])
            ->where(['id' => $id])
            ->first();

        $listObjects = $this->S3Client->getListObjects($this->s3Backet, $notice_path . $shopInfo->dir);

        $gallery = array();

        foreach ($listObjects['Contents'] as $Contents) {
            $timestamp = date('Y/m/d H:i', strtotime($Contents['LastModified']));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $Contents['Key'], "date" => $timestamp
            ));
        }

        $shopInfo->set('gallery', $gallery);

        return $shopInfo;
    }

    /**
     * 日記テーブルから最新の日記情報を取得する処理
     *
     * @param [type] $row_num
     * @param [type] $is_area
     * @param [type] $user_id
     * @return void
     */
    public function getNewNotices($row_num, $is_area = null, $user_id = null) {
        $shopInfos = TableRegistry::get('shop_infos');

        $subquery = TableRegistry::get('users')->find()
            ->distinct()
            ->select(['like' => 'si.id'])
            ->join([
                'sil' => [
                    'table' => 'shop_info_likes',
                    'type' => 'INNER',
                    'conditions' => 'sil.user_id = ' . $user_id,
                ],
                'si' => [
                    'table' => 'shop_infos',
                    'type' => 'INNER',
                    'conditions' => 'si.id = sil.Shop_info_id',
                ],
                's' => [
                    'table' => 'shops',
                    'type' => 'INNER',
                    'conditions' => ['s.status = 1 AND s.delete_flag = 0'],
                ]
            ]);

        // 最新の店舗ニュース情報とイイネの総数取得
        $shopInfos = $shopInfos->find('all')
            ->contain(['Shops' => function ($q) use ($is_area) {
                // トップページ
                if (empty($is_area)) {
                    $conditions = 'status = 1 AND delete_flag = 0';
                } else {
                    // エリアトップページ
                    $conditions = 'area = "' . $is_area . '" AND status = 1 AND delete_flag = 0';
                }
                return $q
                    ->where([$conditions]);
            }, 'ShopInfoLikes' => function ($q) {
                    $main = $q
                        ->select([
                            'shop_info_id', 'user_id', 'total' => $q->func()->count('shop_info_id')
                        ])
                        ->group('shop_info_id')
                        ->where(['shop_info_id']);
                    return $main;
            }])
            ->select()
            ->select(['your_like.like'])
            ->leftJoin(
                ['your_like' => $subquery],
                ['your_like.like = shop_infos.id']
            )
            ->select(TableRegistry::get('shop_infos'))
            ->select(TableRegistry::get('Shops'))
            ->order(['shop_infos.created' => 'DESC'])
            ->limit($row_num)->toArray();

        foreach ($shopInfos as $key => $shopInfo) {
            $noticePath = PATH_ROOT['SHOPS'] . DS . $shopInfo->shop->dir
                . DS . PATH_ROOT['NOTICE'] . $shopInfo->dir;

            // 画像数をセット
            $imgCount = $this->S3Client->getList($this->s3Backet, $noticePath, 1);
            $shopInfo->set('gallery_count', is_countable($imgCount) ? count($imgCount) : 0);

            $topImageFullPath = PATH_ROOT['SHOPS'] . DS . $shopInfo->shop->dir
                . DS . PATH_ROOT['TOP_IMAGE'];

            $topImagePath = PATH_ROOT['SHOPS'] . DS . $shopInfo->shop->dir
                . DS . PATH_ROOT['TOP_IMAGE'];

            $files = $this->S3Client->getList($this->s3Backet, $topImageFullPath, 1);
            count($files) > 0 ? $icon = PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0] : $icon = PATH_ROOT['NO_IMAGE01'];

            // アイコン画像をセット
            $shopInfo->set('icon', $icon);
        }
        return $shopInfos;
    }

    /**
     * 指定した件数のニュースを取得する処理
     *
     * @param [type] $id
     * @param [type] $news_path
     * @param [type] $limit
     * @return array
     */
    public function getNewss($news_path = null, $limit = null) {
        $news = TableRegistry::get('news');
        // 最新のニュース情報取得
        // 過去のニュースをアーカイブ形式で取得する
        $query = $news->find('all')
            ->select($news->Schema()->columns())
            ->order(['created' => 'DESC'])
            ->limit($limit);
        $ym = $query->func()->date_format([
            'created' => 'identifier',
            "'%Y/%c'" => 'literal'
        ]);
        $md = $query->func()->date_format([
            'created' => 'identifier',
            "'%c/%e'" => 'literal'
        ]);
        $archives = $query->select([
            'ym_created' => $ym,
            'md_created' => $md
        ])
            ->toArray();

        $archives = $this->groupArray($archives, 'ym_created');
        $archives = array_values($archives);

        if (!is_null($news_path)) {

            foreach ($archives as $key => $archive) {
                foreach ($archive as $key => $value) {
                    $gallery = array();

                    // 画像数をセット
                    $listObjects = $this->S3Client->getListObjects($this->s3Backet, $news_path . $value->dir);

                    foreach ($listObjects['Contents'] as $Contents) {
                        $timestamp = date('Y/m/d H:i', strtotime($Contents['LastModified']));
                        array_push($gallery, array(
                            "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $Contents['Key'], "date" => $timestamp
                        ));
                        continue; // １件のみ取得できればよい
                    }
                    $value->set('gallery', $gallery);
                    // 画像数をセット
                    $value->set('gallery_count', count($listObjects['Contents']));
                }
            }
        }

        return $archives;
    }
    /**
     * 指定した１件のニュース情報を取得する処理
     *
     * @param [type] $id
     * @param [type] $news_path
     * @param [type] $user_id
     * @return array
     */
    public function getNews($id, $news_path) {
        $news = TableRegistry::get('news');
        $query = $news->find('all')
            ->select($news->Schema()->columns());
        $ymd = $query->func()->date_format([
            'created' => 'identifier',
            "'%Y年%c月%e日'" => 'literal'
        ]);
        $news = $query->select([
            'ymd_created' => $ymd
        ])
            ->where(['id' => $id])
            ->first();

        $listObjects = $this->S3Client->getListObjects($this->s3Backet, $news_path . $news->dir);

        $gallery = array();

        foreach ($listObjects['Contents'] as $Contents) {
            $timestamp = date('Y/m/d H:i', strtotime($Contents['LastModified']));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $Contents['Key'], "date" => $timestamp
            ));
        }

        $news->set('gallery', $gallery);

        // // ディクレトリ取得
        // $dir = new Folder(preg_replace('/(\/\/)/', '/', WWW_ROOT . $news_path), true, 0755);

        // $gallery = array();

        // /// 並び替えして出力
        // $files = glob($dir->path . $news['dir'] . DS . '*.*');
        // usort($files, $this->sortByLastmod);
        // foreach ($files as $file) {
        //     $timestamp = date('Y/m/d H:i', filemtime($file));
        //     array_push($gallery, array(
        //         "file_path" => $news_path . $news->dir . DS . (basename($file)), "date" => $timestamp
        //     ));
        // }
        // $news->set('gallery', $gallery);

        return $news;
    }

    /**
     * 広告情報を取得する処理
     *
     * @param [type] $max_num
     * @param [type] $target
     * @param [type] $area
     * @return void
     */
    public function getAdsense($max_num, $target, $area = null) {
        $adsenses = TableRegistry::get('adsenses');
        $shops = TableRegistry::get('shops');

        // エリアが存在した場合
        if (!empty($area)) {
            // メイン広告の場合
            if ($target == 'main') {
                $adsense_list = $adsenses->find('all')
                    ->where([
                        'area_show_flg' => 1, 'type' => 'main', 'adsenses.area' => $area, 'NOW() BETWEEN valid_start AND valid_end'
                    ])
                    ->contain(['shops'])
                    ->where(['status = 1 AND delete_flag = 0'])
                    ->order(['area_order' => 'ASC'])
                    ->limit($max_num)->all()->toArray();
            } else if ($target == 'sub') {
                // サブ広告の場合
                $adsense_list = $adsenses->find('all')
                    ->where([
                        'area_show_flg' => 1, 'type' => 'sub', 'adsenses.area' => $area, 'NOW() BETWEEN valid_start AND valid_end'
                    ])
                    ->contain(['shops'])
                    ->where(['status = 1 AND delete_flag = 0'])
                    ->order(['area_order' => 'ASC'])
                    ->limit($sub_num)->all()->toArray();
            }
        } else {
            // メイン広告の場合
            if ($target == 'main') {
                $adsense_list = $adsenses->find('all')
                    ->where([
                        'top_show_flg' => 1, 'type' => 'main', 'NOW() BETWEEN valid_start AND valid_end'
                    ])
                    ->contain(['shops'])
                    ->where(['status = 1 AND delete_flag = 0'])
                    ->order(['top_order' => 'ASC'])
                    ->limit($max_num)->all()->toArray();
            } else if ($target == 'sub') {
                // サブ広告の場合
                $adsense_list = $adsenses->find('all')
                    ->where([
                        'top_show_flg' => 1, 'type' => 'sub', 'NOW() BETWEEN valid_start AND valid_end'
                    ])
                    ->contain(['shops'])
                    ->where(['status = 1 AND delete_flag = 0'])
                    ->order(['top_order' => 'ASC'])
                    ->limit($sub_num)->all()->toArray();
            }
        }

        // 広告のデータセット
        foreach ($adsense_list as $key => $adsense) {

            // 画像パスが存在する場合
            if (!empty($adsense->name)) {
                $shop_url = PUBLIC_DOMAIN . DS . $adsense->Shops['area']
                    . DS . $adsense->Shops['genre'] . DS . $adsense->Shops['id'];
                $adsense->set('shop_url', $shop_url);
                $adsense->set('img_path', PATH_ROOT['URL_S3_BUCKET'] . DS . $adsense->name);
            } else {
                // 画像が存在しない場合は、エンティティを削除する
                unset($adsense_list[$key]);
            }
        }
        // 広告データが取得出来ない場合は、泣く泣くランダムで取得する
        // ※誰も広告に載せたくないんかい(# ﾟДﾟ)！
        if (empty($adsense_list)) {
            // エリアが存在する場合
            if (!empty($area)) {
                $ids = $shops->find('list', array(
                    'fields' => 'id',
                    'order' => 'RAND()',
                    'limit' => $max_num
                ))
                    ->where(['area' => $area, 'status = 1 AND delete_flag = 0'])
                    ->toArray();
            } else {
                $ids = $shops->find('list', array(
                    'fields' => 'id',
                    'order' => 'RAND()',
                    'limit' => $max_num
                ))
                    ->where(['status = 1 AND delete_flag = 0'])
                    ->toArray();
            }
            // idが取得出来た場合
            if (!empty($ids)) {
                // 取得したidで条件検索
                $adsense_list = $shops->find()->where(['id IN' => $ids])->toArray();
            }

            // 広告のデータセット
            foreach ($adsense_list as $key => $adsense) {
                $shopInfo = $this->getShopInfo($adsense);
                // トップ画像を設定する
                $files = $this->S3Client->getList($this->s3Backet, $shopInfo['top_image_path'], 1);

                // ファイルが存在したら、画像をセット
                if (count($files) > 0) {
                    foreach ($files as $file) {

                        $adsense->set('img_path', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
                        $adsense->set('shop_url', $shopInfo['shop_url']);
                    }
                } else {
                    // 共通トップ画像をセット
                    $adsense->set('img_path', PATH_ROOT['SHOP_TOP_IMAGE']);
                    $adsense->set('shop_url', $shopInfo['shop_url']);
                }
            }

            // それでも空ならNO IMAGEファイルをセットする
            if (empty($adsense_list)) {
                $adsense = $shops->newEntity();
                // 共通トップ画像をセット
                $adsense->set('img_path', PATH_ROOT['SHOP_TOP_IMAGE']);
                array_push($adsense_list, $adsense);
            }
        }

        return $adsense_list;
    }

    /**
     * ファイルアップロードの処理
     *
     * @param array $file
     * @param array $files_befor
     * @param string $dir
     * @param integer $limitFileSize
     * @return void
     */
    public function file_upload(
        array $file = null,
        array $files_befor = null,
        bool $chkDuplicate,
        string $dir,
        int $limitFileSize
    ) {
        try {
            // 未定義、複数ファイル、破損攻撃のいずれかの場合は無効処理
            if (!isset($file['error']) || is_array($file['error'])) {
                throw new RuntimeException('Invalid parameters.');
            }

            // エラーのチェック
            switch ($file['error']) {
                case 0:
                    break;
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }

            // ファイル情報取得
            $fileInfo = new File($file["tmp_name"]);

            // ファイルサイズのチェック
            if ($fileInfo->size() > $limitFileSize) {
                throw new RuntimeException('Exceeded filesize limit.');
            }

            // ファイルタイプのチェックし、拡張子を取得
            if (false === $ext = array_search(
                $fileInfo->mime(),
                [
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ],
                true
            )) {
                throw new RuntimeException('Invalid file format.');
            }

            // ファイル名の生成
            //            $uploadFile = $file["name"] . "." . $ext;
            $uploadFile = sha1_file($file["tmp_name"]) . "." . $ext;

            // DBにデータがある場合にアップされるファイルを比較する
            if ($chkDuplicate) {
                $isFile = array_search($dir . DS . $uploadFile, array_column($files_befor, 'simple_path'));
                // ファイル名が同じ場合は処理を中断する
                if ($isFile !== false) {
                    return false;
                }
            }
        } catch (RuntimeException $e) {
            throw $e;
        }
        return $uploadFile;
    }

    /**
     * 一時ディレクトリにバックアップを作成する
     *
     * @param String $tmpPath
     * @param File $dir
     * @return void
     */
    public function createTmpDirectoy(string $tmpPath, Folder $dir) {
        // "/$tmpPath/{現在の時間}"というディレクトリをパーミッション777で作ります
        $result = new Folder;
        $tmpDir = new Folder($tmpPath . DS . time(), true, 0777);
        $dir->copy($tmpDir->path);
        return $tmpDir;
    }

    /**
     * エラーメッセージをセットする
     *
     * @param Diary $validate
     * @return $errors
     */
    public function setErrMessage($validate) {
        $errors = ""; // メッセージ格納用
        foreach ($validate->errors() as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2) {
                if (is_array($value2)) {
                    foreach ($value2 as $key3 => $value3) {
                        $errors .= $value3 . "<br/>";
                    }
                } else {
                    $errors .= $value2 . "<br/>";
                }
            }
        }
        return $errors;
    }

    /**
     * 検索対象、置換対象を配列で順番通りに置換する処理
     *
     * @param [type] $search
     * @param [type] $replace
     * @param [type] $target
     * @return void
     */
    public function strReplace($search, $replace, $target) {
        $result = "";
        $result = str_replace($search, $replace, $target);
        return $result;
    }

    /**
     * 日付けで取得(yyyy-mm-dd (day)))
     *
     * @return void
     */
    public function getPeriodDate() {
        $week = [
            '日', //0
            '月', //1
            '火', //2
            '水', //3
            '木', //4
            '金', //5
            '土', //6
        ];
        $date = date('Y-m');
        $startDate = date('Y-m-d', strtotime('first day of ' . $date));
        $endDate = date('Y-m-d', strtotime(date('Y-m-t', strtotime($startDate . '+' . 1 . 'month'))));
        $diff = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
        for ($i = 0; $i <= $diff; $i++) {
            $dateFormat = date('m/d w', strtotime($startDate . '+' . $i . 'days'));
            $period[] = substr_replace($dateFormat, '(' . $week[substr($dateFormat, -1)] . ')', -1);
        }
        return $period;
    }

    /**
     * 月(yyyy-mm)で取得
     *
     * @return void
     */
    public function getPeriodMonth() {
        $startDate = date('Y-m-d', strtotime('2017-01-06'));
        $endDate = date('Y-m-d', strtotime("2018-01-09"));
        $diff = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24 * 30);
        for ($i = 0; $i <= $diff; $i++) {
            $period[] = date('Y-m', strtotime($startDate . '+' . $i . 'month'));
        }
        return $period;
    }

    /**
     * 指定曜日を返す
     * @return void
     */
    public function getWeek($week) {
        $array_week = array();

        switch ($week) {
            case 0:
                $array_week = ["en" => "sunday", "ja" => "日曜日"];
                break;
            case 1:
                $array_week = ["en" => "monday", "ja" => "月曜日"];
                break;
            case 2:
                $array_week = ["en" => "tuesday", "ja" => "火曜日"];
                break;
            case 3:
                $array_week = ["en" => "wednesday", "ja" => "水曜日"];
                break;
            case 4:
                $array_week = ["en" => "thursday", "ja" => "木曜日"];
                break;
            case 5:
                $array_week = ["en" => "friday", "ja" => "金曜日"];
                break;
            case 6:
                $array_week = ["en" => "saturday", "ja" => "土曜日"];
                break;
        }
        return $array_week;
    }

    /**
     * 指定範囲内の日付かチェック
     *
     * @param [type] $start_date
     * @param [type] $end_date
     * @param [type] $date_from_user
     * @return void
     */
    public function check_in_range($start_date, $end_date, $date_from_user) {
        // Convert to timestamp
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($date_from_user);

        // Check that user date is between start & end
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }

    /**
     * 指定ディレクトリ以下の指定ファイルを取得する処理
     *
     * @param [type] $dir
     * @param [type] $exp
     * @return array
     */
    function scanDir($dir, $exp) {
        $list = $tmp = array();
        foreach (glob($dir . '*/', GLOB_ONLYDIR) as $child) {
            if ($tmp = self::scanDir($child, $exp)) {
                $list = array_merge($list, $tmp);
            }
        }
        foreach (glob($dir . '{' . $exp . '}', GLOB_BRACE) as $file) {
            $list[] = $file;
        }
        return $list;
    }

    /**
     * インスタAPIにアクセスし情報を取得する処理
     *
     * @param [type] $insta_user_name
     * @param [type] $insta_business_name
     * @param [type] $insta_business_id
     * @param [type] $access_token
     * @return $instagram_data
     */
    public function getInstagram(
        $insta_user_name = null,
        $insta_business_name = null,
        $current_plan = null,
        $cache_path,
        $dat_file_name
    ) {

        //////////////////////
        /*     初期設定     */
        //////////////////////

        // 投稿の最大取得数
        $max_posts      = API['INSTAGRAM_MAX_POSTS'];

        // Graph API の URL
        $graph_api      = API['INSTAGRAM_GRAPH_API'];

        // ビジネスID
        $ig_buisiness   = API['INSTAGRAM_BUSINESS_ID'];

        // 無期限のページアクセストークン
        $access_token   = API['INSTAGRAM_GRAPH_API_ACCESS_TOKEN'];

        //ここに取得したいInstagramビジネスアカウントのユーザー名を入力してください。
        //https://www.instagram.com/nightplanet91/なので
        //「nightplanet91」がユーザー名になります
        $target_user    = $insta_user_name;

        // キャッシュ時間の設定 (最短更新間隔 [sec])
        // 更新頻度が高いと Graph API の時間当たりの利用制限に引っかかる可能性があるので、30sec以上を推奨
        $cache_lifetime = API['INSTAGRAM_CACHE_TIME'];

        // 表示形式の初期設定 (グリッド表示の時は 'grid'、一覧表示の時は 'list' を指定)
        $show_mode      = API['INSTAGRAM_SHOW_MODE'];

        // プラン情報により、取得制限数をセット
        if ($current_plan == SERVECE_PLAN['basic']['label']) {
            $get_post_num = 12;
        } else if ($current_plan == SERVECE_PLAN['premium']['label']) {
            $get_post_num = 54;
        } else if ($current_plan == SERVECE_PLAN['premium_s']['label']) {
            $get_post_num = 120;
        } else if (empty($current_plan)) {
            $get_post_num = 120;
        }

        //自分が所有するアカウント以外のInstagramビジネスアカウントが投稿している写真も取得したい場合は以下
        if (!empty($target_user)) {
            $fields      = 'business_discovery.username(' . $target_user . ')
                          {id,name,username,profile_picture_url,followers_count,follows_count,media_count,ig_id
                              ,media.limit(' . $get_post_num . '){
                                  caption,media_url,media_type
                                  ,children{
                                      media_url,media_type
                                  }
                                  ,like_count,comments_count,timestamp,id
                              }
                          }';
        }

        $fields = str_replace(array("\r\n", "\r", "\n", "\t", " "), '', $fields);
        //////////////////////
        /* 初期設定ここまで */
        //////////////////////

        //////////////////////
        /*     取得処理     */
        //////////////////////

        /*
      キャッシュしておいたファイルが指定時間以内に更新されていたらキャッシュしたファイルのデータを使用する
      指定時間以上経過していたら新たに Instagaram Graph API へリクエストする
      */

        // キャッシュ用のディレクトリが存在するか確認
        // なければ作成する
        $result = new Folder($cache_path, true, 0755);

        // キャッシュファイルの最終更新日時を取得
        $cache_lastmodified = @filemtime('s3://' .env('AWS_BUCKET') . DS . $cache_path . DS . $dat_file_name);

        // 更新日時の比較
        if (!$cache_lastmodified) {
            // Graph API から JSON 形式でデータを取得
            $ig_json = @file_get_contents($graph_api . $ig_buisiness . '?fields=' . $fields . '&access_token=' . $access_token);
            // 取得したデータをキャッシュに保存する
            $stream = fopen('s3://' .env('AWS_BUCKET') . DS . $cache_path . DS . $dat_file_name, 'w');
            fwrite($stream, $ig_json);
            fclose($stream);
        } else {
            if (time() - $cache_lastmodified > $cache_lifetime) {
                // キャッシュの最終更新日時がキャッシュ時間よりも古い場合は再取得する
                $ig_json = @file_get_contents($graph_api . $ig_buisiness . '?fields=' . $fields . '&access_token=' . $access_token);
                // 取得したデータをキャッシュに保存する
                $stream = fopen('s3://' .env('AWS_BUCKET') . DS . $cache_path . DS . $dat_file_name, 'w');
                fwrite($stream, $ig_json);
                fclose($stream);
            } else {
                // キャッシュファイルが新しければキャッシュデータを使用する
                $ig_json = @file_get_contents('s3://' .env('AWS_BUCKET') . DS . $cache_path . DS . $dat_file_name);
            }
        }

        // 取得したJSON形式データを配列に展開する
        if ($ig_json) {
            $ig_data = json_decode($ig_json);
            if (isset($ig_data->error)) {
                $ig_data = null;
            }
        }

        // 初期表示の設定確認
        if ($show_mode !== 'grid' && $show_mode !== 'list') {
            $show_mode = 'grid';
        }

        return $ig_data;
    }

    /**
     * 店舗ランキング情報を取得する処理
     *
     * @param [type] $range
     * @param [type] $limit
     * @param [type] $area
     * @return ranking
     */
    public function getRanking($range, $limit, $type, $area = null) {
        $this->AccessYears   = TableRegistry::get('access_years');
        $this->AccessMonths  = TableRegistry::get('access_months');
        $this->AccessWeeks   = TableRegistry::get('access_weeks');
        $this->Shops   = TableRegistry::get('shops');

        // ショップランキング再セット用
        $wk_entities_rank  = array();
        // ショップランキング返却用
        $entities_rank  = array();

        // 開始年月日
        $start_date = new Time(date("Y-m-d", strtotime(date('Y-m-d') . "-" . $range . "day")));
        // 現在日時
        $now_date   = new Time(date("Y-m-d"));

        // クエリ検索条件取得
        $start_ym = $start_date->year . '-' . $start_date->format('m');
        $end_ym   = $now_date->year . '-' . $now_date->format('m');

        // 先月まで跨いでるかフラグ取得
        $start_ym != $end_ym ? $is_prev_month = true : $is_prev_month = false;
        // クエリ検索条件セット
        $is_prev_month ? $in_array = [$start_ym, $end_ym] : $in_array = [$start_ym];

        // 前月まで跨いでる場合
        if ($is_prev_month) {
            $zen_date = new Time($start_date); // 最終日取得用
            $zen_date->modify('last day of this month'); // 前月の月末を取得
        }

        $now_month = new Time($now_date); // 当月作業用

        // エリアの指定が無い場合
        if (empty($area)) {
            if ($type == 'shop') {
                $wk_ranking = $this->AccessMonths->find()
                    ->contain(['Shops'])
                    ->where(['ym IN' => $in_array, 'shop_id IS NOT NULL', 'status = 1 AND delete_flag = 0'])
                    ->order(['shop_id', 'ym'])->toArray();
            } else if ($type == 'cast') {
                $wk_ranking = $this->AccessMonths->find()
                    ->contain(['Casts','Casts.Shops'])
                    ->where(['ym IN' => $in_array, 'cast_id IS NOT NULL'
                        , 'Shops.status = 1 AND Shops.delete_flag = 0'
                        , 'Casts.status = 1 AND Casts.delete_flag = 0'
                    ])
                    ->order(['cast_id', 'ym'])->toArray();
            }

        } else {
            if ($type == 'shop') {
                $wk_ranking = $this->AccessMonths->find()
                    ->contain(['Shops'])
                    ->where([
                        'ym IN' => $in_array, 'shop_id IS NOT NULL', 'access_months.area' => $area, 'status = 1 AND delete_flag = 0'
                    ])
                    ->order(['shop_id', 'ym'])->toArray();
            } else if ($type == 'cast') {
                $wk_ranking = $this->AccessMonths->find()
                    ->contain(['Casts','Casts.Shops'])
                    ->where(['ym IN' => $in_array, 'cast_id IS NOT NULL'
                        , 'access_months.area' => $area
                        , 'Shops.status = 1 AND Shops.delete_flag = 0'
                        , 'Casts.status = 1 AND Casts.delete_flag = 0'
                    ])
                    ->order(['cast_id', 'ym'])->toArray();
            }

        }

        // 店舗毎にグループ化する
        if ($type == 'shop') {
            $wk_ranking = $this->groupArray($wk_ranking, 'shop_id');
        } else if ($type == 'cast') {
            // スタッフ毎にグループ化する
            $wk_ranking = $this->groupArray($wk_ranking, 'cast_id');
        }

        foreach ($wk_ranking as $key => $value) {

            // 現在日を取得
            $now = (int)$now_date->format('d');
            // 開始日を取得
            $cnt =  $now - $range;

            $ranking = $value[0];

            // 複数あれば、先月まで跨いでる店舗
            if (count($value) > 1) {

                foreach ($value as $key => $value2) {

                    // 初回のみ
                    if ($key == 0) {
                        // 前月の開始日をセット
                        $cnt = $cnt + $zen_date->format('d');
                        // 前月の末日をセット
                        $now = $zen_date->format('d');
                    } else {
                        // 現在月の月初をセット
                        $cnt = 1;
                        // 現在日をセット
                        $now = (int)$now_date->format('d');
                    }

                    for ($cnt; $cnt <= $now; $cnt++) {

                        $_sessions  = !empty($value2[$cnt . '_sessions']) ? $value2[$cnt . '_sessions'] : 0;
                        $_pageviews = !empty($value2[$cnt . '_pageviews']) ? $value2[$cnt . '_pageviews'] : 0;
                        $_users     = !empty($value2[$cnt . '_sessions']) ? $value2[$cnt . '_sessions'] : 0;

                        $ranking->set(
                            'total_sessions',
                            $ranking->get('total_sessions') + $_sessions
                        );
                        $ranking->set(
                            'total_pageviews',
                            $ranking->get('total_pageviews') + $_pageviews
                        );
                        $ranking->set(
                            'total_users',
                            $ranking->get('total_users') + $_users
                        );
                    }
                }
            } else {

                // 範囲日数 － 現在の日にち <= 0 の場合は前月を跨ぐので当月の月初をセット
                if ($cnt <= 0) {
                    $cnt = 1;
                }

                for ($cnt; $cnt <= $now; $cnt++) {

                    $_sessions  = !empty($value[0][$cnt . '_sessions']) ? $value[0][$cnt . '_sessions'] : 0;
                    $_pageviews = !empty($value[0][$cnt . '_pageviews']) ? $value[0][$cnt . '_pageviews'] : 0;
                    $_users     = !empty($value[0][$cnt . '_sessions']) ? $value[0][$cnt . '_sessions'] : 0;

                    $ranking->set(
                        'total_sessions',
                        $ranking->get('total_sessions') + $_sessions
                    );
                    $ranking->set(
                        'total_pageviews',
                        $ranking->get('total_pageviews') + $_pageviews
                    );
                    $ranking->set(
                        'total_users',
                        $ranking->get('total_users') + $_users
                    );
                }
            }
            array_push($wk_entities_rank,  $ranking);
        }
        if (is_countable($wk_entities_rank) ? count($wk_entities_rank) > 0 : 0) {
            foreach ($wk_entities_rank as $key => $value) {
                $sort[$key] = $value['total_pageviews'];
            }
            // ランキング順にソートする
            array_multisort($sort, SORT_DESC, $wk_entities_rank);
            // 店舗
            if ($type == 'shop') {
                foreach ($wk_entities_rank as $key => $value) {
                    $shopInfo = $this->getShopInfo($value->shop);
                    // トップ画像を設定する
                    $files = $this->S3Client->getList($this->s3Backet, $shopInfo['top_image_path'], 1);
                    // ファイルが存在したら、画像をセット
                    if (is_countable($files) ? count($files) > 0 : 0) {
                        $value->set('img_path', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
                    } else {
                        // 共通トップ画像をセット
                        $value->set('img_path', PATH_ROOT['SHOP_TOP_IMAGE']);
                    }
                    $value->set('shop_url', $shopInfo['shop_url']);

                    $value->set('shopInfo', $shopInfo);
                    $entities_rank[$key] = $value;
                    if ($key == $limit) {
                        break;
                    }
                }

            } else if ($type == 'cast') {
                // スタッフ
                foreach ($wk_entities_rank as $key => $value) {
                    $castInfo = $this->getCastInfo($value->cast, $value->cast->shop);

                    // トップ画像を設定する
                    $files = $this->S3Client->getList($this->s3Backet, $castInfo['icon_path'], 1);
                    // ファイルが存在したら、画像をセット
                    if (is_countable($files) ? count($files) > 0 : 0) {
                        $value->set('img_path', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
                    } else {
                        // 共通トップ画像をセット
                        $value->set('img_path', PATH_ROOT['NO_IMAGE02']);
                    }
                    $value->set('cast_url', $castInfo['cast_url']);

                    $value->set('castInfo', $castInfo);
                    $entities_rank[$key] = $value;
                    if ($key == $limit) {
                        break;
                    }
                }

            }

        }
        // 制限数に満たない場合は空で埋める
        for ($i = count($entities_rank); $i <= $limit; $i++) {
            $entity = $this->AccessMonths->newEntity();
            $entity->img_path = PATH_ROOT['NO_RANKING'];
            $entity->castInfo = array('area'=>'', 'genre' => '');
            $entity->name = 'ランキング対象なし';
            $entities_rank[$i] = $entity;
        }
        return $entities_rank;
    }

    /**
     * ディレクトリを作成する
     *
     * @param Array $userInfo
     * @return Boolean $true $false
     */
    public function createDir($paths) {
        $rslt = true;
        foreach ($paths as $key => $path) {
            $d = new Folder($path, true, 0777);
            // ディレクトリが存在するかチェック
            if (!file_exists($d->path)) {
                $rslt = false;
            }
        }
        return $rslt;
    }

    /**
     * ログを加工してセットする
     *
     * @param Array $user
     * @param Array $e
     * @return String $log
     */
    public function setLog($user, $e) {
        $log = ""; // 例外内容格納用
        $log = "ID：【" . $user['id'] . "】, ロールユーザー：【" . $user['role'] . "】, アドレス：【" . $user['email'] . "】\n";
        $log = $log . $e;
        return $log;
    }

    /**
     * アクセスログを加工してセットする
     *
     * @param Array $user
     * @param Array $e
     * @return String $log
     */
    public function setAccessLog($user, $action) {
        $log = "";
        $log = "ID：【" . $user['id'] . "】, ロールユーザー：【" . $user['role'] . "】, アドレス：【" . $user['email'] . "】";
        $action == 'login' ? $log .= "ログイン" : $log .= "ログアウト";
        return $log;
    }
}
