<?php

namespace App\Controller\Owner;

use Cake\Log\Log;
use Cake\Event\Event;
use RuntimeException;
use Token\Util\Token;
use Cake\Mailer\Email;
use Cake\Filesystem\File;
use \Cake\I18n\FrozenTime;
use Cake\Filesystem\Folder;
use Cake\Mailer\MailerAwareTrait;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;

/**
 * Owners Controller
 *
 * @property \App\Model\Table\OwnersTable $Owners
 *
 * @method \App\Model\Entity\Owner[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OwnersController extends AppController {
    use MailerAwareTrait;
    public $components = array('Security');

    public function beforeFilter(Event $event) {
        // AppController.beforeFilterをコールバック
        $this->Security->setConfig('blackHoleCallback', 'blackhole');
        // 店舗スイッチアクションのセキュリティ無効化 AJAXを使用しているので
        $this->Security->setConfig('unlockedActions', ['switchShop', 'saveProfile']);

        parent::beforeFilter($event);
        // オーナーに関する情報をセット
        if (!is_null($user = $this->Auth->user())) {
            $owner = $this->Owners->find("all")
                ->where(['owners.id' => $user['id']])
                ->contain(['ServecePlans'])
                ->first();
            $ownerInfo = $this->Util->getOwnerInfo($owner);
            $exist = $this->S3Client->doesObjectExist(PATH_ROOT['OWNERS'] . DS . $owner->icon_image_file);
            // ファイルが存在したら、画像をセット
            if ($exist) {
                $ownerInfo = $ownerInfo + array('icon' => PATH_ROOT['URL_S3_BUCKET'] . DS . PATH_ROOT['OWNERS'] . DS . $owner->icon_image_file);
            } else {
                // 共通アイコン画像をセット
                $ownerInfo = $ownerInfo + array('icon' => PATH_ROOT['NO_IMAGE02']);
            }
            $owner->icon = $ownerInfo['icon'];

            // 現在プラン適応フラグを取得する
            $is_range_plan = $this->Util->check_in_range(
                $owner->servece_plan->from_start,
                $owner->servece_plan->to_end,
                new FrozenTime(date("Y-m-d"))
            );
            $this->set(compact('ownerInfo', 'owner', 'is_range_plan'));
        }
    }

    public function login() {
        // レイアウトを使用しない
        $this->viewBuilder()->autoLayout(false);

        if ($this->request->is('post')) {

            // バリデーションはログイン用を使う。
            $owner = $this->Owners->newEntity($this->request->getData(), ['validate' => 'ownerLogin']);

            if (!$owner->errors()) {

                // 現在リクエスト中のユーザーを識別する
                $owner = $this->Auth->identify();
                if ($owner) {
                    // セッションにユーザー情報を保存する
                    $this->Auth->setUser($owner);
                    Log::info($this->Util->setAccessLog(
                        $owner,
                        $this->request->params['action']
                    ), 'access');

                    // TODO: 本来ログイン後は、元々のURLに飛ばしたい所だけど、固定でオーナーのトップ画面にする。
                    // AuthComponent.loginRedirectでURLの固定が難しい。
                    // 何かいい方法があれば...。
                    //   $this->request->session()->delete('Auth.redirect');
                    //   return $this->redirect($this->Auth->redirectUrl());
                    return $this->redirect(['action' => 'index']);
                }
                // ログイン失敗
                $this->Flash->error(RESULT_M['FRAUD_INPUT_FAILED']);
            } else {
                Log::error($this->Util->setAccessLog(
                    $owner,
                    $this->request->params['action']
                ) . '　失敗', 'access');
                foreach ($owner->errors() as $key1 => $value1) {
                    foreach ($value1 as $key2 => $value2) {
                        $this->Flash->error($value2);
                    }
                }
            }
        } else {
            $owner = $this->Owners->newEntity();
        }
        $this->set('owner', $owner);
    }

    /**
     * セッション情報を削除し、ログアウトする
     */
    public function logout() {
        $auth = $this->request->session()->read('Auth.Owner');
        $this->request->session()->destroy();
        Log::info($this->Util->setAccessLog(
            $auth,
            $this->request->params['action']
        ), 'access');

        // レイアウトを使用しない
        $this->viewBuilder()->autoLayout(false);
        $this->Flash->success(COMMON_M['LOGGED_OUT']);
        return $this->redirect($this->Auth->logout());
    }

    /**
     * snack function
     *
     * @return void
     */
    public function verifyError() {
        $this->viewBuilder()->layout('simpleDefault');
        $this->render('/Owner/Owners/verify_error');
        return;
    }

    /**
     * トークンをチェックして不整合が無ければ
     * ディレクトリを掘り、オーナー、店舗、求人情報を登録する
     *
     * @param [type] $token
     * @return void
     */
    public function verify($token) {
        try {
            $tmp = $this->Tmps->get(Token::getId($token));
        } catch (RuntimeException $e) {
            $this->Flash->error('URLが無効になっています。');
            return $this->redirect(['action' => 'verifyError']);
        }
        // 以下でトークンの有効期限や改ざんを検証することが出来る
        if (!$tmp->tokenVerify($token)) {
            $this->log($this->Util->setLog($tmp, RESULT_M['PASS_RESET_FAILED']));
            // 仮登録してるレコードを削除する
            $this->Tmps->delete($tmp);
            $this->Flash->success(RESULT_M['AUTH_FAILED']);
            return $this->redirect(['action' => 'verifyError']);
        }
        // 仮登録時点で仮登録フラグは立っていない想定。
        if ($tmp->status == 1) {
            // すでに登録しているとみなし、ログイン画面へ
            $this->Flash->success(RESULT_M['REGISTERED_FAILED']);
            return $this->redirect(['action' => 'login']);
        }

        // コネクションオブジェクト取得
        $connection = ConnectionManager::get('default');
        // トランザクション処理開始
        $connection->begin();

        try {

            // オーナー情報セット
            $data = [
                'name' => $tmp->name, 'role' => $tmp->role, 'tel' => $tmp->tel, 'email' => $tmp->email, 'password' => $tmp->password, 'age' => $tmp->age, 'status' => 1, 'gender' => $tmp->gender
            ];

            // 新規エンティティ
            $owner = $this->Owners->patchEntity($this->Owners->newEntity(), $data);

            // バリデーションチェック
            if ($owner->errors()) {
                $errors = $this->Util->setErrMessage($owner); // エラーメッセージをセット
                throw new RuntimeException($errors);
            }
            // オーナー本登録
            if (!$this->Owners->save($owner)) {
                throw new RuntimeException('レコードの更新に失敗しました。');
            }
            // プラン情報セット
            $servecePlans = $this->ServecePlans->newEntity();
            $servecePlans->owner_id = $owner->id;
            //**************************キャンペーン中 2019/12/1 ~ 2020/3/1 予定 *************************/
            // $servecePlans->current_plan = SERVECE_PLAN['free']['label'];
            // $servecePlans->previous_plan = SERVECE_PLAN['free']['label'];
            $servecePlans->current_plan = SERVECE_PLAN['basic']['label'];
            $servecePlans->previous_plan = SERVECE_PLAN['basic']['label'];
            $servecePlans->course        = 3;
            $servecePlans->from_start    = date('Y-m-d', strtotime("now"));
            $servecePlans->to_end        = date(
                'Y-m-d',
                strtotime("+" . 3 . "month")
            );
            //**************************キャンペーン中 2019/12/1 ~ 2020/3/1 予定 *************************/

            // バリデーションチェック
            if ($servecePlans->errors()) {
                $errors = $this->Util->setErrMessage($servecePlans); // エラーメッセージをセット
                throw new RuntimeException($errors);
            }
            // プラン登録
            if (!$this->ServecePlans->save($servecePlans)) {
                throw new RuntimeException('レコードの登録に失敗しました。');
            }

            // コミット
            $connection->commit();
            // 認証完了したら、メール送信
            $email = new Email('default');
            $email->setFrom([MAIL['SUPPORT_MAIL'] => MAIL['FROM_NAME']])
                ->setSubject($owner->name . "様、メールアドレスの認証が完了しました。")
                ->setTo($owner->email)
                ->setBcc(MAIL['SUPPORT_MAIL'])
                ->setTemplate("auth_success")
                ->setLayout("auth_success_layout")
                ->emailFormat("html")
                ->viewVars(['owner' => $owner])
                ->send();
            $this->set('owner', $owner);
            // 一時テーブル削除
            $this->Tmps->delete($tmp);
        } catch (RuntimeException $e) {
            // ロールバック
            $connection->rollback();
            $this->log($this->Util->setLog($owner, $e->__toString()));
            // 仮登録してるレコードを削除する
            $this->Tmps->delete($tmp);
            $this->Flash->error(RESULT_M['AUTH_FAILED'] . $e->getMessage());
            return $this->redirect(['action' => 'verifyError']);
        }

        // 認証完了でログインページへ
        $this->Flash->success(RESULT_M['AUTH_SUCCESS']);
        return $this->redirect(['action' => 'login']);
    }

    public function index() {
        $shops = $this->Shops->newEntity();
        // 認証されてる場合
        if (!is_null($user = $this->Auth->user())) {

            // 店舗追加フラグを設定する
            $is_add = true; // 店舗追加フラグ

            // オーナーに所属する全ての店舗を取得する
            $shops = $this->Shops->find('all')
                ->contain(['Owners', 'ShopLikes' => function ($q) {
                    return $q
                        ->select([
                            'ShopLikes.id', 'ShopLikes.shop_id', 'ShopLikes.user_id', 'total' => $q->func()->count('ShopLikes.shop_id')
                        ])
                        ->group('shop_id')
                        ->where(['ShopLikes.shop_id']);
                }])
                ->where(['owner_id' => $user['id']])->toArray();

            // 非表示または論理削除している場合はログイン画面にリダイレクトする
            if (!$this->checkStatus($user)) {
                return $this->redirect($this->Auth->logout());
            }

            $plan = $this->viewVars['ownerInfo']['current_plan'];

            // 店舗追加フラグを設定する
            if (count($shops) > 0) :
                $is_add = false;
                // プレミアムプランの場合は店舗フラグを立てる
                if ($plan == SERVECE_PLAN['premium_s']['label']) :
                    $is_add = true;
                endif;
            endif;

            // トップ画像を設定する
            foreach ($shops as $key => $shop) {
                $files = $this->S3Client->getList(
                    $this->s3Backet,
                    PATH_ROOT['SHOPS'] . DS . $shop['dir'] . DS . PATH_ROOT['TOP_IMAGE'],
                    1
                );
                // ファイルが存在したら、画像をセット
                if (is_countable($files) ? count($files) > 0 : 0) {
                    $shop->set('top_image', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
                } else {
                    // 共通トップ画像をセット
                    $shop->set('top_image', PATH_ROOT['SHOP_TOP_IMAGE']);
                }
            }
        }
        $owner = $this->viewVars['owner'];
        //$val = $this->Analytics->getAnalytics();
        $this->set(compact('shops', 'owner', 'is_add'));
        $this->render();
    }

    /**
     * 店舗 スイッチ押下処理
     *
     * @return void
     */
    public function switchShop() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $message = RESULT_M['DELETE_SUCCESS']; // 返却メッセージ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $auth = $this->request->session()->read('Auth.Owner');

        $shop = $this->Shops->get($this->request->getData('id'));
        // ステータスをセット
        $shop->status = $this->request->getData('status');
        // メッセージをセット
        $shop->status == 1 ?
            $message = RESULT_M['DISPLAY_SUCCESS'] : $message = RESULT_M['HIDDEN_SUCCESS'];
        try {
            // レコード更新実行
            if (!$this->Shops->save($shop)) {
                throw new RuntimeException('レコードの更新ができませんでした。');
            }
        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $message = RESULT_M['CHANGE_FAILED'];
            $flg = false;
        }

        $response = array(
            'success' => $flg,
            'message' => $message
        );
        $this->response->body(json_encode($response));
    }

    public function shopAdd() {
        $auth = $this->request->session()->read('Auth.Owner');

        // 非表示または論理削除している場合はログイン画面にリダイレクトする
        if (!$this->checkStatus($this->Owners->get($this->viewVars['ownerInfo']['id']))) {
            return $this->redirect($this->Auth->logout());
        }

        // オーナーに所属する店舗をカウント
        $shop_count = $this->Shops->find('all')
            ->where(['owner_id' => $this->viewVars['ownerInfo']['id']])
            ->count();
        $plan = $this->viewVars['ownerInfo']['current_plan'];

        try {
            // プレミアムSプラン以外 かつ 店舗が１件登録されている場合 不正なパターンでエラー
            if ($plan != SERVECE_PLAN['premium_s']['label'] && $shop_count >= 1) {
                throw new RuntimeException(RESULT_M['SHOP_ADD_FAILED'] . ' 不正アクセスがあります。');
            }
        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            // オーナートップページへ
            $search = array('_service_plan_');
            $replace = array(SERVECE_PLAN['premium_s']['name']);
            $message = $this->Util->strReplace($search, $replace, RESULT_M['SHOP_ADD_FAILED']);
            $this->Flash->error($message);
            return $this->redirect(['action' => 'index']);
        }

        // 登録ボタン押下時
        if ($this->request->is('post')) {

            // ディレクトリ存在フラグ
            $exists = true;
            $newDir = "";
            while ($exists) {
                $newDir = $this->Util->makeRandStr(15);
                $checkExistsPath = PATH_ROOT['SHOPS'] . DS . $newDir;
                $listObjects = $this->S3Client->getListObjects(null, $checkExistsPath, 1);
                if (is_null($listObjects['Contents'])) {
                    $exists = false;
                }
            }
            // オーナー情報セット
            $data = [
                'owner_id' => $this->viewVars['ownerInfo']['id'], 'name' => $this->request->getData('name'), 'area' => $this->request->getData('area'), 'genre' => $this->request->getData('genre'), 'status' => 0, 'delete_flag' => 0, 'dir' => $newDir
            ];

            // バリデーションは新規登録用を使う。
            $shop = $this->Shops->newEntity($data);

            if (!$shop->errors()) {

                // コネクションオブジェクト取得
                $connection = ConnectionManager::get('default');
                // トランザクション処理開始
                $connection->begin();

                try {
                    // 店舗登録
                    if (!$this->Shops->save($shop)) {
                        throw new RuntimeException('レコードの登録に失敗しました。');
                    }

                    // 求人情報セット
                    $job = $this->Jobs->newEntity();
                    $job->shop_id = $shop->id;
                    // 求人登録
                    if (!$this->Jobs->save($job)) {
                        throw new RuntimeException('レコードの登録に失敗しました。');
                    }
                    // マスタコード取得
                    $masCodeFind = array('option_menu_color');
                    $mast_data = $this->Util->getSelectList($masCodeFind, $this->MasterCodes, false);
                    // オプション情報セット
                    $shop_options = $this->ShopOptions->newEntity();
                    $shop_options->shop_id = $shop->id;
                    $shop_options->menu_color = array_keys($mast_data['option_menu_color'])[0];

                    // オプション登録
                    if (!$this->ShopOptions->save($shop_options)) {
                        throw new RuntimeException('レコードの登録に失敗しました。');
                    }

                    // コミット
                    $connection->commit();
                } catch (RuntimeException $e) {
                    // ロールバック
                    $connection->rollback();
                    $this->log($this->Util->setLog($shop, $e));
                    // 仮登録してるレコードを削除する
                    //$this->Owners->delete($shop);
                    $this->Flash->error(RESULT_M['SIGNUP_FAILED']);
                    return $this->redirect('/owner/owners/shop_add');
                }

                // オーナートップページへ
                $this->Flash->success(RESULT_M['SIGNUP_SUCCESS']);
                return $this->redirect(['action' => 'index']);
            } else {
                foreach ($shop->errors() as $key1 => $value1) {
                    foreach ($value1 as $key2 => $value2) {
                        $this->Flash->error($value2);
                    }
                }
            }
        }
        $masterCodesFind = array('area', 'genre');
        $selectList = $this->Util->getSelectList($masterCodesFind, $this->MasterCodes, false);
        $this->set(compact('shop', 'selectList'));
        $this->render();
    }

    /**
     * プロフィール画面の表示
     *
     * @return void
     */
    public function profile() {
        $auth = $this->request->session()->read('Auth.Owner');

        // 非表示または論理削除している場合はログイン画面にリダイレクトする
        if (!$this->checkStatus($this->Owners->get($this->viewVars['ownerInfo']['id']))) {
            return $this->redirect($this->Auth->logout());
        }

        $owner = $this->Owners->get($auth['id']);
        // // アイコン画像を設定する
        if (!empty($this->viewVars['ownerInfo']['icon'])) {
            $owner->icon = $this->viewVars['ownerInfo']['icon'];
        }

        // 作成するセレクトボックスを指定する
        $masCodeFind = array('age');
        // セレクトボックスを作成する
        $selectList = $this->Util->getSelectList($masCodeFind, $this->MasterCodes, true);

        $this->set(compact('owner', 'selectList'));
        $this->render();
    }

    /**
     * プロフィール画面の更新処理
     *
     * @return void
     */
    public function saveProfile() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }

        $auth = $this->request->session()->read('Auth.Owner');

        // 非表示または論理削除している場合はログイン画面にリダイレクトする
        if (!$this->checkStatus($this->Owners->get($this->viewVars['ownerInfo']['id']))) {
            return $this->redirect($this->Auth->logout());
        }

        $flg = true; // 返却フラグ
        $chkDuplicate = false; // ディレクトリ削除フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ

        // アイコン画像変更の場合
        if (isset($this->request->data["action_type"])) {

            $owner = $this->Owners->get($this->viewVars['ownerInfo']['id']);

            // アイコン画像を設定する
            $exist = $this->S3Client->doesObjectExist(PATH_ROOT['OWNERS'] . DS . $owner->icon_image_file);
            $fileBefor = null;
            // ファイルが存在したら、画像をセット
            if ($exist) {
                // トップ画像を設定する
                $fileBefor = PATH_ROOT['OWNERS'] . DS . $owner->icon_image_file;
            }

            // 新しいファイルを取得
            $file = $this->request->data['image'];

            // ファイルが存在する、かつファイル名がblobの画像のとき
            if (!empty($file["name"]) && $file["name"] == 'blob') {
                $limitFileSize = CAPACITY['MAX_NUM_BYTES_FILE'];
                try {
                    $convertFile = $this->Util->file_upload(
                        $file,
                        null,
                        $chkDuplicate,
                        $this->viewVars['ownerInfo']['icon'],
                        $limitFileSize
                    );

                    // 画像ファイルアップロード
                    $upResult = $this->S3Rapper->upload(
                        PATH_ROOT['OWNERS'] . DS . $convertFile,
                        $file["tmp_name"]
                    );
                    // 同じファイル名でない場合は前の画像を削除
                    if ((PATH_ROOT['OWNERS'] . DS . $convertFile !== $fileBefor) && !empty($fileBefor)) {
                        $delResult = $this->S3Rapper->delete($fileBefor);
                    }
                } catch (RuntimeException $e) {
                    $this->log($this->Util->setLog($auth, $e));
                    $flg = false;
                }
                try {

                    // バリデーションはプロフィール変更用を使う。
                    $owner->icon_image_file = $convertFile;

                    // レコード更新実行
                    if (!$this->Owners->save($owner)) {
                        throw new RuntimeException('レコードの更新ができませんでした。');
                    }
                } catch (RuntimeException $e) {
                    $this->log($this->Util->setLog($auth, $e));
                    $flg = false;
                    $message = RESULT_M['UPDATE_FAILED'];
                    $response = array(
                        'success' => $flg,
                        'message' => $message
                    );
                    $this->response->body(json_encode($response));
                    return;
                }
            }
            // 例外が発生している場合にメッセージをセットして返却する
            if (!$flg) {
                $message = RESULT_M['SIGNUP_FAILED'];
                $response = array(
                    'success' => $flg,
                    'message' => $message
                );
                $this->response->body(json_encode($response));
                return;
            }
            // 最新の画像をセット
            $owner->icon = PATH_ROOT['URL_S3_BUCKET'] . DS . PATH_ROOT['OWNERS'] . DS . $convertFile;
        } else {
            // バリデーションはプロフィール変更用を使う。
            $owner = $this->Owners->patchEntity($this->Owners
                ->get($auth['id']), $this->request->getData(), ['validate' => 'ownerRegistration']);
            // バリデーションチェック
            if ($owner->errors()) {
                $flg = false;
                // 入力エラーがあれば、メッセージをセットして返す
                $message = $this->Util->setErrMessage($owner); // エラーメッセージをセット
                $response = array(
                    'success' => $flg,
                    'message' => $message
                );
                $this->response->body(json_encode($response));
                return;
            }
            try {
                // レコード更新実行
                if (!$this->Owners->save($owner)) {
                    throw new RuntimeException('レコードの更新ができませんでした。');
                }
            } catch (RuntimeException $e) {
                $this->log($this->Util->setLog($auth, $e));
                $flg = false;
                $message = RESULT_M['UPDATE_FAILED'];
                $response = array(
                    'success' => $flg,
                    'message' => $message
                );
                $this->response->body(json_encode($response));
                return;
            }
            if (!empty($this->viewVars['ownerInfo']['icon'])) {
                $owner->icon = $this->viewVars['ownerInfo']['icon'];
            }
        }

        // 作成するセレクトボックスを指定する
        $masCodeFind = array('age');
        // セレクトボックスを作成する
        $selectList = $this->Util->getSelectList($masCodeFind, $this->MasterCodes, true);

        $this->set(compact('owner', 'selectList'));
        $this->render('/Owner/Owners/profile');
        $response = array(
            'html' => $this->response->body(),
            'error' => $errors,
            'success' => $flg,
            'message' => $message
        );
        $this->response->body(json_encode($response));
        return;
    }

    /**
     * 契約詳細画面の処理
     *
     * @return void
     */
    public function contractDetails() {
        $auth = $this->request->session()->read('Auth.Owner');

        $owner = $this->Owners->find('all')
            ->where(['owners.id' => $auth['id']])
            ->contain(['ServecePlans', 'Shops.Adsenses' => [
                'sort' => ['type' => 'ASC', 'valid_start' => 'ASC']
            ]])
            ->first();
        $owner->set('icon', $this->viewVars['owner']->icon);
        $this->set(compact('owner'));
        $this->render();
    }

    /**
     * プラン変更ボタンの処理
     *
     * @return void
     */
    public function changePlan() {
        $auth = $this->request->session()->read('Auth.Owner');

        if ($this->request->is('post')) {

            $owner = $this->Owners->find('all')
                ->where(['owners.id' => $auth['id']])
                ->contain(['ServecePlans', 'Shops.Adsenses' => [
                    'sort' => ['type' => 'ASC', 'valid_start' => 'ASC']
                ]])
                ->toArray();
            // 現在プランが適応中かチェックする
            // プランを強制的に変更した不正なアクセスの場合
            if ($this->viewVars['is_range_plan']) {
                $this->log($this->Util->setLog($auth, "プランを強制的に変更しようとした不正なアクセスです。"));
                $this->Flash->error(RESULT_M['CHANGE_PLAN_FAILED']);
                return $this->redirect('/owner/owners/contract_details');
            }

            $message = RESULT_M['CHANGE_PLAN_SUCCESS']; // 返却メッセージ

            // プラン情報セット
            $servecePlans                = $this->ServecePlans->get($auth['id']);
            $servecePlans->previous_plan = $servecePlans->current_plan;
            $servecePlans->current_plan  = $this->request->getData('plan');
            $servecePlans->course        = $this->request->getData('course');
            $servecePlans->from_start    = date('Y-m-d', strtotime("now"));
            $servecePlans->to_end        = date(
                'Y-m-d',
                strtotime("+" . $this->request->getData('course') . "month")
            );

            try {
                // レコード更新実行
                if (!$this->ServecePlans->save($servecePlans)) {
                    throw new RuntimeException('レコードの更新ができませんでした。');
                }

                $email = new Email('default');
                $email->setFrom([MAIL['SUBSCRIPTION_MAIL'] => MAIL['FROM_NAME']])
                    ->setSubject(MAIL['FROM_NAME_CHANGE_PLAN'])
                    ->setTo($owner[0]->email)
                    ->setBcc(MAIL['SUBSCRIPTION_MAIL'])
                    ->setTemplate("change_plan_success")
                    ->setLayout("simple_layout")
                    ->emailFormat("html")
                    ->viewVars(['owner' => $owner[0], 'servecePlans' => $servecePlans])
                    ->send();
                $this->set('owner', $owner[0]);
                // 完了メッセージ
                $this->Flash->success(RESULT_M['CHANGE_PLAN_SUCCESS']);
                Log::info("ID：【" . $owner[0]['id'] . "】アドレス：【" . $owner[0]->email
                    . "】" . RESULT_M['CHANGE_PLAN_SUCCESS'] . ', pass_reset');
            } catch (RuntimeException $e) {
                $this->log($this->Util->setLog($auth, $e));
                $this->Flash->error(RESULT_M['CHANGE_PLAN_FAILED']);
            }

            return $this->redirect('/owner/owners/contract_details');
        }

        $owner = $this->Owners->find('all')
            ->where(['owners.id' => $auth['id']])
            ->contain(['ServecePlans', 'Shops.Adsenses' => [
                'sort' => ['type' => 'ASC', 'valid_start' => 'ASC']
            ]])
            ->first();
        // 現在プランフラグをセットする
        $owner->set('is_range_plan', $this->viewVars['is_range_plan']);
        $owner->set('icon', $this->viewVars['owner']->icon);

        $this->set(compact('owner'));
        $this->render();
    }

    public function view($id = null) {

        if (isset($this->request->query["targetEdit"])) {
            $targetEdit = $this->request->getQuery("targetEdit");
            $shop = $this->Owners->find('all')->contain(['Shops']);

            if ($targetEdit == 'topImage') {
                $this->paginate = [
                    'contain' => ['Shops']
                ];

                $this->set(compact('shop'));
            }
        }
    }

    public function passReset() {
        // シンプルレイアウトを使用
        $this->viewBuilder()->layout('simpleDefault');

        if ($this->request->is('post')) {

            // バリデーションはパスワードリセットその１を使う。
            $owner = $this->Owners->newEntity(
                $this->request->getData(),
                ['validate' => 'OwnerPassReset1']
            );

            if (!$owner->errors()) {

                // メールアドレスで取得
                $owner = $this->Owners->find()
                    ->where(['email' => $owner->email])->first();

                // 非表示または論理削除している場合はログイン画面にリダイレクトする
                if (!$this->checkStatus($owner)) {
                    return $this->redirect($this->Auth->logout());
                }

                $email = new Email('default');
                $email->setFrom([MAIL['SUPPORT_MAIL'] => MAIL['FROM_NAME']])
                    ->setSubject(MAIL['FROM_NAME_PASS_RESET'])
                    ->setTo($owner->email)
                    ->setBcc(MAIL['SUPPORT_MAIL'])
                    ->setTemplate("pass_reset_email")
                    ->setLayout("simple_layout")
                    ->emailFormat("html")
                    ->viewVars(['owner' => $owner])
                    ->send();
                $this->set('owner', $owner);

                $this->Flash->success('パスワード再設定用メールを送信しました。しばらくしても届かない場合は迷惑メールフォルダをご確認ください。');
                Log::info("ID：【" . $owner['id'] . "】アドレス：【" . $owner->email
                    . "】パスワード再設定用メールを送信しました。", 'pass_reset');

                return $this->render('/common/pass_reset_send');
            } else {
                // 送信失敗
                foreach ($owner->errors() as $key1 => $value1) {
                    foreach ($value1 as $key2 => $value2) {
                        $this->Flash->error($value2);
                        Log::error("ID：【" . $owner['id'] . "】アドレス：【" . $owner->email
                            . "】エラー：【" . $value2 . "】", 'pass_reset');
                    }
                }
            }
        } else {
            $owner = $this->Owners->newEntity();
        }
        $this->set('owner', $owner);
        return $this->render('/common/pass_reset_form');
    }

    /**
     * トークンをチェックして不整合が無ければ
     * パスワードの変更をする
     *
     * @param [type] $token
     * @return void
     */
    public function resetVerify($token) {

        // シンプルレイアウトを使用
        $this->viewBuilder()->layout('simpleDefault');
        $owner = $this->Auth->identify();
        try {
            $owner = $this->Owners->get(Token::getId($token));
        } catch (RuntimeException $e) {
            $this->Flash->error('URLが無効になっています。');
            return $this->redirect(['action' => 'login']);
        }

        // 以下でトークンの有効期限や改ざんを検証することが出来る
        if (!$owner->tokenVerify($token)) {
            Log::info("ID：【" . $owner->id . "】" . "アドレス：【" . $owner->email . "】" .
                "エラー：【" . RESULT_M['PASS_RESET_FAILED'] . "】アクション：【"
                . $this->request->params['action'] . "】", "pass_reset");

            $this->Flash->error(RESULT_M['PASS_RESET_FAILED']);
            return $this->redirect(['action' => 'login']);
        }

        if ($this->request->is('post')) {
            // パスワードリセットフォームの表示フラグ
            $is_reset_form = false;

            // バリデーションはパスワードリセットその２を使う。
            $validate = $this->Owners->newEntity(
                $this->request->getData(),
                ['validate' => 'OwnerPassReset2']
            );

            if (!$validate->errors()) {

                // 再設定したパスワードを設定する
                $hasher = new DefaultPasswordHasher();
                $owner->password =  $hasher->hash($this->request->getData('password'));
                // 自動ログインフラグを下げる
                $owner->remember_token = 0;

                // 一応ちゃんと変更されたかチェックする
                if (!$owner->isDirty('password')) {

                    Log::info("ID：【" . $owner->id . "】" . "アドレス：【" . $owner->email . "】" .
                        "エラー：【パスワードの変更に失敗しました。】アクション：【"
                        . $this->request->params['action'] . "】", "pass_reset");

                    $this->Flash->error('パスワードの変更に失敗しました。');
                    return $this->redirect(['action' => 'login']);
                }

                if ($this->Owners->save($owner)) {

                    // 変更完了したら、メール送信
                    $email = new Email('default');
                    $email->setFrom([MAIL['SUPPORT_MAIL'] => MAIL['FROM_NAME']])
                        ->setSubject($owner->name . "様、メールアドレスの変更が完了しました。")
                        ->setTo($owner->email)
                        ->setBcc(MAIL['SUPPORT_MAIL'])
                        ->setTemplate("pass_reset_success")
                        ->setLayout("simple_layout")
                        ->emailFormat("html")
                        ->viewVars(['owner' => $owner])
                        ->send();
                    $this->set('owner', $owner);

                    // 変更完了でログインページへ
                    $this->Flash->success(RESULT_M['PASS_RESET_SUCCESS']);
                    Log::info("ID：【" . $owner['id'] . "】アドレス：【" . $owner->email
                        . "】" . RESULT_M['PASS_RESET_SUCCESS'], 'pass_reset');
                    return $this->redirect(['action' => 'login']);
                }
            } else {

                // パスワードリセットフォームの表示フラグ
                $is_reset_form = true;
                $this->set(compact('is_reset_form'));
                // 入力エラーがあれば、メッセージをセットして返す
                $this->Flash->error(__('入力内容に誤りがあります。'));
                return $this->render('/common/pass_reset_form');
            }
        } else {

            // パスワードリセットフォームの表示フラグ
            $is_reset_form = true;
            $this->set(compact('is_reset_form', 'owner'));
            return $this->render('/common/pass_reset_form');
        }
    }

    public function passChange() {
        $auth = $this->request->session()->read('Auth.Owner');

        if ($this->request->is('post')) {

            $isValidate = false; // エラー有無
            // バリデーションはパスワードリセットその３を使う。
            $validate = $this->Owners->newEntity(
                $this->request->getData(),
                ['validate' => 'OwnerPassReset3']
            );

            if (!$validate->errors()) {

                $hasher = new DefaultPasswordHasher();
                $owner = $this->viewVars['owner'];

                // 非表示または論理削除している場合はログイン画面にリダイレクトする
                if (!$this->checkStatus($owner)) {
                    return $this->redirect($this->Auth->logout());
                }

                $equal_check = $hasher->check(
                    $this->request->getData('password'),
                    $owner->password
                );
                // 入力した現在のパスワードとデータベースのパスワードを比較する
                if (!$equal_check) {
                    $this->Flash->error('現在のパスワードが間違っています。');
                    return $this->render();
                }
                // 新しいパスワードを設定する
                $hasher = new DefaultPasswordHasher();
                $owner->password =  $hasher->hash($this->request->getData('password_new'));

                // 一応ちゃんと変更されたかチェックする
                if (!$owner->isDirty('password')) {

                    Log::info("ID：【" . $owner->id . "】" . "アドレス：【" . $owner->email . "】" .
                        "エラー：【パスワードの変更に失敗しました。】アクション：【"
                        . $this->request->params['action'] . "】", "pass_reset");

                    $this->Flash->error('パスワードの変更に失敗しました。');
                    return $this->render();
                }

                try {
                    // レコード更新実行
                    if (!$this->Owners->save($owner)) {
                        throw new RuntimeException('レコードの更新ができませんでした。');
                    }
                    // 変更完了したら、メール送信
                    $email = new Email('default');
                    $email->setFrom([MAIL['SUPPORT_MAIL'] => MAIL['FROM_NAME']])
                        ->setSubject($owner->name . "様、メールアドレスの変更が完了しました。")
                        ->setTo($owner->email)
                        ->setBcc(MAIL['SUPPORT_MAIL'])
                        ->setTemplate("pass_reset_success")
                        ->setLayout("simple_layout")
                        ->emailFormat("html")
                        ->viewVars(['owner' => $owner])
                        ->send();
                    $this->set('owner', $owner);

                    // 変更完了でログインページへ
                    $this->Flash->success(RESULT_M['PASS_RESET_SUCCESS']);
                    Log::info("ID：【" . $owner['id'] . "】アドレス：【" . $owner->email
                        . "】" . RESULT_M['PASS_RESET_SUCCESS'], 'pass_reset');

                    return $this->redirect(['action' => 'login']);
                } catch (RuntimeException $e) {
                    $this->log($this->Util->setLog($auth, $e));
                    $this->Flash->error('パスワードの変更に失敗しました。');
                }
            } else {
                $owner = $validate;
            }
        } else {
            $owner = $this->Owners->newEntity();
        }
        $owner->icon = $this->viewVars['owner']->icon;

        $this->set('owner', $owner);
        return $this->render();
    }

    public function blackhole($type) {
        switch ($type) {
            case 'csrf':
                $this->Flash->error(__('不正な送信が行われました'));
                $this->redirect(array('controller' => 'owners', 'action' => 'index'));
                break;
            default:
                $this->Flash->error(__('不正な送信が行われました'));
                $this->redirect(array('controller' => 'owners', 'action' => 'index'));
                break;
        }
    }
}
