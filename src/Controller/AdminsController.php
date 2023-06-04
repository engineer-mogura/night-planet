<?php
namespace App\Controller;

use Cake\Event\Event;
use Token\Util\Token;
use Cake\ORM\TableRegistry;
use Cake\Mailer\MailerAwareTrait;

/**
* Users Controller
*
* @property \App\Model\Table\UsersTable $Users
*
* @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/
class AdminsController extends AppController
{
    use MailerAwareTrait;
    public $components = array('Util');

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->Users = TableRegistry::get('users');
        $this->Shops = TableRegistry::get('shops');
        $this->Coupons = TableRegistry::get('coupons');
        $this->Casts = TableRegistry::get('casts');
        $this->Jobs = TableRegistry::get('jobs');
        $this->Shop_infos = TableRegistry::get('shop_infos');
        $this->Diarys = TableRegistry::get('diarys');
        $this->MasterCodes = TableRegistry::get("master_codes");
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->layout('simpleDefault');

        // SEO対策
        $title = str_replace("_service_name_", LT['000'], TITLE['TOP_TITLE']);
        $description = str_replace("_service_name_", LT['000'], META['TOP_DESCRIPTION']);
        $this->set(compact("title", "description"));
    }
    // ??????
    public function top()
    {
        $this->layout = false;

    }

}
