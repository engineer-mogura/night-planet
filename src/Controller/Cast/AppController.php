<?php
namespace App\Controller\Cast;

use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use App\Controller\S3Controller;

class AppController extends \App\Controller\AppController
{
    public $components = array('Util','S3Client');

    public function initialize()
    {
        parent::initialize();
        $this->S3Rapper      = new S3Controller();
        $this->Shops         = TableRegistry::get('shops');
        $this->Casts         = TableRegistry::get('casts');
        $this->Diarys        = TableRegistry::get('diarys');
        $this->DiaryLikes    = TableRegistry::get('diary_likes');
        $this->CastSchedules = TableRegistry::get('cast_schedules');
        $this->Snss          = TableRegistry::get('snss');
        $this->Updates       = TableRegistry::get('updates');
        $this->MasterCodes   = TableRegistry::get("master_codes");
        $this->Tmps          = TableRegistry::get("tmps");

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Casts',
                    'fields' => ['username' => 'email','password' => 'password']
                ],
               'NodeLink/RememberMe.Cookie' => [
                   'userModel' => 'Casts',  // 'Form'認証と同じモデルを指定します
                   'fields' => ['token' => 'remember_token'],  // Remember-Me認証用のトークンを保存するカラムを指定します
               ],
            ],
            'storage' => ['className' => 'Session', 'key' => 'Auth.Cast'],

            'loginAction' => ['controller' => 'Casts','action' => 'login'],
            'unauthorizedRedirect' => ['controller' => 'Casts','action' => 'login'],
            'loginRedirect' => ['controller' => 'Casts','action' => 'index'],
            'logoutRedirect' => ['controller' => 'Casts','action' => 'login'],
            // コントローラーで isAuthorized を使用します
            'authorize' => ['Controller'],
                // 未認証の場合、直前のページに戻します
            'unauthorizedRedirectedRedirect' => $this->referer()
        ]);

    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');

        // ログイン時に許可するアクション
        $access = ['index','favo','editCalendar','profile','saveProfile','topImage','saveTopImage'
            ,'gallery','saveGallery','sns','deleteGallery','diary'
            ,'saveDiary','viewDiary','deleteDiary','updateDiary','passChange'];
        if (in_array($action, $access)) {
            return true;
        }
        return false;
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup','verify','resetVerify','logout','passReset']);
        $this->Auth->config('authError', "もう一度ログインしてください。");
        parent::beforeRender($event); //親クラスのbeforeRendorを呼ぶ
        $this->viewBuilder()->layout('castDefault');
    }

   /**
     * ユーザのステータス、論理削除フラグチェック
     *
     * @param Array $user
     * @return Boolean $rslt
     */
    public function checkStatus($user)
    {
        $rslt = true;

        if ($user['delete_flag'] == 1) {
            $rslt = false;
            $body .= "そのままご送信ください。【ID】： ".$user->id."、";
            $body .= "【お名前】： ".$user->name."、";
            $body .= "【メールアドレス】： ".$user->email;

            $message = "アカウントが凍結または削除された可能性があります。アカウントを回復希望の方はお問い合わせのリンクを開きそのままご送信ください。";
            $this->log($this->Util->setLog($user, $message));
            $this->Flash->error($message . "<a href='mailto:info@night-planet.com?subject=アカウント回復希望&amp;body=".$body."'>お問い合わせ</a>", ['escape' => false]);
        }

        return $rslt;
    }
}
