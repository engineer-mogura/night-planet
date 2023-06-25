<?php

namespace App\Controller\Owner;

use Cake\Event\Event;
use App\Controller\S3Controller;

class AppController extends \App\Controller\AppController {

    public $components = array('S3Client');

    public function initialize() {
        parent::initialize();
        $this->S3Rapper      = new S3Controller();

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Owners',
                    'fields' => ['username' => 'email', 'password' => 'password']
                ],
                'NodeLink/RememberMe.Cookie' => [
                    'userModel' => 'Owners',  // 'Form'認証と同じモデルを指定します
                    'fields' => ['token' => 'remember_token'],  // Remember-Me認証用のトークンを保存するカラムを指定します
                ],
            ],
            'storage' => ['className' => 'Session', 'key' => 'Auth.Owner'],

            'loginAction' => ['controller' => 'Owners', 'action' => 'login'],
            'unauthorizedRedirect' => ['controller' => 'Owners', 'action' => 'login'],
            'loginRedirect' => ['controller' => 'Owners', 'action' => 'index'],
            'logoutRedirect' => ['controller' => 'Owners', 'action' => 'login'],
            // コントローラーで isAuthorized を使用します
            'authorize' => ['Controller'],
            // 未認証の場合、直前のページに戻します
            'unauthorizedRedirectedRedirect' => $this->referer()
        ]);
    }

    public function isAuthorized($user) {
        $action = $this->request->getParam('action');

        // ログイン時に許可するオーナー画面アクション
        $ownerAccess = ['index', 'switchShop', 'shopAdd', 'profile', 'saveProfile', 'contractDetails', 'changePlan', 'passChange'];

        // ログイン時に許可する店舗編集画面アクション
        $shopAccess = [
            'index', 'shopEdit', 'saveTopImage', 'saveCatch', 'deleteCatch',
            'saveCoupon', 'deleteCoupon', 'switchCoupon', 'deleteCoupon', 'saveCast', 'switchCast',
            'deleteCast', 'saveTenpo', 'saveJob', 'saveSns', 'saveGallery', 'deleteGallery', 'notice', 'viewNotice',
            'saveNotice', 'updateNotice', 'deleteNotice', 'option', 'workSchedule', 'saveWorkSchedule'
        ];

        //TODO: 権限によって店舗管理者のみとオーナー兼店舗管理者を分ける？
        // 今は、分けず各アクションは統合する
        $access = array_merge($ownerAccess, $shopAccess);
        if (in_array($action, $access)) {
            return true;
        }
        return false;
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup', 'verify', 'resetVerify', 'logout', 'passReset', 'verifyError']);
        $this->Auth->config('authError', "もう一度ログインしてください。");
        parent::beforeRender($event); //親クラスのbeforeRendorを呼ぶ
        // オーナー用テンプレート
        $this->viewBuilder()->layout('ownerDefault');
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

    /**
     * ユーザのステータス、論理削除フラグチェック
     *
     * @param Array $user
     * @return Boolean $rslt
     */
    public function checkStatus($user) {
        $rslt = true;

        if ($user['delete_flag'] == 1) {
            $rslt = false;
            $body .= "そのままご送信ください。【ID】： " . $user->id . "、";
            $body .= "【お名前】： " . $user->name . "、";
            $body .= "【メールアドレス】： " . $user->email;

            $message = "アカウントが凍結または削除された可能性があります。アカウントを回復希望の方はお問い合わせのリンクを開きそのままご送信ください。";
            $this->log($this->Util->setLog($user, $message));
            $this->Flash->error($message . "<a href='mailto:info@night-planet.com?subject=アカウント回復希望&amp;body=" . $body . "'>お問い合わせ</a>", ['escape' => false]);
        }

        return $rslt;
    }
}
