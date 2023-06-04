<?php

namespace App\Controller;

use \Cake\ORM\Query;
use Cake\Event\Event;
use Cake\Routing\Router;
use \Cake\I18n\FrozenTime;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Mailer\MailerAwareTrait;
use Cake\Datasource\ConnectionManager;

class AreaController extends AppController {
    use MailerAwareTrait;
    // public $components = array('Util', 'OutSideSql');

    public function initialize() {
        parent::initialize();
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        // 常に現在エリアを取得
        $is_area = mb_strtolower($this->request->getparam("controller"));
        $this->set(compact('is_area'));
    }

    public function beforeRender(Event $event) {
        parent::beforeRender($event);
        // 常に現在エリアを取得
        $is_area = $this->viewVars['is_area'];
        // 常にエリア、ジャンルセレクトリストを取得
        $masterCodesFind = array('area', 'genre');
        $selectList = $this->Util->getSelectList($masterCodesFind, $this->MasterCodes, false);
        $this->set(compact('selectList', 'is_area'));
        $url = explode(DS, rtrim($this->request->url, DS));
        $title = ''; // SEO対策
        $description = ''; // SEO対策

        // 次の画面がエリアのトップページの場合
        if ($this->viewVars['next_view'] == 'area') {

            $search = array('_area_', '_service_name_');
            $replace = array(AREA[$is_area]['label'], LT['000']);
            $title = $this->Util->strReplace($search, $replace, TITLE['AREA_TITLE']);
            $description = $this->Util->strReplace($search, $replace, META['AREA_DESCRIPTION']);
        } else if ($this->viewVars['next_view'] == 'genre') {
            // 次の画面がエリアのジャンルの場合
            // TODO: mata
            $search = array('_area_', '_genre_', '_service_name_');
            $replace = array(
                $this->viewVars['area_genre']['area']['label'], $this->viewVars['area_genre']['genre']['label'], LT['000']
            );
            $title = $this->Util->strReplace($search, $replace, TITLE['GENRE_TITLE']);
            $search = array('_area_', '_genre_', '_service_name_');
            $replace = array(
                $this->viewVars['area_genre']['area']['label'], $this->viewVars['area_genre']['genre']['label'], LT['000']
            );
            $description = $this->Util->strReplace($search, $replace, META['GENRE_DESCRIPTION']);
        } else if ($this->viewVars['next_view'] == PATH_ROOT['SHOP']) {
            // 次の画面が店舗トップページの場合

            $search = array('_area_', '_genre_', '_shop_', '_service_name_');
            $replace = array(
                $this->viewVars['shopInfo']['area']['label'], $this->viewVars['shopInfo']['genre']['label'], $this->viewVars['shop']['name'], LT['000']
            );
            $title = $this->Util->strReplace($search, $replace, TITLE['SHOP_TITLE']);
            $search = array('_catch_copy_', '_service_name_');
            $replace = array($this->viewVars['shop']['catch'], LT['000']);
            $description = $this->Util->strReplace($search, $replace, META['SHOP_DESCRIPTION']);
        } else if ($this->viewVars['next_view'] == PATH_ROOT['CAST']) {
            // 次の画面がスタッフトップページの場合

            $search = array('_area_', '_genre_', '_shop_', '_cast_', '_service_name_');
            $replace = array(
                $this->viewVars['shopInfo']['area']['label'], $this->viewVars['shopInfo']['genre']['label'], $this->viewVars['shopInfo']['name'], $this->viewVars['cast']['nickname'], LT['000']
            );
            $title = $this->Util->strReplace($search, $replace, TITLE['CAST_TITLE']);
            $search = array('_cast_', '_service_name_');
            $replace = array($this->viewVars['cast']['nickname'], LT['000']);
            $description = $this->Util->strReplace($search, $replace, META['CAST_DESCRIPTION']);
        } else if ($this->viewVars['next_view'] == PATH_ROOT['DIARY']) {
            // 次の画面が日記ページの場合
            $search = array('_area_', '_genre_', '_shop_', '_cast_', '_service_name_');
            $replace = array(
                $this->viewVars['shopInfo']['area']['label'], $this->viewVars['shopInfo']['genre']['label'], $this->viewVars['shopInfo']['name'], $this->viewVars['cast']['nickname'], LT['000']
            );
            $title = $this->Util->strReplace($search, $replace, TITLE['DIARY_TITLE']);
            $search = array('_cast_', '_service_name_');
            $replace = array($this->viewVars['cast']['nickname'], LT['000']);
            $description = $this->Util->strReplace($search, $replace, META['DIARY_DESCRIPTION']);

            // スタッフのギャラリートップの場合
        } elseif (
            !empty($query['genre']) && !empty($query['name'])
            && !empty($query['nickname']) && in_array(PATH_ROOT['GALLERY'], $url)
        ) {
            $search = array('_area_', '_genre_', '_shop_', '_cast_', '_service_name_');
            $replace = array(
                AREA[$url[0]]['label'], GENRE[$query['genre']]['label'], $query['name'], $query['nickname'], LT['000']
            );
            $title = $this->Util->strReplace($search, $replace, TITLE['GALLERY_TITLE']);
            $search = array('_cast_', '_service_name_');
            $replace = array($query['nickname'], LT['000']);
            $description = $this->Util->strReplace($search, $replace, META['GALLERY_DESCRIPTION']);
        } else if ($this->viewVars['next_view'] == PATH_ROOT['NOTICE']) {
            // 次の画面がお知らせページの場合
            $search = array('_area_', '_genre_', '_shop_', '_service_name_');
            $replace = array(
                $this->viewVars['shopInfo']['area']['label'], $this->viewVars['shopInfo']['genre']['label'], $this->viewVars['shopInfo']['name'], LT['000']
            );
            $title = $this->Util->strReplace($search, $replace, TITLE['NOTICE_TITLE']);
            $search = array('_shop_', '_service_name_');
            $replace = array($this->viewVars['shop']['name'], LT['000']);
            $description = $this->Util->strReplace($search, $replace, META['NOTICE_DESCRIPTION']);
        }
        $this->set(compact('title', 'description', 'is_area'));
    }

    public function index() {
        if ($this->request->is('ajax')) {
            $this->render();
        }

        $query = $this->Shops->find();
        $genre_cnt = $this->Shops->find('all', array('fields' =>
        array('area', 'genre', 'count' => $query->func()->count('genre'))))
            ->group('genre')
            ->where([
                'area' => AREA[$this->viewVars['is_area']]['path'], 'shops.status = 1 AND shops.delete_flag = 0'
            ])
            ->toArray();

        $shops = $query->where([
            'area' => AREA[$this->viewVars['is_area']]['path'], 'shops.status = 1 AND shops.delete_flag = 0'
        ])
            ->contain(['Casts' => function (Query $q) {
                return $q->where(['Casts.status = 1 AND Casts.delete_flag = 0']);
            }])->toArray();

        // 画面表示するランキング数【１カラム：３】,【２カラム：７】,【３カラム：１０】,【４カラム：１３】
        $limit      = PROPERTY['RANKING_SHOW_MAX'];
        // 範囲日数※最大で直近３０日前までとすること
        $range      = PROPERTY['RANKING_SPAN_MAX'];

        $genreCounts = GENRE; // ジャンルの配列をコピー
        // それぞれのジャンルの初期値カウントに０,エリア名をセットする
        foreach ($genreCounts as $key => $row) {
            $genreCounts[$key] = $row + array(
                'count' => 0, 'area' => AREA[$this->viewVars['is_area']]['path'], 'genre_path' => PUBLIC_DOMAIN . DS . AREA[$this->viewVars['is_area']]['path'] . DS . $genreCounts[$key]['path']
            );
        }

        // DBから取得したジャンルのカウントをセットする
        foreach ($genre_cnt as $key => $shop) {

            $genreCounts[$shop['genre']]['area'] = AREA[$this->viewVars['is_area']]['path'];
            $genreCounts[$shop['genre']]['count'] = $shop['count'];
        }

        // 全体店舗数
        $shops_cnt = 0;
        // 全体スタッフ数
        $casts_cnt = 0;
        // 店舗数セットする
        foreach ($genre_cnt as $key => $row) {
            $shops_cnt += $row['count'];
        }
        // スタッフ数セットする
        foreach ($shops as $key => $shop) {
            $casts_cnt += count($shop->casts);
        }

        $all_cnt = ['shops' => $shops_cnt, 'casts' => $casts_cnt];

        $new_photos = $this->NewPhotosRank->find("all")
            ->where(['area' => AREA[$this->viewVars['is_area']]['label']])
            ->order(['id' => 'ASC'])
            ->toArray();

        $shop_ranking = $this->Util->getRanking($range, $limit, 'shop', $this->viewVars['is_area']);
        $cast_ranking = $this->Util->getRanking($range, $limit, 'cast', $this->viewVars['is_area']);
        // メイン広告を取得
        $main_adsenses = $this->Util->getAdsense(PROPERTY['TOP_SLIDER_GALLERY_MAX'], 'main', $this->viewVars['is_area']);
        // サブ広告を取得
        $sub_adsenses = $this->Util->getAdsense(PROPERTY['SUB_SLIDER_GALLERY_MAX'], 'sub', $this->viewVars['is_area']);
        //広告を配列にセット
        $adsenses = array('main_adsenses' => $main_adsenses, 'sub_adsenses' => $sub_adsenses);
        // 日記を取得
        $diarys = $this->Util->getNewDiarys(
            PROPERTY['NEW_INFO_MAX'],
            $this->viewVars['is_area'],
            null,
            empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']
        );
        // お知らせを取得
        $notices = $this->Util->getNewNotices(
            PROPERTY['NEW_INFO_MAX'],
            $this->viewVars['is_area'],
            empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']
        );
        // ニュースを取得
        $news = $this->Util->getNewss(null, 5);

        $this->set('next_view', 'area');
        $this->set(compact(
            'all_cnt',
            'genreCounts',
            'selectList',
            'new_photos',
            'diarys',
            'notices',
            'news',
            'adsenses',
            'shop_ranking',
            'cast_ranking'
        ));

        $this->render();
    }

    /**
     * cabacula function
     *
     * @return void
     */
    public function cabacula($id = null) {
        // 店舗ID存在した場合は、ショップアクションへ
        if (!empty($id)) {
            $this->commonShop($id);
            return;
        }
        $this->commonGenre();
        $this->render();
        return;
    }
    /**
     * snack function
     *
     * @return void
     */
    public function snack($id = null) {
        // 店舗ID存在した場合は、ショップアクションへ
        if (!empty($id)) {
            $this->commonShop($id);
            return;
        }
        $this->commonGenre();
        $this->render();
        return;
    }
    /**
     * girlsbar function
     *
     * @return void
     */
    public function girlsbar($id = null) {
        // 店舗ID存在した場合は、ショップアクションへ
        if (!empty($id)) {
            $this->commonShop($id);
            return;
        }
        $this->commonGenre();
        $this->render();
        return;
    }
    /**
     * club function
     *
     * @return void
     */
    public function club($id = null) {
        // 店舗ID存在した場合は、ショップアクションへ
        if (!empty($id)) {
            $this->commonShop($id);
            return;
        }
        $this->commonGenre();
        $this->render();
        return;
    }
    /**
     * lounge function
     *
     * @return void
     */
    public function lounge($id = null) {
        // 店舗ID存在した場合は、ショップアクションへ
        if (!empty($id)) {
            $this->commonShop($id);
            return;
        }
        $this->commonGenre();
        $this->render();
        return;
    }
    /**
     * pub function
     *
     * @return void
     */
    public function pub($id = null) {
        // 店舗ID存在した場合は、ショップアクションへ
        if (!empty($id)) {
            $this->commonShop($id);
            return;
        }
        $this->commonGenre();
        $this->render();
        return;
    }
    /**
     * bar function
     *
     * @return void
     */
    public function bar($id = null) {
        // 店舗ID存在した場合は、ショップアクションへ
        if (!empty($id)) {
            $this->commonShop($id);
            return;
        }
        $this->commonGenre();
        $this->render();
        return;
    }

    /**
     * 共通ジャンル画面 function
     *
     * @return void
     */
    public function commonGenre() {
        $url = explode(DS, rtrim($this->request->url, DS));

        $area_genre = ['area' => AREA[$url['0']], 'genre' => GENRE[$url['1']]];
        // エリア、ジャンルの店舗情報取得
        $subquery = $this->Users->find()
            ->distinct()
            ->select(['like' => 's.id'])
            ->join([
                'sl' => [
                    'table' => 'shop_likes',
                    'type' => 'INNER',
                    'conditions' => ['sl.user_id = ' . empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']],
                ],
                's' => [
                    'table' => 'shops',
                    'type' => 'INNER',
                    'conditions' => ['s.id = sl.shop_id'],
                ]
            ])->where([
                's.area' => $url['0'], 's.genre' => $url['1'],
                's.status = 1 AND s.delete_flag = 0',
                'users.id = ' . empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']
            ]);

        $shops = $this->Shops->find()
            ->contain(['Snss', 'ShopLikes' => function (Query $q) {
                return $q
                    ->select([
                        'ShopLikes.shop_id', 'total' => $q->func()->count('ShopLikes.shop_id')
                    ])
                    ->group('shop_id')
                    ->where(['ShopLikes.shop_id']);
            }])
            ->select($this->Shops)
            ->select('your_like.like')
            ->leftJoin(
                ['your_like' => $subquery],
                ['your_like.like = shops.id']
            )
            ->where([
                'shops.area' => $url['0'], 'shops.genre' => $url['1'],
                'shops.status = 1 AND shops.delete_flag = 0'
            ])
            ->toArray();

        // トップ画像を設定する
        foreach ($shops as $key => $shop) {

            $shopInfo = $this->Util->getShopInfo($shop);

            $files = $this->S3Client->getList($this->s3Backet, $shopInfo['top_image_path'], 1);
            // ファイルが存在したら、画像をセット
            if (is_countable($files) ? count($files) > 0 : 0) {
                $shop->set('top_image', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
            } else {
                // 共通トップ画像をセット
                $shop->set('top_image', PATH_ROOT['SHOP_TOP_IMAGE']);
            }
        }
        $this->set('next_view', 'genre');
        $this->set(compact('shops', 'area_genre'));
        return;
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function commonShop($id) {
        $sharer =  Router::reverse($this->request, true);

        $shop = $this->Shops->find()
            ->where([
                'shops.id' => $id,
                'shops.status = 1 AND shops.delete_flag = 0'
            ])
            ->contain(['Owners.ServecePlans', 'Casts' => function (Query $q) {
                $now = date('Y-m-d');
                $case = $q->newExpr()->addCase(
                    [$q->newExpr()->between(
                        'created',
                        date('Y-m-d', strtotime("-10 day")),
                        $now
                    )],
                    [1, 0],
                    ['integer', 'integer']
                );
                return $q->find('all')
                    ->select($this->Casts->getSchema()->columns())
                    ->select(['is_new' => $case])
                    ->where(['Casts.status = 1 AND Casts.delete_flag = 0'])
                    ->order(['rand()']);
            }, 'Casts.Updates' => function (Query $q) use ($id) {
                return $q
                    ->select()
                    ->where([
                        'shop_id' => $id,
                        'Updates.created > NOW() - INTERVAL ' . PROPERTY['UPDATE_INFO_DAY_MAX'] . ' HOUR'
                    ])
                    ->order(['created' => 'DESC']);
            }, 'Casts.CastLikes' => function (Query $q) {
                $main = $q
                    ->select([
                       'cast_id', 'user_id', 'total' => $q->func()->count('CastLikes.cast_id')
                    ])
                    ->group('cast_id', 'user_id');

                return $main->leftJoinWith('Users', function ($sub) {
                    return $sub->select(['is_like' => $sub->func()->count('Users.id')])
                        ->where(['Users.id' => empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']]);
                });
            }, 'ShopLikes' => function (Query $q) {
                $main = $q
                    ->select([
                       'shop_id', 'user_id', 'total' => $q->func()->count('ShopLikes.shop_id')
                    ])
                    ->group('shop_id', 'user_id');

                return $main->leftJoinWith('Users', function ($sub) {
                    return $sub->select(['is_like' => $sub->func()->count('Users.id')])
                        ->where(['Users.id' => empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']]);
                });
            }, 'Coupons' => function (Query $q) {
                return $q
                    ->where(['Coupons.status' => '1']);
            }, 'Owners' => function (Query $q) use ($id) {
                return $q->leftJoinWith('Shops', function ($sub) use ($id) {
                    return $sub
                        ->select('owner_id')
                        ->where(['Shops.id' => $id]);
                });
            }, 'Owners.Shops' => function (Query $q) use ($id) {
                return $q
                    ->where([
                        'Shops.status = 1 AND Shops.delete_flag = 0',
                        'not' => ['Shops.id in' => [$id]]
                    ]);
            }, 'ShopInfos' => function (Query $q) use ($id) {
                $subquery = $this->Users->find()
                    ->distinct()
                    ->select(['like' => 'si.id'])
                    ->join([
                        'sil' => [
                            'table' => 'shop_info_likes',
                            'type' => 'INNER',
                            'conditions' => ['sil.user_id = ' . empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']],
                        ],
                        'si' => [
                            'table' => 'shop_infos',
                            'type' => 'INNER',
                            'conditions' => ['si.shop_id = ' . $id . ' AND si.id = sil.Shop_info_id'],
                        ],
                        's' => [
                            'table' => 'shops',
                            'type' => 'INNER',
                            'conditions' => ['s.id = ' . $id . ' AND s.status = 1 AND s.delete_flag = 0'],
                        ]
                    ]);

                $main = $q->leftJoinWith('ShopInfoLikes', function ($sub) use ($id) {
                    return $sub->select([
                        'shop_info_id', 'total' => $sub->func()->count('shop_info_id')
                    ])
                    ->group(['shop_info_id'])
                    ->where(['shop_id' => $id]);
                })
                ->select($this->ShopInfos->getSchema()->columns())
                ->select(['your_like.like'])
                ->leftJoin(
                    ['your_like' => $subquery],
                    ['your_like.like = ShopInfos.id']
                )
                ->group(['ShopInfos.id'])
                ->order(['ShopInfos.created' => 'DESC'])
                ->limit(1);
                return $main;
            }, 'WorkSchedules' => function (Query $q) {
                $end_date = date("Y-m-d H:i:s");
                $start_date = date("Y-m-d H:i:s", strtotime($end_date . "-24 hour"));
                $range = "'" . $start_date . "' and '" . $end_date . "'";
                return $q
                    ->where(["WorkSchedules.modified BETWEEN" . $range]);
            }, 'Reviews' => function (Query $q) use ($id) {
                $main = $q
                    ->select([
                       'Reviews.shop_id', 'total' => $q->func()->count('Reviews.shop_id')
                    ])
                    ->group('shop_id')
                    ->where(['shop_id' => $id]);

                return $main->leftJoinWith('Users', function ($sub) {
                    return $sub->select(['is_review' => $sub->func()->count('Users.id')])
                        ->where(['Users.id' => empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']]);
                });
            }, 'Jobs', 'Snss', 'ShopOptions'])
            ->first();


        // 店舗が非表示または論理削除している場合はリダイレクトする
        if (empty($shop)) {
            $url = explode(DS, $this->request->url);
            return $this->redirect(
                [
                    'controller' => 'Unknow', 'action' => 'shop',
                    '?' => array('area' => $url[0], 'genre' => $url[1], 'id' => $url[2])
                ]
            );
        }

        // その他の店舗情報をセット
        foreach ($shop->owner->shops as $key => $value) {
            $shop->owner->shops[$key]->set('shopInfo', $this->Util->getShopInfo($value));
        }

        $shopInfo = $this->Util->getShopInfo($shop);

        // 店舗の更新情報を取得する
        $updateInfo = $this->Updates->find('all')
            ->where([
                'shop_id' => $id,
                'updates.created > NOW() - INTERVAL ' . PROPERTY['UPDATE_INFO_DAY_MAX'] . ' HOUR'
            ])
            ->order(['created' => 'DESC'])
            ->toArray();

        // $columns = $this->Updates->schema()->columns();

        // 店舗の更新情報を取得する
        // $updateInfo = $this->Updates->find('all', array(
        //     'conditions' => array('updates.created > NOW() - INTERVAL '.PROPERTY['UPDATE_INFO_DAY_MAX'].' HOUR')
        // ))
        // ->join([
        //     'table' => 'updates',
        //     'alias' => 'u',
        //     'type' => 'LEFT',
        //     'conditions' => 'u.content = updates.content and u.created > updates.created'
        // ])
        // ->select($columns)
        // ->where(['updates.shop_id'=>$shopInfo['id'],'u.created IS NULL'])
        // ->order(['updates.created'=>'DESC'])
        // ->toArray();

        $update_icon = array();
        // 画面の店舗メニューにnew-icon画像を付与するための配列をセットする
        foreach ($updateInfo as $key => $value) {
            $isNew = in_array($value->type, SHOP_MENU_NAME);
            if ($isNew) {
                $update_icon[] = $value->type;
            }
        }
        // 今日の日付から1ヶ月前
        $end_date = date('Y-m-d', strtotime("-7 day"));
        // スタッフの登録日付をチェックする
        foreach ($shop->casts as $key => $cast) {
            $user_created = $cast->created->format('Y-m-d');
            $end_ts = strtotime($end_date);
            $user_ts = strtotime($user_created);
            // 新しいスタッフの場合フラグセット
            if ($user_ts >= $end_ts) {
                $cast->set('new_cast', true);
            }
            // スタッフの更新があればフラグをセット
            foreach ($updateInfo as $key => $value) {
                if (!empty($value->cast_id) && $value->cast_id == $cast->id) {
                    $cast->set('update_cast', true);
                }
            }
        }

        // トップ画像を設定する
        $files = $this->S3Client->getList($this->s3Backet, $shopInfo['top_image_path'], 1);
        // ファイルが存在したら、画像をセット
        if (is_countable($files) ? count($files) > 0 : 0) {
            $shop->set('top_image', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
        } else {
            // 共通トップ画像をセット
            $shop->set('top_image', PATH_ROOT['SHOP_TOP_IMAGE']);
        }

        // ギャラリーリストを作成
        $gallery = array();

        $files = $this->S3Client->getList($this->s3Backet, $shopInfo['image_path']);
        usort($files, $this->Util->sortByLastmod);
        foreach ($files as $file) {
            $timestamp = date('Y/m/d H:i', filemtime($file));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $file, "date" => $timestamp
            ));
        }
        $shop->set('gallery', $gallery);

        // お知らせリストを作成
        $gallery = array();
        if (count($shop->shop_infos) > 0) {
            // お知らせのギャラリーリストを作成
            $files = $this->S3Client->getList($this->s3Backet, $shopInfo['notice_path']);
            usort($files, $this->Util->sortByLastmod);
            foreach ($files as $file) {
                $timestamp = date('Y/m/d H:i', filemtime($file));
                array_push($gallery, array(
                    "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $file, "date" => $timestamp
                ));
            }

            $shop->shop_infos[0]->set('gallery', $gallery);
        }

        // スタッフのアイコンを設定する
        foreach ($shop->casts as $key => $cast) {
            $path = $shopInfo['cast_path'] . DS . $cast->dir . DS . PATH_ROOT['ICON'];

            // トップ画像を設定する
            $files = $this->S3Client->getList($this->s3Backet, $path, 1);
            // ファイルが存在したら、画像をセット
            if (is_countable($files) ? count($files) > 0 : 0) {
                $cast->set('icon', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
            } else {
                // 共通トップ画像をセット
                $cast->set('icon', PATH_ROOT['NO_IMAGE02']);
            }
        }
        // 店舗スタッフの最新日記を取得する
        $diarys = $this->Util->getNewDiarys(PROPERTY['NEW_INFO_MAX'], null, $id, empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']);

        $credits = $this->MasterCodes->find()->where(['code_group' => 'credit']);
        $ig_data = null; // Instagramデータ

        // // 現在プランが適応中かチェックする
        // $is_range_plan = $this->Util->check_in_range(
        //     $shop->owner->servece_plan->from_start,
        //     $shop->owner->servece_plan->to_end,
        //     new FrozenTime(date("Y-m-d"))
        // );

        // Instagramアカウントが入力されている かつ プランが適応中の場合インスタデータを取得する
        if (!empty($shop->snss[0]->instagram) /*&& $is_range_plan*/) {
            $insta_user_name = $shop->snss[0]->instagram;
            // インスタのキャッシュパス
            $cache_path = PATH_ROOT['TMP'] . DS . PATH_ROOT['CACHE'];
            $datFile = $insta_user_name . '-instagram_graph_api.dat';
            // インスタ情報を取得
            $tmp_ig_data = $this->Util->getInstagram($insta_user_name, null, $shopInfo['current_plan'], $cache_path, $datFile);
            // データ取得に失敗した場合
            if (!$tmp_ig_data) {
                $this->log('【' . AREA[$shop->area]['label']
                    . GENRE[$shop->genre]['label'] . $shop->name
                    . '】のインスタグラムのデータ取得に失敗しました。', 'error');
                $this->Flash->warning('インスタグラムのデータ取得に失敗しました。');
            }
            $ig_data = $tmp_ig_data->business_discovery;
            // インスタユーザーが存在しない場合
            if (!empty($tmp_ig_data->error)) {
                // エラーメッセージをセットする
                $insta_error = $tmp_ig_data->error->error_user_title;
                $this->set(compact('ig_error'));
            }
        }

        // facebook廃止 2020/06/11
        $isShow_fb = false;

        $this->set('next_view', PATH_ROOT['SHOP']);
        $this->set(compact(
            'shop',
            'shopInfo',
            'update_icon',
            'updateInfo',
            'diarys',
            'sharer',
            'credits',
            'creditsHidden',
            'ig_data',
            'isShow_fb'
        ));
        $this->render('shop');
    }

    public function cast($id = null) {

        $shop_id = $this->Casts->find('all', ['fields' => ['shop_id']])
            ->where(['id' => $id, 'status = 1 AND delete_flag = 0'])
            ->first()->shop_id;

        // 店舗が非表示または論理削除している場合はリダイレクトする
        if (empty($shop_id)) {
            $url = explode(DS, $this->request->url);
            return $this->redirect(
                [
                    'controller' => 'Unknow', 'action' => 'cast',
                    '?' => array('area' => $url[0])
                ]
            );
        }
        /**
         * 店舗スタッフ一覧とお気に入り数ユーザーのお気に入り状況を取得する
         */
        $shop = $this->Shops->find("all")
            ->where([
                'shops.id' => $shop_id,
                'shops.status = 1 AND shops.delete_flag = 0'
            ])
            ->contain([
                'Casts' => function (Query $q) use ($id) {
                    return $q
                        ->where(['Casts.status = 1 AND Casts.delete_flag = 0'])
                        ->order(['id = ' . $id . ' desc', 'rand()']);
                }, 'Casts.CastLikes' => function (Query $q) {
                    $main = $q
                        ->select([
                        'CastLikes.id', 'cast_id', 'user_id', 'total' => $q->func()->count('CastLikes.cast_id')
                        ])
                        ->group('cast_id', 'user_id');

                    return $main->leftJoinWith('Users', function ($sub) {
                        return $sub->select(['is_like' => $sub->func()->count('Users.id')])
                            ->where(['Users.id' => empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']]);
                    });
                }, 'Casts.Snss' => function (Query $q) {
                    return $q
                        ->where(['Snss.cast_id']);
                }, 'Casts.Diarys' => function (Query $q) use ($id, $shop_id)  {

                    $subquery = $this->Users->find()
                        ->distinct()
                        ->select(['like' => 'd.id'])
                        ->join([
                            'dl' => [
                                'table' => 'diary_likes',
                                'type' => 'INNER',
                                'conditions' => ['dl.user_id = ' . empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']],
                            ],
                            'd' => [
                                'table' => 'diarys',
                                'type' => 'INNER',
                                'conditions' => ['d.id = dl.diary_id'],
                            ],
                            's' => [
                                'table' => 'shops',
                                'type' => 'INNER',
                                'conditions' => ['s.id = ' . $shop_id . ' AND s.status = 1 AND s.delete_flag = 0'],
                            ],
                            'c' => [
                                'table' => 'casts',
                                'type' => 'INNER',
                                'conditions' => ['c.id = ' . $id . ' AND c.status = 1 AND c.delete_flag = 0'],
                            ]
                        ]);

                    return $q->leftJoinWith('DiaryLikes', function ($sub) use ($id) {
                        return $sub->select([
                            'diary_id', 'total' => $sub->func()->count('diary_id')
                        ])
                        ->group(['diary_id']);
                    })
                    ->select($this->Diarys->getSchema()->columns())
                    ->select(['your_like.like'])
                    ->leftJoin(
                        ['your_like' => $subquery],
                        ['your_like.like = Diarys.id']
                    )
                    ->group(['Diarys.id'])
                    ->order(['Diarys.created' => 'DESC'])
                    ->limit(1);
                 }, 'Snss'
            ])->first();

        // 店舗情報
        $shopInfo = $this->Util->getShopInfo($shop);

        // スタッフのアイコンを設定する
        foreach ($shop->casts as $key => $cast) {
            $path = $shopInfo['cast_path'] . DS . $cast->dir . DS . PATH_ROOT['ICON'];

            // トップ画像を設定する
            $files = $this->S3Client->getList($this->s3Backet, $path, 1);
            // ファイルが存在したら、画像をセット
            if (is_countable($files) ? count($files) > 0 : 0) {
                $cast->set('icon', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
            } else {
                // 共通トップ画像をセット
                $cast->set('icon', PATH_ROOT['NO_IMAGE02']);
            }
        }

        // メインスタッフの出勤有無を取得する
        $end_date = date("Y-m-d H:i:s");
        $start_date = date("Y-m-d H:i:s", strtotime($end_date . "-24 hour"));
        $range = "'" . $start_date . "' and '" . $end_date . "'";

        $isWorkDay = $this->WorkSchedules->find('all')
            ->where([
                'shop_id' => $shop->id, "modified BETWEEN" . $range, 'FIND_IN_SET(\'' . $shop->casts[0]->id . '\', cast_ids)'
            ])
            ->count();

        // メインスタッフ情報取得
        $castInfo = $this->Util->getCastInfo($shop->casts[0], $shop);

        // トップ画像を設定する
        $files = $this->S3Client->getList($this->s3Backet, $castInfo['top_image_path'], 1);
        // ファイルが存在したら、画像をセット
        if (is_countable($files) ? count($files) > 0 : 0) {
            $shop->casts[0]->set('top_image', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
        } else {
            // 共通トップ画像をセット
            $shop->casts[0]->set('top_image', PATH_ROOT['CAST_TOP_IMAGE']);
        }

        // ギャラリーリストを作成
        $gallery = array();

        $files = $this->S3Client->getList($this->s3Backet, $castInfo['image_path']);
        usort($files, $this->Util->sortByLastmod);
        foreach ($files as $file) {
            $timestamp = date('Y/m/d H:i', filemtime($file));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $file, "date" => $timestamp, "simple_path" => $file

            ));
        }
        $shop->casts[0]->set('gallery', $gallery);

        // 日記が１つでもある場合
        if (count($shop->casts[0]->diarys) > 0) {

            $listObjects = $this->S3Client->getListObjects(
                $this->s3Backet,
                $castInfo['diary_path'] . $shop->casts[0]->diarys[0]->dir
            );

            $gallery = array();

            foreach ($listObjects['Contents'] as $Contents) {
                $timestamp = date('Y/m/d H:i', strtotime($Contents['LastModified']));
                array_push($gallery, array(
                    "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $Contents['Key'], "date" => $timestamp
                ));
            }
            $shop->casts[0]->diarys[0]->set('gallery', $gallery);
        }

        $ig_data = null; // Instagramデータ
        // Instagramアカウントが入力されていればインスタデータを取得する
        if (!empty($shop->casts[0]->snss[0]->instagram)) {
            $insta_user_name = $shop->casts[0]->snss[0]->instagram;
            // インスタのキャッシュパス
            $cache_path = PATH_ROOT['TMP'] . DS . PATH_ROOT['CACHE'];
            $datFile = $insta_user_name . '-instagram_graph_api.dat';
            // インスタ情報を取得
            $tmp_ig_data = $this->Util->getInstagram($insta_user_name, null, $shopInfo['current_plan'], $cache_path, $datFile);
            // データ取得に失敗した場合
            if (!$tmp_ig_data) {
                $this->log('【' . AREA[$shop->area]['label']
                    . GENRE[$shop->genre]['label'] . $shop->name
                    . ' ' . $shop->casts[0]->name . '】のインスタグラムのデータ取得に失敗しました。', 'error');
                $this->Flash->warning('インスタグラムのデータ取得に失敗しました。');
            }
            $ig_data = $tmp_ig_data->business_discovery;
            // インスタユーザーが存在しない場合
            if (!empty($tmp_ig_data->error)) {
                // エラーメッセージをセットする
                $insta_error = $tmp_ig_data->error->error_user_title;
                $this->set(compact('ig_error'));
            }
        }
        $this->set('next_view', PATH_ROOT['CAST']);
        $this->set(compact('shop', 'isWorkDay', 'ig_data', 'shopInfo', 'castInfo'));
        $this->render();
    }

    public function gallery($id = null) {
        $cast = $this->Casts->find('all')
            ->where(['casts.id' => $id])
            ->contain(['shops'])
            ->first();

        // スタッフ情報取得
        $castInfo = $this->Util->getCastInfo($cast, $cast->shop);
        // ギャラリーリストを作成
        // ディクレトリ取得
        $dir = new Folder(preg_replace('/(\/\/)/', '/', WWW_ROOT . $castInfo['cast_path'] . DS . PATH_ROOT['IMAGE']), true, 0755);

        $gallery = array();

        // 並び替えして出力
        $files = glob($dir->path . DS . '*.*');
        usort($files, $this->Util->sortByLastmod);
        foreach ($files as $file) {
            $timestamp = date('Y/m/d H:i', filemtime($file));
            array_push($gallery, array(
                "file_path" => $castInfo['cast_path'] . DS . PATH_ROOT['IMAGE'] . DS . (basename($file)), "date" => $timestamp
            ));
        }

        $this->set(compact('cast', 'gallery'));
        $this->render();
    }

    public function diary($id = null) {
        $cast = $this->Casts->find("all")
            ->where([
                'casts.id' => $id,
                'casts.status = 1 AND casts.delete_flag = 0'
            ])
            ->contain([
                'Shops' => function (Query $q) use ($id) {
                    return $q
                        ->where([
                            'Shops.id is not' => $id,
                            'Shops.status = 1 AND Shops.delete_flag = 0'
                        ]);
                }
            ])->first();

        // 店舗が非表示または論理削除している場合はリダイレクトする
        if (empty($cast)) {
            $url = explode(DS, $this->request->url);
            return $this->redirect(
                [
                    'controller' => 'Unknow', 'action' => 'diary',
                    '?' => array('area' => $url[0])
                ]
            );
        }

        $this->set('castInfo', $this->Util->getCastInfo($cast, $cast->shop));
        $this->set('shopInfo', $this->Util->getShopInfo($cast->shop));

        // スタッフの全ての日記を取得
        $diarys = $this->Util->getDiarys($id, $this->viewVars['castInfo']['diary_path']
            , empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']);
        $top_diarys = array();
        $arcive_diarys = array();
        $count = 0;
        foreach ($diarys as $key1 => $rows) :
            foreach ($rows as $key2 => $row) :
                if ($count == 5) :
                    break;
                endif;
                array_push($top_diarys, $row);
                unset($diarys[$key1][$key2]);
                $count = $count + 1;
            endforeach;
        endforeach;
        foreach ($diarys as $key => $rows) :
            if (count($rows) == 0) :
                unset($diarys[$key]);
            endif;
        endforeach;
        foreach ($diarys as $key1 => $rows) :
            $tmp_array = array();
            foreach ($rows as $key2 => $row) :
                array_push($tmp_array, $row);
            endforeach;
            array_push($arcive_diarys, array_values($tmp_array));
        endforeach;
        $this->set('next_view', PATH_ROOT['DIARY']);
        $this->set(compact('cast', 'top_diarys', 'arcive_diarys'));
        $this->render();
    }

    public function viewDiary() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $this->confReturnJson(); // json返却用の設定
        $cast = $this->Casts->find('all')
            ->where(['casts.id' => $this->request->query["id"]])
            ->contain(['shops'])
            ->first();

        $this->set('castInfo', $this->Util->getCastInfo($cast, $cast->Shops));
        $diary = $this->Util->getDiary(
            $this->request->getQuery('diary_id'),
            $this->viewVars['castInfo']['diary_path'],
            empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']
        );
        $this->response->body(json_encode($diary));
        return;
    }
    /**
     * スタッフの全ての日記情報を取得する処理
     *
     * @param [type] $id
     * @return array
     */
    public function getDiarys($id = null) {
        $columns = array('id', 'cast_id', 'title', 'content', 'dir');
        // スタッフ情報、最新の日記情報とイイネの総数取得
        $diarys = $this->Diarys->find("all")
            ->select($columns)
            ->where(['cast_id' => $id])
            ->contain(['Diary_Likes'])
            ->order(['created' => 'DESC'])->limit(5);
        // 過去の日記をアーカイブ形式で取得する
        // TODO: 年月毎に取得する。月毎の投稿は、アコーディオンを開いたときに年月を条件にsql取得？
        $query = $this->Diarys->find('all')->select($columns);
        $ym = $query->func()->date_format([
            'created' => 'identifier',
            "'%Y年%c月'" => 'literal'
        ]);
        $md = $query->func()->date_format([
            'created' => 'identifier',
            "'%c月%e日'" => 'literal'
        ]);
        $count = $query->func()->count('*');
        $archive = $query->select([
            'ym_created' => $ym,
            'md_created' => $md
        ])
            ->where(['cast_id' => $id])
            ->contain(['Diary_Likes'])
            ->order(['created' => 'DESC'])->all();
        $archive = $this->Util->groupArray($archive, 'ym_created');
        $archive = array_values($archive);
        return $archive;
    }

    public function notice($id = null) {
        $shop = $this->Shops->find("all")
            ->where([
                'shops.id' => $id,
                'shops.status = 1 AND shops.delete_flag = 0'
            ])
            ->first();

        // 店舗が非表示または論理削除している場合はリダイレクトする
        if (empty($shop)) {
            $url = explode(DS, $this->request->url);
            return $this->redirect(
                [
                    'controller' => 'Unknow', 'action' => 'diary',
                    '?' => array('area' => $url[0])
                ]
            );
        }

        $this->set('shopInfo', $this->Util->getShopInfo($shop));

        // 店舗の全てのニュースを取得
        $notices = $this->Util->getNotices($id, $this->viewVars['shopInfo']['notice_path'], $this->viewVars['userInfo']['id']);
        $top_notices = array();
        $arcive_notices = array();
        $count = 0;
        foreach ($notices as $key1 => $rows) :
            foreach ($rows as $key2 => $row) :
                if ($count == 5) :
                    break;
                endif;
                array_push($top_notices, $row);
                unset($notices[$key1][$key2]);
                $count = $count + 1;
            endforeach;
        endforeach;
        foreach ($notices as $key => $rows) :
            if (count($rows) == 0) :
                unset($notices[$key]);
            endif;
        endforeach;
        foreach ($notices as $key1 => $rows) :
            $tmp_array = array();
            foreach ($rows as $key2 => $row) :
                array_push($tmp_array, $row);
            endforeach;
            array_push($arcive_notices, array_values($tmp_array));
        endforeach;
        $this->set('next_view', PATH_ROOT['NOTICE']);
        $this->set(compact('cast', 'top_notices', 'arcive_notices'));
        $this->render();
    }

    public function viewNotice() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $this->confReturnJson(); // json返却用の設定
        $shop = $this->Shops->get($this->request->query["id"]);


        $this->set('shopInfo', $this->Util->getShopInfo($shop));
        $notice = $this->Util->getNotice(
            $this->request->getQuery('notice_id'),
            $this->viewVars['shopInfo']['notice_path'],
            empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']
        );
        $this->response->body(json_encode($notice));
        return;
    }

    public function review($id = null) {
        $all_favo = 0; // &を付けて値渡しする
        $is_like  = 0; // &を付けて値渡しする
        // AJAXのアクセス以外は不正とみなす。
        if ($this->request->is('ajax')) {

            $this->confReturnJson(); // json返却用の設定
            $data = $this->request->getData();

            if ($data['type'] == 'see_more_reviews') {
                $shop = $this->Shops->find("all")
                    ->contain(['Reviews' => function (Query $q) use ($id, $data, &$all_favo) {
                        $q
                            ->select([
                                'Reviews.id', 'Reviews.shop_id', 'Reviews.user_id', 'cost', 'atmosphere', 'customer', 'staff', 'cleanliness', 'comment', 'total' => $q->func()->count('Reviews.shop_id')
                            ])
                            ->group('user_id')
                            ->where(['shop_id' => $id]);
                        $all_favo = $q->count();
                        return $q->limit(2)
                            ->offset($data['now_count'])
                            ->order(['Reviews.created' => 'desc']);
                    }, 'Reviews.Users' => function (Query $q) {
                        return $q
                            ->select([
                                'id', 'name', 'file_name', 'email', 'created', 'is_like' => $q->func()->count('Users.id')
                            ]);
                    }])
                    ->where(['id' => $id, 'status = 1 AND delete_flag = 0'])
                    ->first();

                foreach ($shop->reviews as $key => $value) {
                    // ユーザに関する情報をセット
                    $userInfo = $this->Util->getUserInfo($value->user);
                    $exist = $this->S3Client->doesObjectExist(PATH_ROOT['USERS'] . DS . $value->user->file_name);
                    // ファイルが存在したら、画像をセット
                    if ($exist) {
                        $userInfo = $userInfo + array('icon' => PATH_ROOT['URL_S3_BUCKET'] . DS . PATH_ROOT['USERS'] . DS . $value->user->file_name);
                    } else {
                        // 共通アイコン画像をセット
                        $userInfo = $userInfo + array('icon' => PATH_ROOT['NO_IMAGE02']);
                    }
                    $value->user->icon = $userInfo['icon'];
                }
            }

            $this->set(compact('shop'));
            $this->render('/Element/review-list');
            $response = array(
                'success' => true,
                'all_favo' => $all_favo,
                'html' => $this->response->body(),
            );
            $this->response->body(json_encode($response));
            return;
        }
        $is_reviewed = $this->Reviews->find('all')
            ->where(['shop_id' => $id, 'user_id' => empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']])
            ->count();
        $shop = $this->Shops->find("all")
            ->contain(['Reviews' => function (Query $q) use ($id, &$all_favo) {
                $q
                    ->select([
                        'Reviews.id', 'Reviews.shop_id', 'Reviews.user_id', 'cost', 'atmosphere', 'customer', 'staff', 'cleanliness', 'comment', 'total' => $q->func()->count('Reviews.shop_id')
                    ])
                    ->where(['shop_id' => $id]);
                $all_favo = $q->toArray()[0]->total;

                return $q
                    ->group('user_id')
                    ->limit(2)
                    ->offset($data['now_count'])
                    ->order(['Reviews.created' => 'desc']);
            }, 'Reviews.Users' => function (Query $q) {
                return $q
                    ->select([
                        'name', 'file_name', 'created', 'is_like' => $q->func()->count('Users.id')
                    ]);
            }])
            ->where(['id' => $id, 'status = 1 AND delete_flag = 0'])
            ->first();
        // レビュー済カウント数
        $shop->set('is_reviewed', $is_reviewed);

        // 店舗が非表示または論理削除している場合はリダイレクトする
        if (empty($shop)) {
            $url = explode(DS, $this->request->url);
            return $this->redirect(
                [
                    'controller' => 'Unknow', 'action' => 'shop',
                    '?' => array('area' => $url[0], 'genre' => $url[1], 'id' => $url[2])
                ]
            );
        }

        $sql = $this->OutSideSql->getReview();
        $connection = ConnectionManager::get('default');
        $total_review = $connection->execute($sql, [$id])->fetchAll('assoc');
        $shop->set('total_review', json_encode($total_review[0]));

        foreach ($shop->reviews as $key => $value) {
            // ユーザに関する情報をセット
            $userInfo = $this->Util->getUserInfo($value->user);
            $exist = $this->S3Client->doesObjectExist(PATH_ROOT['USERS'] . DS . $value->user->file_name);
            // ファイルが存在したら、画像をセット
            if ($exist) {
                $userInfo = $userInfo + array('icon' => PATH_ROOT['URL_S3_BUCKET'] . DS . PATH_ROOT['USERS'] . DS . $value->user->file_name);
            } else {
                // 共通アイコン画像をセット
                $userInfo = $userInfo + array('icon' => PATH_ROOT['NO_IMAGE02']);
            }
            $value->user->icon = $userInfo['icon'];
        }
        $this->set('shopInfo', $this->Util->getShopInfo($shop));
        $this->set('next_view', PATH_ROOT['REVIEW']);
        $this->set(compact('shop', 'all_favo'));
        $this->render();
    }

    /**
     * ショップテーブルから検索条件による店舗情報を取得する
     *
     * @param array $validate
     * @return void
     */
    public function getShopList($requestData, $columns) {
        $query = $this->Shops->find();
        $findArray = array(); // 検索条件セット用
        foreach ($requestData as $key => $findData) {
            // リクエストデータが[key_word]かつ値が空じゃない場合
            if (($key == 'key_word') && ($findData !== "")) {
                foreach ($columns as $key => $value) {
                    $query->orWhere(function ($exp, $q) use ($value, $findData) {
                        $exp->like($value, '%' . $findData . '%');
                        return $exp;
                    });
                }
            } else {
                if ($findData !== "") {
                    //$findArray[] = ['shops.'.$key => $findData];
                    $query->where(['shops.' . $key => $findData]);
                }
            }
        }
        foreach ($query as $key => $value) {
            $value;
        }
        return $query->toArray();
    }

    /**
     * json返却用の設定
     *
     * @param array $validate
     * @return void
     */
    public function confReturnJson() {
        $this->viewBuilder()->autoLayout(false);
        $this->autoRender = false;
        $this->response->charset('UTF-8');
        $this->response->type('json');
    }
}
