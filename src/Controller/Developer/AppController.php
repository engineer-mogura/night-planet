<?php
namespace App\Controller\Developer;

use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class AppController extends \App\Controller\AppController
{
    public $components = array('Util');

    public function initialize()
    {
        parent::initialize();
        $this->Developers  = TableRegistry::get('developers');
        $this->News        = TableRegistry::get('news');
        $this->Updates     = TableRegistry::get('updates');
        $this->Tmps        = TableRegistry::get("tmps");

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Developers',
                    'fields' => ['username' => 'email','password' => 'password']
                ],
               'NodeLink/RememberMe.Cookie' => [
                   'userModel' => 'Developers',  // 'Form'認証と同じモデルを指定します
                   'fields' => ['token' => 'remember_token'],  // Remember-Me認証用のトークンを保存するカラムを指定します
               ],
            ],
            'storage' => ['className' => 'Session', 'key' => 'Auth.Developer'],

            'loginAction' => ['controller' => 'Developers','action' => 'login'],
            'unauthorizedRedirect' => ['controller' => 'Developers','action' => 'login'],
            'loginRedirect' => ['controller' => 'Developers','action' => 'index'],
            'logoutRedirect' => ['controller' => 'Developers','action' => 'login'],
            // コントローラーで isAuthorized を使用します
            'authorize' => ['Controller'],
                // 未認証の場合、直前のページに戻します
            'unauthorizedRedirectedRedirect' => $this->referer()
        ]);

    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');

        // ログイン時に許可するデベロッパ画面アクション
        $access = ['index','news','viewNews'
            , 'saveNews','updateNews','deleteNews'];

        if (in_array($action, $access)) {
            return true;
        }
        return false;
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup','logout']);
        $this->Auth->config('authError', "もう一度ログインしてください。");
        parent::beforeRender($event); //親クラスのbeforeRendorを呼ぶ
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
