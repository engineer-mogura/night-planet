<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
* Users Controller
*
* @property \App\Model\Table\UsersTable $Users
*
* @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/
class NewsController extends AppController
{

    public function initialize()
    {
         parent::initialize();
        $this->News = TableRegistry::get('news');

    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        // 常に現在エリアを取得
        $is_area = AREA['okinawa']['path'];
        // SEO対策
        $title = str_replace("_service_name_", LT['000'], TITLE['TOP_TITLE']);
        $description = str_replace("_service_name_", LT['000'], META['TOP_DESCRIPTION']);
        $this->set(compact("title", "description","is_area","is_login_modal_show"));
    }

    /**
     * json返却用の設定
     *
     * @param array $validate
     * @return void
     */
    public function index()
    {
        // ニュース取得
        $news = $this->Util->getNewss(PATH_ROOT[NEWS], null);
        $this->set('next_view', 'news');
        $this->set(compact('news'));
        $this->render();
        return;
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
