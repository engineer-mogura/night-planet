<?php
namespace App\Controller;

use \Cake\ORM\Query;
use Cake\Event\Event;
use Token\Util\Token;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Mailer\MailerAwareTrait;

/**
* Users Controller
*
* @property \App\Model\Table\UsersTable $Users
*
* @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/
class UnknowController extends AppController
{
    use MailerAwareTrait;

    public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::get('users');
        $this->Shops = TableRegistry::get('shops');
        $this->Coupons = TableRegistry::get('coupons');
        $this->Casts = TableRegistry::get('casts');
        $this->Jobs = TableRegistry::get('jobs');
        $this->MasterCodes = TableRegistry::get("master_codes");
    }

    public function beforeFilter(Event $event)
    {
        // parent::beforeFilter($event);
        // $this->Auth->allow(['signup','verify','logout']);
        parent::beforeRender($event); //親クラスのbeforeRendorを呼ぶ
        $this->viewBuilder()->layout('unknowDefault');

        $query = $this->request->getQuery();
        // 検索結果でエリア、ジャンルで文言を決める
        $result = '';
        if (!empty($query['area']) && !empty($query['genre'])) {
            // コントローラでセットされたresultを代入してセパレータを追加
            $result .=  AREA[$query['area']]['label'] . 'の'.
                        GENRE[$query['genre']]['label'].'一覧';
        } elseif (!empty($query['area'])) {
            $result .=  AREA[$query['area']]['label'] . '一覧';
        } elseif (!empty($query['genre'])) {
            $result .=  GENRE[$query['genre']]['label'] . '一覧';
        }
        // SEO対策
        $title = str_replace("_service_name_", LT['000'], TITLE['SEARCH_TITLE']);
        $description = str_replace("_service_name_", LT['000'], META['SEARCH_DESCRIPTION']);

        $this->set(compact("result", "title", "description"));
    }

    public function shop()
    {
        // urlパラメタ
        $arg        = $this->request->getQuery();
        $area_genre = ['area'=> AREA[$arg['area']], 'genre'=>GENRE[$arg['genre']]];
        $unknow     = true;
        $search = $this->Shops->find()
            ->where(['area'=>$arg['area'],'genre'=>$arg['genre'],
                'shops.status = 1 AND shops.delete_flag = 0'])
            ->contain(['snss'])->toArray();

        // 画像を設定する
        foreach ($search as $key => $shop) {
            $path = DS.PATH_ROOT['URL_S3_BUCKET'].DS.AREA[$shop->area]['path']
                .DS.GENRE[$shop->genre]['path']
                .DS.$shop->dir.DS.PATH_ROOT['TOP_IMAGE'];
            $dir = new Folder(preg_replace('/(\/\/)/', '/', WWW_ROOT.$path), true, 0755);

            $files = array();
            $files = glob($dir->path.DS.'*.*');
            // ファイルが存在したら、画像をセット
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $shop->set('top_image', $path.DS.(basename($file)));
                }
            } else {
                // 共通画像をセット
                $shop->set('top_image', PATH_ROOT['SHOP_TOP_IMAGE']);
            }
        }

        // 検索条件を取得し、画面側でselectedする
        $selected = $this->request->getQuery();
        $masterCodesFind = array('area','genre');
        $selectList = $this->Util->getSelectList($masterCodesFind, $this->MasterCodes, false);

        $this->set(compact('search', 'unknow', 'area_genre', 'selectList'));
        $this->render();
    }

    public function cast()
    {
        // 検索ボックス内容セットする
        $masterCodesFind = array('area','genre');
        $selectList = $this->Util->getSelectList($masterCodesFind, $this->MasterCodes, false);

        $this->set(compact('selectList'));
        $this->render();
    }

    public function diary()
    {
        // 検索ボックス内容セットする
        $masterCodesFind = array('area','genre');
        $selectList = $this->Util->getSelectList($masterCodesFind, $this->MasterCodes, false);

        $this->set(compact('selectList'));
        $this->render();
    }

    /**
     * json返却用の設定
     *
     * @param array $validate
     * @return void
     */
    public function confReturnJson()
    {
        $this->viewBuilder()->autoLayout(false);
        $this->autoRender = false;
        $this->response->charset('UTF-8');
        $this->response->type('json');
    }
}
