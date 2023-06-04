<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;
use App\Helper\helper;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/3/en/views.html#the-app-view
 */
class AppView extends View
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        // UserHelper.php 読み込み
        $this->loadHelper('User');
        $this->loadHelper('Form', [
        'templates' => 'app_form',
      ]);

        $this->assign('title', $this->viewVars['title']);
        // URLをスプリット
        $arrayUrl = explode(DS, rtrim($this->request->url, DS));
        // 空の場合はトップページになる
        if (empty($arrayUrl[0])) {
            $arrayUrl[0] = AREA['okinawa']['path'];
        }
        // ユーザー
        if ($arrayUrl[0] == PATH_ROOT['USER']) {
            // パンくずを設定する
            $this->setMyPageBreadcrumb($arrayUrl);
        } else if (array_key_exists($arrayUrl[0], AREA) || $arrayUrl[0] == 'search'
            || $arrayUrl[0] == 'news') {
            // パンくずを設定する
            $this->setBreadcrumb($arrayUrl);
        }
    }
    /**
     * パンくずを設定する
     *
     * @param array $breadcrumbList
     * @return void
     */
    public function setMyPageBreadcrumb($breadcrumbList)
    {
        // 次の画面がトップページの場合
        if ($this->viewVars['next_view'] == 'mypage') {
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => helper::encode('マイページ'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'mypage']]
            ]);
        } else if ($this->viewVars['next_view'] == 'profile') {
            // 次の画面がプロフィールページの場合
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => helper::encode('マイページ'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'mypage']],
                ['title' => helper::encode('プロフィール'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'profile']]
            ]);
        } else if ($this->viewVars['next_view'] == 'shop_favo') {
            // 次の画面が店舗お気に入りページの場合
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => helper::encode('マイページ'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'mypage']],
                ['title' => helper::encode('店舗お気に入り'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'shop_favo']]
            ]);
        } else if ($this->viewVars['next_view'] == 'cast_favo') {
            // 次の画面がスタッフお気に入りページの場合
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => helper::encode('マイページ'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'mypage']],
                ['title' => helper::encode('スタッフお気に入り'), 'url' => ['controller' => $breadcrumbList[1], 'action' => 'cast_favo']]
            ]);
        }
}
    /**
     * パンくずを設定する
     *
     * @param array $breadcrumbList
     * @return void
     */
    public function setBreadcrumb($breadcrumbList)
    {
        // 次の画面がエリアのトップページの場合
        if ($this->viewVars['next_view'] == 'news') {
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => helper::encode('ニュース'), 'url' => ['controller' => $breadcrumbList[0], 'action' => 'index']]
            ]);
        } else if ($this->viewVars['next_view'] == 'area') {
        // 次の画面がエリアのトップページの場合
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
                ['title' => AREA[$breadcrumbList[0]]['label'], 'url' => ['controller' => $breadcrumbList[0], 'action' => 'index']]
            ]);
        } else if ($this->viewVars['next_view'] == 'genre') {
        // 次の画面がエリアのジャンルの場合
            // リストに追加
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                , ['title' => AREA[$breadcrumbList[0]]['label']
                    , 'url' => ['controller' => $breadcrumbList[0]]],
            ]);
            // リストの最後に追加
            $this->Breadcrumbs->add(
                GENRE[$breadcrumbList[1]]['label'],
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        } else if ($this->viewVars['next_view'] == PATH_ROOT['SHOP']) {
            // 次の画面が店舗の場合
                // リストに追加
                $this->Breadcrumbs->add([
                    ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                    , ['title' => $this->viewVars['shopInfo']['area']['label']
                        , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']]]
                    , ['title' => $this->viewVars['shopInfo']['genre']['label']
                        ,'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                             .DS . $this->viewVars['shopInfo']['genre']['path']]],
                ]);
                // リストの最後に追加
                $this->Breadcrumbs->add(
                    $this->viewVars['shop']['name'],
                    "#!",
                    ['class' => 'breadcrumbs-tail']
                );
            } else if ($this->viewVars['next_view'] == PATH_ROOT['REVIEW']) {
            // 次の画面がレビューの場合
                // リストに追加
                $this->Breadcrumbs->add([
                    ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                    , ['title' => $this->viewVars['shopInfo']['area']['label']
                        , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']]]
                    , ['title' => $this->viewVars['shopInfo']['genre']['label']
                        ,'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                            .DS . $this->viewVars['shopInfo']['genre']['path']]]
                    , ['title' => $this->viewVars['shopInfo']['name']
                        , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                            .DS . $this->viewVars['shopInfo']['genre']['path']
                            .DS . $this->viewVars['shopInfo']['id']]],
                ]);
                // リストの最後に追加
                $this->Breadcrumbs->add(
                    SHOP_MENU_NAME['REVIEW'],
                    "#!",
                    ['class' => 'breadcrumbs-tail']
                );
            } else if ($this->viewVars['next_view'] == PATH_ROOT['CAST']) {
            // 次の画面がスタッフの場合
            // リストに追加
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                , ['title' => $this->viewVars['shopInfo']['area']['label']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']]]
                , ['title' => $this->viewVars['shopInfo']['genre']['label']
                    ,'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                        .DS . $this->viewVars['shopInfo']['genre']['path']]]
                , ['title' => $this->viewVars['shopInfo']['name']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                        .DS . $this->viewVars['shopInfo']['genre']['path']
                        .DS . $this->viewVars['shopInfo']['id']]],
            ]);
            // リストの最後に追加
            $this->Breadcrumbs->add(
                $this->viewVars['shop']['casts'][0]['nickname'],
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        } else if ($this->viewVars['next_view'] == PATH_ROOT['DIARY']) {
        // 次の画面が日記の場合
            // リストに追加
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                , ['title' => $this->viewVars['shopInfo']['area']['label']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']]]
                , ['title' => $this->viewVars['shopInfo']['genre']['label']
                    ,'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                    .DS . $this->viewVars['shopInfo']['genre']['path']]]
                , ['title' => $this->viewVars['shopInfo']['name']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                    .DS . $this->viewVars['shopInfo']['genre']['path']
                    .DS . $this->viewVars['shopInfo']['id']]]
                , ['title' => $this->viewVars['cast']['nickname']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                    .DS . PATH_ROOT['CAST']
                    .DS . $this->viewVars['cast']['id']]],
            ]);
            // リストの最後に追加
            $this->Breadcrumbs->add(
                helper::encode('日記'),
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        } else if ($this->viewVars['next_view'] == PATH_ROOT['GALLERY']) {
        // 次の画面がギャラリーの場合
            // リストに追加gallery
            $this->Breadcrumbs->add([
                ['title' => GENRE[$this->request->query['genre']]['label'],
                    'url' => ['controller' => $breadcrumbList[0], 'action' => 'genre/',
                    '?'=> ['genre' =>$this->request->query['genre']]]],
                ['title' => $this->request->query['name'],
                    'url' => ['controller' => $breadcrumbList[0], 'action' => 'shop/'.$this->request->query['shop'],
                    '?' => ['shop' => $this->request->query['shop'],'genre' => $this->request->query['genre'], 'name' => $this->request->query['name']]]],
                ['title' => $this->request->query['nickname'],
                    'url' => ['controller' => $breadcrumbList[0], 'action' => 'cast/'.$this->request->query['cast'],
                    '?' => ['shop' => $this->request->query['shop'], 'cast' => $this->request->query['cast'], 'genre' => $this->request->query['genre'] , 'name' => $this->request->query['name'],
                    'nickname' => $this->request->query['nickname']]]],
            ]);
            // リストの最後に追加
            $this->Breadcrumbs->add(
                helper::encode('ギャラリー'),
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        } else if ($this->viewVars['next_view'] == PATH_ROOT['NOTICE']) {
        // 次の画面がお知らせの場合
            // リストに追加
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS]
                , ['title' => $this->viewVars['shopInfo']['area']['label']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']]]
                , ['title' => $this->viewVars['shopInfo']['genre']['label']
                    ,'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                    .DS . $this->viewVars['shopInfo']['genre']['path']]]
                , ['title' => $this->viewVars['shopInfo']['name']
                    , 'url' => ['controller' => $this->viewVars['shopInfo']['area']['path']
                    .DS . $this->viewVars['shopInfo']['genre']['path']
                    .DS . $this->viewVars['shopInfo']['id']]],
            ]);
            // リストの最後に追加
            $this->Breadcrumbs->add(
                helper::encode('お知らせ'),
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        } else if ($this->viewVars['next_view'] == 'search') {
        // 次の画面が検索の場合
            // リストに追加
            $this->Breadcrumbs->add([
                ['title' => '<i class="material-icons">home</i>', 'url' => DS],
            ]);
            // リストの最後に追加
            $this->Breadcrumbs->add(
                helper::encode('検索'),
                "#!",
                ['class' => 'breadcrumbs-tail']
            );
        }

    }
}
