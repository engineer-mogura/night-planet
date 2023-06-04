<?php
namespace App\Controller\Owner;

use Cake\I18n\Time;
use \Cake\ORM\Query;
use Cake\Event\Event;
use RuntimeException;
use Cake\Mailer\Email;
use MethodNotAllowedException;
use Cake\Mailer\MailerAwareTrait;

/**
 * Controls the data flow into shops object and updates the view whenever data changes.
 */
class ShopsController extends AppController
{
    use MailerAwareTrait;

    public function beforeFilter(Event $event) {
        // AppController.beforeFilterをコールバック
        parent::beforeFilter($event);
        // 店舗編集用テンプレート
        $this->viewBuilder()->layout('shopDefault');
        // 店舗に関する情報をセット
        if(!is_null($user = $this->Auth->user())){

            // URLに店舗IDが存在する場合、セッションに店舗IDをセットする
            if($this->request->getQuery('shop_id')) {
                $this->request->session()->write('shop_id', $this->request->getQuery('shop_id'));
            }
            // セッションに店舗IDをセットする
            if ($this->request->session()->check('shop_id')) {
                $shopId = $this->request->session()->read('shop_id');
            }

            // オーナーに関する情報をセット
            $owner = $this->Owners->find("all")
                ->where(['owners.id'=>$user['id']])
                ->contain(['ServecePlans'])
                ->first();
            $ownerInfo = $this->Util->getOwnerInfo($owner);

            // 店舗情報取得
            $shop = $this->Shops->find('all')
                ->where(['id' => $shopId , 'owner_id' => $user['id']])
                ->first();
            $shopInfo = $this->Util->getShopInfo($shop);

            $exist = $this->S3Client->doesObjectExist(PATH_ROOT['OWNERS'] . DS . $owner->icon_image_file);
            // ファイルが存在したら、画像をセット
            if ($exist) {
                $ownerInfo = $ownerInfo + array('icon' => PATH_ROOT['URL_S3_BUCKET'] . DS . PATH_ROOT['OWNERS'] . DS . $owner->icon_image_file);
            } else {
                // 共通アイコン画像をセット
                $ownerInfo = $ownerInfo + array('icon' => PATH_ROOT['NO_IMAGE02']);
            }
            $owner->icon = $ownerInfo['icon'];

            $this->set(compact('shopInfo', 'ownerInfo', 'owner', 'shop'));
        }
    }

    /**
     * 編集画面の処理
     *
     * @param [type] $id
     * @return void
     */
    public function index()
    {

        // アクティブタブ
        $selected_tab = "";
        // サイドバーメニューのパラメータがあればセッションにセットする
        if (isset($this->request->data["selected_tab"])) {
            $this->request->session()->write('selected_tab', $this->request->getData("selected_tab"));
        }
        // セッションにアクティブタブがセットされていればセットする
        if ($this->request->session()->check('selected_tab')) {
            $selectedTab = $this->request->session()->consume('selected_tab');
        }

        if(!is_null($user = $this->Auth->user())){
            $shop = $this->Shops->find()
                ->where(['shops.id'=> $this->viewVars["shopInfo"]["id"] , 'owner_id' => $user['id']])
                ->contain(['Coupons','Jobs','Snss','Casts' => function(Query $q) {
                return $q->where(['Casts.delete_flag'=>'0']);
            }])->first();

            // 現在日付
            $date = Time::now();
            $y = $date->year;
            $ym = $date->year . '-' . $date->month;

            $range_years  = array();
            $range_months = array();
            $access_years = array();
            $access_months = array();
            $access_weeks = array();

            $access_years = $this->AccessYears->find()
                                ->where(['shop_id' => $shop->id, 'owner_id' => $shop->owner_id])
                                ->order(['y' => 'DESC'])->toArray();
            $access_months = $this->AccessMonths->find()
                                ->where(['shop_id' => $shop->id, 'owner_id' => $shop->owner_id])
                                ->order(['ym' => 'DESC'])->toArray();
            foreach ($access_years as $key => $value) {
                array_push($range_years, $value->y);
            }
            foreach ($access_months as $key => $value) {
                array_push($range_months, $value->ym);
            }
            $access_weeks = $this->AccessWeeks->find()
                                ->where(['shop_id' => $shop->id, 'owner_id' => $shop->owner_id])
                                ->toArray();

            $reports = array('access_years' => json_encode($access_years)
                            , 'access_months' => json_encode($access_months)
                            , 'access_weeks' => json_encode($access_weeks)
                            , 'ranges' => [$range_years, $range_months]);
        }

        $this->set(compact('shop', 'reports'/*, 'ranges' */));
        $this->render();
    }
    /**
     * 編集画面遷移の処理
     *
     * @param [type] $id
     * @return void
     */
    public function shopEdit()
    {
        // アクティブタブ
        $selected_tab = "";
        // サイドバーメニューのパラメータがあればセッションにセットする
        if (isset($this->request->query["select_tab"])) {
            $this->request->session()->write('select_tab', $this->request->query["select_tab"]);
        }
        // セッションにアクティブタブがセットされていればセットする
        if ($this->request->session()->check('select_tab')) {
            $select_tab = $this->request->session()->consume('select_tab');
        }

        if(!is_null($user = $this->Auth->user())){
            $shop = $this->Shops->find()
                    ->where(['shops.id'=> $this->viewVars["shopInfo"]["id"] , 'owner_id' => $user['id']])
                    ->contain(['Coupons','Jobs','Snss','Casts'])
                ->first();
            $tmps  = $this->Tmps->find()
                ->where(['shop_id' => $this->viewVars["shopInfo"]["id"]])
                ->toArray();

            // 承認待ちユーザー追加
            foreach ($tmps as $key => $tmp) {
                array_unshift($shop->casts, $tmp);
            }
        }

        // トップ画像を設定する
        $files = $this->S3Client->getList($this->s3Backet,
             $this->viewVars['shopInfo']['top_image_path'], 1);
        // ファイルが存在したら、画像をセット
        if (is_countable($files) ? count($files) > 0 : 0) {
            $shop->set('top_image', PATH_ROOT['URL_S3_BUCKET'].DS.$files[0]);
        } else {
            // 共通トップ画像をセット
            $shop->set('top_image', PATH_ROOT['SHOP_TOP_IMAGE']);
        }

        // ギャラリーリストを作成
        $gallery = array();

        $files = $this->S3Client->getList($this->s3Backet, $this->viewVars['shopInfo']['image_path']);
        usort($files, $this->Util->sortByLastmod);
        foreach ($files as $file) {
            $timestamp = date('Y/m/d H:i', filemtime($file));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $file, "date" => $timestamp
                , "simple_path" => $file

            ));
        }
        $shop->set('gallery', $gallery);

        // スタッフのアイコンを設定する
        foreach ($shop->casts as $key => $cast) {

            $path = $this->viewVars['shopInfo']['cast_path'] . DS . $cast->dir . DS . PATH_ROOT['ICON'];

            // トップ画像を設定する
            $files = null;
            try {
                $files = $this->S3Client->getList($this->s3Backet, $path, 1);
            } catch (RuntimeException $e) {
                // 承認待ちユーザーを考慮
                if (!empty($cast->dir)) {
                    throw new RuntimeException($e);
                }
            }

            // ファイルが存在したら、画像をセット
            if (is_countable($files) ? count($files) > 0 : 0) {
                $cast->set('icon', PATH_ROOT['URL_S3_BUCKET'].DS.$files[0]);
            } else {
                // 共通トップ画像をセット
                $cast->set('icon', PATH_ROOT['NO_IMAGE02']);
            }
        }

        // 作成するセレクトボックスを指定する
        $masCodeFind = array('industry','job_type','treatment','day');
        // セレクトボックスを作成する
        $selectList = $this->Util->getSelectList($masCodeFind,$this->MasterCodes,true);
        // マスタコードのクレジットリスト取得
        $masCredit = $this->MasterCodes->find()->where(['code_group' => 'credit'])->toArray();
        // 店舗情報のクレジットリストを作成する
        $shopCredits = $this->Util->getCredit($shop->credit, $masCredit);
        // マスタコードの待遇リスト取得
        $masTreatment = $this->MasterCodes->find()->where(['code_group' => 'treatment'])->toArray();
        // 求人情報の待遇リストを作成する
        $jobTreatments = $this->Util->getTreatment(reset($shop->jobs)['treatment'], $masTreatment);
        // クレジット、待遇リストをセット
        $masData = array('credit'=>json_encode($shopCredits),'treatment'=>json_encode($jobTreatments));

        $this->set(compact('shop','gallery','masCredit','masData','selectList','select_tab'));
        $this->render();
    }

   /**
     * トップ画像 編集押下処理
     *
     * @return void
     */
    public function saveTopImage()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $chkDuplicate = false; // ディレクトリ削除フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['SIGNUP_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');

        $shop = $this->Shops->get($this->viewVars['shopInfo']['id']);

        // トップ画像を設定する
        $fileBefor = $this->S3Client->getList($this->s3Backet,
             $this->viewVars['shopInfo']['top_image_path'], 1);

        // 新しいファイルを取得
        $file = $this->request->getData('top_image_file');

        // ファイルが存在する、かつファイル名がblobの画像のとき
        if (!empty($file["name"]) && $file["name"] == 'blob') {
            $limitFileSize = CAPACITY['MAX_NUM_BYTES_FILE'];

            try {
                $convertFile = $this->Util->file_upload($file, null, $chkDuplicate
                                , $this->viewVars['shopInfo']['top_image_path']
                                , $limitFileSize);
                // 画像ファイルアップロード
                $upResult = $this->S3Rapper->upload(
                    $this->viewVars['shopInfo']['top_image_path'] . DS . $convertFile, $file["tmp_name"]);
                // 同じファイル名でない場合は前の画像を削除
                if (($this->viewVars['shopInfo']['top_image_path'] . DS . $convertFile !== $fileBefor[0]) && !empty($fileBefor)) {
                    $delResult = $this->S3Rapper->delete($fileBefor[0]);
                }

                // 更新情報を追加する
                $updates = $this->Updates->newEntity();
                $updates->set('content','トップ画像を更新しました。');
                $updates->set('shop_id', $this->viewVars['shopInfo']['id']);
                $updates->set('type', SHOP_MENU_NAME['SHOP_TOP_IMAGE']);
                // レコード更新実行
                if (!$this->Updates->save($updates)) {
                    throw new RuntimeException('レコードの登録ができませんでした。');
                }

            } catch (RuntimeException $e) {
                $this->log($this->Util->setLog($auth, $e));
                $flg = false;
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

        $shop = $this->viewVars['shop'];

        // トップ画像を設定する
        $files = $this->S3Client->getList($this->s3Backet,
            $this->viewVars['shopInfo']['top_image_path'], 1);
        // ファイルが存在したら、画像をセット
        if (is_countable($files) ? count($files) > 0 : 0) {
            $shop->set('top_image', PATH_ROOT['URL_S3_BUCKET'].DS.$files[0]);
        } else {
            // 共通トップ画像をセット
            $shop->set('top_image', PATH_ROOT['SHOP_TOP_IMAGE']);
        }

        $this->set(compact('shop'));
        $this->render('/Element/shopEdit/top-image');
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
     * クーポン 削除押下処理
     *
     * @return void
     */
    public function deleteCatch()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $message = RESULT_M['DELETE_SUCCESS']; // 返却メッセージ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $auth = $this->request->session()->read('Auth.Owner');

        $shop = $this->Shops->patchEntity($this->Shops
            ->get($this->viewVars['shopInfo']['id']), $this->request->getData());

        if (!$this->Shops->save($shop)) {
            $this->log($this->Util->setLog($auth, $e));
            $message = RESULT_M['DELETE_FAILED'];
            $flg = false;
        }

        $shop = $this->Shops->get($this->viewVars['shopInfo']['id']);

        $this->set(compact('shop'));
        $this->render('/Element/shopEdit/catch');
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
     * キャッチコピー 編集押下処理
     *
     * @return void
     */
    public function saveCatch()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');

        $shop = $this->Shops->patchEntity($this->Shops
            ->get($this->viewVars['shopInfo']['id']), $this->request->getData());

        // バリデーションチェック
        if ($shop->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($shop); // エラーメッセージをセット
            $response = array('success'=>false,'message'=>$errors);
            $this->response->body(json_encode($response));
            return;
        }
        try {
            // レコード更新実行
            if (!$this->Shops->save($shop)) {
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

        $shop = $this->Shops->get($this->viewVars['shopInfo']['id']);
        $this->set(compact('shop'));
        $this->render('/Element/shopEdit/catch');
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
     * クーポン スイッチ押下処理
     *
     * @return void
     */
    public function switchCoupon()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $message = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $auth = $this->request->session()->read('Auth.Owner');

        $coupon = $this->Coupons->get($this->request->getData('id'));
        // ステータスをセット
        $coupon->status = $this->request->getData('status');
        // メッセージをセット
        $coupon->status == 1 ? 
            $message = RESULT_M['DISPLAY_SUCCESS']: $message = RESULT_M['HIDDEN_SUCCESS'];
        try {
            // レコード更新実行
            if (!$this->Coupons->save($coupon)) {
                throw new RuntimeException('レコードの更新ができませんでした。');
            }
        } catch(RuntimeException $e) {
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

    /**
     * クーポン 削除押下処理
     *
     * @param [type] $id
     * @return void
     */
    public function deleteCoupon()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $message = RESULT_M['DELETE_SUCCESS']; // 返却メッセージ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $auth = $this->request->session()->read('Auth.Owner');

        $coupon = $this->Coupons->get($this->request->getData('id'));

        if (!$this->Coupons->delete($coupon)) {
            $this->log($this->Util->setLog($auth, $e));
            $message = RESULT_M['DELETE_FAILED'];
            $flg = false;
        }

        $shop = $this->Shops->find()
            ->where(['id' => $this->viewVars['shopInfo']['id']])
            ->contain(['Coupons'])->first();
        $this->set(compact('shop'));
        $this->render('/Element/shopEdit/coupon');
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
     * クーポン 編集押下処理
     *
     * @param [type] $id
     * @return void
     */
    public function saveCoupon()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $auth = $this->request->session()->read('Auth.Owner');

        // 新規登録 店舗IDとステータスもセットする
        if($this->request->getData('crud_type') == 'insert') {
            $coupon = $this->Coupons->newEntity(array_merge(
                ['shop_id' => $this->viewVars['shopInfo']['id'], 'status'=>0]
                    ,$this->request->getData()));
            $message = RESULT_M['SIGNUP_SUCCESS']; // 返却メッセージ
        } else if($this->request->getData('crud_type') == 'update') {
        // 更新
            $coupon = $this->Coupons->patchEntity($this->Coupons
                ->get($this->request->getData('id')), $this->request->getData());
            $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
        }

        // バリデーションチェック
        if ($coupon->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($coupon); // エラーメッセージをセット
            $response = array('success'=>false,'message'=>$errors);
            $this->response->body(json_encode($response));
            return;
        }
        try {
            // レコード登録、更新実行
            if (!$this->Coupons->save($coupon)) {
                if($this->request->getData('crud_type') == 'insert') {
                    throw new RuntimeException('レコードの登録ができませんでした。');
                } else {
                    throw new RuntimeException('レコードの更新ができませんでした。');
                }
            }
            // 更新情報を追加する
            $updates = $this->Updates->newEntity();
            $updates->set('content','クーポン情報を更新しました。');
            $updates->set('shop_id', $this->viewVars['shopInfo']['id']);
            $updates->set('type', SHOP_MENU_NAME['COUPON']);
            // レコード更新実行
            if (!$this->Updates->save($updates)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }
        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
            $message = RESULT_M['UPDATE_FAILED'];
            if($this->request->getData('crud_type') == 'insert') {
                $message = RESULT_M['SIGNUP_FAILED'];
            }
            $response = array(
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;
        }

        $shop = $this->Shops->find()
            ->where(['id' => $this->viewVars['shopInfo']['id']])
            ->contain(['Coupons'])->first();
        $this->set(compact('shop'));
        $this->render('/Element/shopEdit/coupon');
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
     * スタッフ スイッチ押下処理
     *
     * @return void
     */
    public function switchCast()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $message = RESULT_M['DELETE_SUCCESS']; // 返却メッセージ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $auth = $this->request->session()->read('Auth.Owner');

        $cast = $this->Casts->get($this->request->getData('id'));
        // ステータスをセット
        $cast->status = $this->request->getData('status');
        // メッセージをセット
        $cast->status == 1 ? 
            $message = RESULT_M['DISPLAY_SUCCESS']: $message = RESULT_M['HIDDEN_SUCCESS'];
        try {
            // レコード更新実行
            if (!$this->Casts->save($cast)) {
                throw new RuntimeException('レコードの更新ができませんでした。');
            }
        } catch(RuntimeException $e) {
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
    /**
     * スタッフ 削除押下処理
     *
     * @return void
     */
    public function deleteCast()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');

        try {

            $del_path =$this->viewVars['shopInfo']['cast_path'] . DS . $this->request->getData('dir');
            // 削除対象レコード取得
            $cast = $this->Casts->get($this->request->getData('id'));
            // レコード削除実行
            if (!$this->Casts->delete($cast)) {
                throw new RuntimeException('レコードの削除ができませんでした。');
            }
        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
        }
        // 例外が発生している場合にメッセージをセットして返却する
        if (!$flg) {
            $message = RESULT_M['DELETE_FAILED'];
            $response = array(
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;
        }

        $shop = $this->Shops->find()
            ->where(['id' => $this->viewVars['shopInfo']['id']])
            ->contain(['Casts' => function(Query $q) {
                    return $q->where(['casts.delete_flag'=>'0']);
                }])->first();

        // スタッフのアイコンを設定する
        foreach ($shop->casts as $key => $cast) {

            $path = $this->viewVars['shopInfo']['cast_path'] . DS . $cast->dir . DS . PATH_ROOT['ICON'];

            // トップ画像を設定する
            $files = null;
            try {
                $files = $this->S3Client->getList($this->s3Backet, $path, 1);
            } catch (RuntimeException $e) {
                // 承認待ちユーザーを考慮
                if (!empty($cast->dir)) {
                    throw new RuntimeException($e);
                }
            }

            // ファイルが存在したら、画像をセット
            if (is_countable($files) ? count($files) > 0 : 0) {
                $cast->set('icon', PATH_ROOT['URL_S3_BUCKET'].DS.$files[0]);
            } else {
                // 共通トップ画像をセット
                $cast->set('icon', PATH_ROOT['NO_IMAGE02']);
            }
        }

        $this->set(compact('shop'));
        $this->render('/Element/shopEdit/cast');
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
     * スタッフ 編集押下処理
     *
     * @return void
     */
    public function saveCast()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定

        // 新規登録(仮登録) 店舗IDとステータスも論理削除フラグセットする
        if($this->request->getData('crud_type') == 'insert') {
            $cast = $this->Tmps->newEntity(array_merge(
                ['shop_id' => $this->viewVars['shopInfo']['id'], 'status' => 0 , 'delete_flag' => 1]
                    , $this->request->getData())
                    , ['validate' => 'castRegistration']);

            $message = MAIL['CAST_AUTH_CONFIRMATION']; // 返却メッセージ
        } else if($this->request->getData('crud_type') == 'update') {
            // 更新
            $cast = $this->Casts->patchEntity($this->Casts
                ->get($this->request->getData('id')), $this->request->getData());
            $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
        }
        // バリデーションチェック
        if ($cast->errors()) {
            $flg = false;
            // 入力エラーがあれば、メッセージをセットして返す
            $message = $this->Util->setErrMessage($cast); // エラーメッセージをセット
            $response = array(
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;
        }
        try {

            if($this->request->getData('crud_type') == 'insert') {
                // レコード一時登録実行
                if (!$this->Tmps->save($cast)) {
                    $message = RESULT_M['SIGNUP_FAILED'];
                    throw new RuntimeException('レコードの一時登録ができませんでした。');
                }

            } else {
                // レコード更新実行
                if (!$this->Casts->save($cast)) {
                    $message = RESULT_M['SIGNUP_FAILED'];
                    throw new RuntimeException('レコードの更新ができませんでした。');
                }

            }
        } catch(RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
            $response = array(
                'success' => $flg,
                'message' => $message,
            );
            $this->response->body(json_encode($response));
            return;
        }

        // 新規登録(仮登録)できた場合、登録したメールアドレスに認証メールを送る
        if ($this->request->getData('crud_type') == 'insert') {

            $email = new Email('default');
            $email->setFrom([MAIL['FROM_SUBSCRIPTION'] => MAIL['FROM_NAME']])
                ->setSubject($cast->name."様、【".$this->viewVars['shopInfo']['name']."】様よりスタッフ登録のご案内があります。")
                ->setTo($cast->email)
                ->setBcc(MAIL['FROM_INFO_GMAIL'])
                ->setTemplate("auth_send")
                ->setLayout("simple_layout")
                ->emailFormat("html")
                ->viewVars(['cast' => $cast
                    ,'shop_name' => $this->viewVars['shopInfo']['name']])
                ->send();
            $this->log($email,'debug');
            $this->Flash->success($message);
        }
        $shop = $this->Shops->find()
                ->where(['id' => $this->viewVars['shopInfo']['id']])
                ->contain(['Casts'])
            ->first();
        $shop = $this->Shops->find()
                ->where(['shops.id'=> $this->viewVars["shopInfo"]["id"]])
                ->contain(['Coupons','Jobs','Snss','Casts'])
            ->first();
        $tmps  = $this->Tmps->find()
            ->where(['shop_id' => $this->viewVars["shopInfo"]["id"]])
            ->toArray();
        // 承認待ちユーザー追加
        foreach ($tmps as $key => $tmp) {
            array_unshift($shop->casts, $tmp);
        }

        // スタッフのアイコンを設定する
        foreach ($shop->casts as $key => $cast) {

            $path = $this->viewVars['shopInfo']['cast_path'] . DS . $cast->dir . DS . PATH_ROOT['ICON'];

            // トップ画像を設定する
            $files = null;
            try {
                $files = $this->S3Client->getList($this->s3Backet, $path, 1);
            } catch (RuntimeException $e) {
                // 承認待ちユーザーを考慮
                if (!empty($cast->dir)) {
                    throw new RuntimeException($e);
                }
            }

            // ファイルが存在したら、画像をセット
            if (is_countable($files) ? count($files) > 0 : 0) {
                $cast->set('icon', PATH_ROOT['URL_S3_BUCKET'].DS.$files[0]);
            } else {
                // 共通トップ画像をセット
                $cast->set('icon', PATH_ROOT['NO_IMAGE02']);
            }
        }

        $this->set(compact('shop'));
        $this->render('/Element/shopEdit/cast');
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
     * 店舗情報 編集押下処理
     *
     * @return void
     */
    public function saveTenpo()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');

        $shop = $this->Shops->patchEntity($this->Shops
            ->get($this->viewVars['shopInfo']['id']), $this->request->getData());

        // バリデーションチェック
        if ($shop->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($shop); // エラーメッセージをセット
            $response = array('success'=>false,'message'=>$errors);
            $this->response->body(json_encode($response));
            return;
        }
        try {
            // レコード更新実行
            if (!$this->Shops->save($shop)) {
                throw new RuntimeException('レコードの更新ができませんでした。');
            }
            // 更新情報を追加する
            $updates = $this->Updates->newEntity();
            $updates->set('content','店舗情報を更新しました。');
            $updates->set('shop_id', $this->viewVars['shopInfo']['id']);
            $updates->set('type', SHOP_MENU_NAME['SYSTEM']);
            // レコード更新実行
            if (!$this->Updates->save($updates)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
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

        $shop = $this->Shops->find()
            ->where(['id' => $this->viewVars['shopInfo']['id']])
            ->contain(['Casts' => function(Query $q) {
                return $q->where(['Casts.delete_flag'=>'0']);
            }])->first();

        // マスタコードのクレジットリスト取得
        $masCredit = $this->MasterCodes->find()->where(['code_group' => 'credit'])->toArray();
        // 店舗のクレジットリストを作成する
        $shopCredits = $this->Util->getCredit($shop->credit, $masCredit);
        // クレジットリストをセット
        $masData = array('credit'=>json_encode($shopCredits));
        $this->set(compact('shop','masData','masCredit'));
        $this->render('/Element/shopEdit/tenpo');
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
     * 求人情報 編集押下処理
     *
     * @return void
     */
    public function saveJob()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');

        $job = $this->Jobs->patchEntity($this->Jobs
            ->get($this->request->getData('id')), $this->request->getData());

        // バリデーションチェック
        if ($job->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($job); // エラーメッセージをセット
            $response = array('success'=>false,'message'=>$errors);
            $this->response->body(json_encode($response));
            return;
        }
        try {
            // レコード更新実行
            if (!$this->Jobs->save($job)) {
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

        $shop = $this->Shops->find()
            ->where(['id' => $this->viewVars['shopInfo']['id']])
            ->contain(['Jobs'])->first();

        // 作成するセレクトボックスを指定する
        $masCodeFind = array('industry','job_type','treatment','day');
        // セレクトボックスを作成する
        $selectList = $this->Util->getSelectList($masCodeFind,$this->MasterCodes,true);
        // マスタコードの待遇リスト取得
        $masTreatment = $this->MasterCodes->find()->where(['code_group' => 'treatment'])->toArray();
        // 求人情報の待遇リストを作成する
        $jobTreatments = $this->Util->getTreatment(reset($shop->jobs)['treatment'], $masTreatment);
        // 待遇リストをセット
        $masData = array('treatment'=>json_encode($jobTreatments));

        $this->set(compact('shop','masData','selectList'));
        $this->render('/Element/shopEdit/job');
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
     * sns 編集押下処理
     *
     * @return void
     */
    public function saveSns()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');
        $plan = $this->viewVars['userInfo']['current_plan'];

        try {
            // フリープラン かつ Instagramが入力されていた場合 不正なパターンでエラー
            if ($plan == SERVECE_PLAN['free']['label'] && !empty($this->request->getData('instagram'))) {
                throw new RuntimeException(RESULT_M['INSTA_ADD_FAILED'].' 不正アクセスがあります。');
            }
        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            // エラーメッセージをセット
            $response = array('success'=>false,'message'=>RESULT_M['INSTA_ADD_FAILED']);
            $this->response->body(json_encode($response));
            return;
        }

        // レコードが存在するか
        // レコードがない場合は、新規で登録を行う。
        if(!$this->Snss->exists(['shop_id' =>$this->viewVars['shopInfo']['id']])) {
            $sns = $this->Snss->newEntity($this->request->getData());
            $sns->shop_id = $this->viewVars['shopInfo']['id'];
        } else {
            $sns = $this->Snss->patchEntity($this->Snss
            ->get($this->request->getData('id')), $this->request->getData());
        }

        // バリデーションチェック
        if ($sns->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($sns); // エラーメッセージをセット
            $response = array('success'=>false,'message'=>$errors);
            $this->response->body(json_encode($response));
            return;
        }
        try {
            // レコード更新実行
            if (!$this->Snss->save($sns)) {
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

        $shop = $this->Shops->find()
            ->where(['id' => $this->viewVars['shopInfo']['id']])
            ->contain(['Snss'])->first();

        $this->set(compact('shop'));
        $this->render('/Element/shopEdit/sns');
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
     * ギャラリー 編集押下処理
     *
     * @return void
     */
    public function saveGallery()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $isDuplicate = false; // 画像重複フラグ
        $chkDuplicate = true; // ディレクトリ削除フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');
        $files = array();

        // 既に登録された画像があればデコードし格納、無ければ空の配列を格納する
        ($files_befor = json_decode($this->request->getData("gallery_befor")
            , true)) > 0 ? : $files_befor = array();

        try{

            // 追加画像がある場合
            if (isset($this->request->data["image"])) {
                $files = $this->request->data['image'];
            }

            foreach ($files as $key => $file) {
                // ファイルが存在する、かつファイル名がblobの画像のとき
                if (!empty($file["name"]) && $file["name"] == 'blob') {
                    $limitFileSize = CAPACITY['MAX_NUM_BYTES_FILE'];

                    // ファイル名を取得する
                    $convertFile = $this->Util->file_upload($file, $files_befor, $chkDuplicate
                        , $this->viewVars['shopInfo']['image_path'], $limitFileSize);

                    // ファイル名が同じ場合は重複フラグをセットする
                    if ($convertFile === false) {
                        $isDuplicate = true;
                        continue;
                    }

                    $result = $this->S3Rapper->upload(
                        $this->viewVars['shopInfo']['image_path'] . DS . $convertFile, $file["tmp_name"]);
                }
            }

            // 更新情報を追加する
            $updates = $this->Updates->newEntity();
            $updates->set('content','店内ギャラリーを更新しました。');
            $updates->set('shop_id', $this->viewVars['shopInfo']['id']);
            $updates->set('type', SHOP_MENU_NAME['SHOP_GALLERY']);
            // レコード更新実行
            if (!$this->Updates->save($updates)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }

        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
        }

        // 例外が発生している場合にメッセージをセットして返却する
        if (!$flg) {

            $message = RESULT_M['UPDATE_FAILED'];
            $response = array(
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;
        }

        // ギャラリーリストを作成
        $gallery = array();

        $files = $this->S3Client->getList($this->s3Backet, $this->viewVars['shopInfo']['image_path']);
        usort($files, $this->Util->sortByLastmod);
        foreach ($files as $file) {
            $timestamp = date('Y/m/d H:i', filemtime($file));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $file, "date" => $timestamp
                , "simple_path" => $file

            ));
        }

        $this->set(compact('gallery'));
        $this->render('/Element/shopEdit/gallery');
        $response = array(
            'html' => $this->response->body(),
            'error' => $errors,
            'success' => $flg,
            'message' => $isDuplicate ? $message . "\n" . RESULT_M['DUPLICATE'] : $message
        );
        $this->response->body(json_encode($response));
        return;
    }

    /**
     * ギャラリー 削除押下処理
     *
     * @return void
     */
    public function deleteGallery()
    {

        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }

        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['DELETE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');

        try {
            $result = $this->S3Rapper->delete($this->request->getData('file_path'));
            // // AWS削除マーカーチェック
            // if ($result['DeleteMarker']) {
            //     throw new RuntimeException('その画像はすでに削除されたか、存在しません。');
            // } else {
            //     throw new RuntimeException('画像の削除ができませんでした。');
            // }
        } catch (RuntimeException $e) {

            $this->log($this->Util->setLog($auth, $e->getMessage()));
            $flg = false;
        }
        // 例外が発生している場合にメッセージをセットして返却する
        if (!$flg) {
            $message = RESULT_M['DELETE_FAILED'];
            $response = array(
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;
        }

        // ギャラリーリストを作成
        $gallery = array();

        $files = $this->S3Client->getList($this->s3Backet, $this->viewVars['shopInfo']['image_path']);
        usort($files, $this->Util->sortByLastmod);
        foreach ($files as $file) {
            $timestamp = date('Y/m/d H:i', filemtime($file));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $file, "date" => $timestamp
                , "simple_path" => $file

            ));
        }

        $this->set(compact('gallery'));
        $this->render('/Element/shopEdit/gallery');
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
     * お知らせ 画面表示処理
     *
     * @return void
     */
    public function notice()
    {
        $allNotice = $this->getAllNotice($this->viewVars['shopInfo']['id']
            , $this->viewVars['shopInfo']['notice_path'], null);
        $top_notice = $allNotice[0];
        $arcive_notice = $allNotice[1];
        $this->set(compact('top_notice', 'arcive_notice'));
        return $this->render();
    }

    /**
     * お知らせ 登録処理
     * @return void
     */
    public function saveNotice()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $isDuplicate = false; // 画像重複フラグ
        $errors = ""; // 返却メッセージ
        $chkDuplicate = true; // ディレクトリ削除フラグ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['SIGNUP_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');
        $files = array();

        $files_befor = array(); // 新規なので空の配列

        // エンティティにマッピングする
        $notice = $this->ShopInfos->newEntity($this->request->getData());
        // バリデーションチェック
        if ($notice->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($notice); // エラーメッセージをセット
            $response = array('success'=>false,'message'=>$errors);
            $this->response->body(json_encode($response));
            return;
        }
        // お知らせ用のディレクトリを掘る
        $date = new Time();
        $noticePath =  DS . $date->format('Y')
            . DS . $date->format('m') . DS . $date->format('d')
            . DS . $date->format('Ymd_His');
        $notice->dir = $noticePath; // お知らせのパスをセット
        try {

            // 追加画像がある場合
            if (isset($this->request->data["image"])) {
                $files = $this->request->data['image'];
            }

            foreach ($files as $key => $file) {
                // ファイルが存在する、かつファイル名がblobの画像のとき
                if (!empty($file["name"]) && $file["name"] == 'blob') {
                    $limitFileSize = CAPACITY['MAX_NUM_BYTES_FILE'];

                    // ファイル名を取得する
                    $convertFile = $this->Util->file_upload($file, $files_befor, $chkDuplicate
                        , $this->viewVars['shopInfo']['notice_path'] . $notice->dir, $limitFileSize);

                    // ファイル名が同じ場合は重複フラグをセットする
                    if ($convertFile === false) {
                        $isDuplicate = true;
                        continue;
                    }

                    $result = $this->S3Rapper->upload(
                        $this->viewVars['shopInfo']['notice_path'] . $notice->dir . DS . $convertFile, $file["tmp_name"]);
                }
            }

            // レコード更新実行
            if (!$this->ShopInfos->save($notice)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }
            // 更新情報を追加する
            $updates = $this->Updates->newEntity();
            $updates->set('content','店舗からのお知らせを追加しました。');
            $updates->set('shop_id', $this->viewVars['shopInfo']['id']);
            $updates->set('type', SHOP_MENU_NAME['EVENT']);
            // レコード更新実行
            if (!$this->Updates->save($updates)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }

        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
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
        // お知らせ取得
        $allNotice = $this->getAllNotice($this->viewVars['shopInfo']['id']
            , $this->viewVars['shopInfo']['notice_path'], null);
        $top_notice = $allNotice[0];
        $arcive_notice = $allNotice[1];

        $this->set(compact('top_notice', 'arcive_notice'));
        $this->render('/Owner/Shops/notice');
        $response = array(
            'html' => $this->response->body(),
            'error' => $errors,
            'success' => $flg,
            'message' => $isDuplicate ? $message . "\n" . RESULT_M['DUPLICATE'] : $message
        );
        $this->response->body(json_encode($response));
        return;
    }

    /**
     * お知らせアーカイブ表示画面の処理
     *
     * @return void
     */
    public function viewNotice()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $this->confReturnJson(); // json返却用の設定

        $notice = $this->Util->getNotice($this->request->query["id"]
            , $this->viewVars['shopInfo']['notice_path']);

        $this->response->body(json_encode($notice));
        return;
    }

    /**
     * お知らせアーカイブ更新処理
     *
     * @return void
     */
    public function updateNotice()
    {

        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $isDuplicate = false; // 画像重複フラグ
        $chkDuplicate = false; // ディレクトリ削除フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');
        $files = array();

        // エンティティにマッピングする
        $notice = $this->ShopInfos->patchEntity($this->ShopInfos
            ->get($this->request->data['notice_id']), $this->request->getData());
        // バリデーションチェック
        if ($notice->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($notice); // エラーメッセージをセット
            $response = array('result'=>false,'errors'=>$errors);
            $this->response->body(json_encode($response));
            return;
        }

        $delFiles = json_decode($this->request->data["del_list"], true);
        // 既に登録された画像があればデコードし格納、無ければ空の配列を格納する
        ($files_befor = json_decode($this->request->data["json_data"], true)) > 0
            ? : $files_befor = array();
        try {

            // 削除する画像分処理する
            foreach ($delFiles as $key => $file) {
                $file['path'] = str_replace(env('AWS_URL_HOST').DS.env('AWS_BUCKET'), '', $file['path']);
                $result = $this->S3Rapper->delete($file['path']);
            }
            // 追加画像がある場合
            if (isset($this->request->data["image"])) {
                $files = $this->request->data['image'];
            }
            // 追加画像分処理する
            foreach ($files as $key => $file) {
                // ファイルが存在する、かつファイル名がblobの画像のとき
                if (!empty($file["name"]) && $file["name"] == 'blob') {
                    $limitFileSize = CAPACITY['MAX_NUM_BYTES_FILE'];
                    // ファイル名を取得する
                    $convertFile = $this->Util->file_upload($file, $files_befor, $chkDuplicate
                        , $this->request->data["dir_path"], $limitFileSize);

                    // ファイル名が同じ場合は処理をスキップする
                    if ($convertFile === false) {
                        $isDuplicate = true;
                        continue;
                    }
                    $result = $this->S3Rapper->upload(
                        $this->request->data["dir_path"] . DS . $convertFile, $file["tmp_name"]);
                }
            }

            // レコード更新実行
            if (!$this->ShopInfos->save($notice)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }

        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
        }

        // 例外が発生している場合にメッセージをセットして返却する
        if (!$flg) {
            $message = RESULT_M['UPDATE_FAILED'];
            $flg = false;
            $response = array(
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;
        }

        // お知らせ取得
        $allNotice = $this->getAllNotice($this->viewVars['shopInfo']['id']
            , $this->viewVars['shopInfo']['notice_path'], null);
        $top_notice = $allNotice[0];
        $arcive_notice = $allNotice[1];

        $this->set(compact('top_notice', 'arcive_notice'));
        $this->render('/Owner/Shops/notice');
        $response = array(
            'html' => $this->response->body(),
            'error' => $errors,
            'success' => $flg,
            'message' => $isDuplicate ? $message . "\n" . RESULT_M['DUPLICATE'] : $message
        );
        $this->response->body(json_encode($response));
        return;
    }

    /**
     * お知らせアーカイブ削除処理
     *
     * @return void
     */
    public function deleteNotice()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['DELETE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');

        try {
            $result = $this->S3Rapper->deleteDirectory($this->request->getData('dir_path'));
            // // AWS削除マーカーチェック
            // if ($result['DeleteMarker']) {
            //     throw new RuntimeException('その画像はすでに削除されたか、存在しません。');
            // } else {
            //     throw new RuntimeException('画像の削除ができませんでした。');
            // }

            // 削除対象レコード取得
            $notice = $this->ShopInfos->get($this->request->getData('id'));
            // レコード削除実行
            if (!$this->ShopInfos->delete($notice)) {
                throw new RuntimeException('レコードの削除ができませんでした。');
            }
        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
        }
        // 例外が発生している場合にメッセージをセットして返却する
        if (!$flg) {
            $message = RESULT_M['DELETE_FAILED'];
            $response = array(
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;
        }

        // お知らせ取得
        $allNotice = $this->getAllNotice($this->viewVars['shopInfo']['id']
            , $this->viewVars['shopInfo']['notice_path'], null);
        $top_notice = $allNotice[0];
        $arcive_notice = $allNotice[1];

        $this->set(compact('top_notice', 'arcive_notice'));
        $this->render('/Owner/Shops/notice');
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
     * 出勤管理 画面表示処理
     *
     * @return void
     */
    public function workSchedule()
    {
        $start_date = new Time(date('Y-m-d 00:00:00')); // システム日時を取得
        $start_date->day(1); // システム月の月初を取得
        $end_date = new Time(date('Y-m-d 00:00:00')); // システム日時を取得
        $last_month = $end_date->modify('last day of next month'); // 翌日の月末を取得
        $end_date = new Time($last_month->format('Y-m-d') .' 23:59:59'); // 翌日の月末の日付変わる直前を取得

        // 店舗に所属するスタッフの
        // 当月の月初から翌日の月末の日付変わる直前までのスタッフのスケジュールを取得する
        $casts = $this->Casts->find('all')
            ->where(['shop_id' => $this->viewVars['shopInfo']['id']
                    , 'casts.status' => 1 , 'casts.delete_flag' => 0])
            ->contain(['Shops'
                , 'CastSchedules' => function (Query $q) use ($start_date, $end_date)  {
                    return $q
                    ->where(['CastSchedules.start >='=> $start_date
                            , 'CastSchedules.start <='=> $end_date])
                    ->order(['CastSchedules.start'=>'ASC']);
            }])->order(['casts.created'=>'DESC'])->toArray();

        $workSchedule = $this->WorkSchedules->find('all')
            ->where(['work_schedules.shop_id' => $this->viewVars['shopInfo']['id']])
            ->first();
        $castIds = explode(',', $workSchedule['cast_ids']);

        // スタッフ配列リスト
        // $castList = array();
        $tempList = array();

        $dateList = $this->Util->getPeriodDate();
        $workPlanBase = array();
        // 未入力値で初期化する
        for ($i=0; $i < count($dateList); $i++) {
            $workPlanBase[] = 'ー';
        }

        // スタッフ情報を配列にセット
        foreach ($casts as $key1 => $cast) {

            $castInfo = $this->Util->getCastInfo($cast, $cast->shop);
            $workPlan = $workPlanBase;

            // 予定期間２ヵ月分をループする
            foreach ($cast->cast_schedules as $key2 => $castSchedule) {
                $sDate = $castSchedule->start->format('m-d'); // 比較用にフォーマット
                // 予定期間２ヵ月分をループする
                foreach ($dateList as $key3 => $date) {
                    $array = explode(' ', $date); // 比較用に配列化
                    // 日付が一致した場合
                    if(str_replace('/','-', $array[0]) == $sDate) {
                        // 仕事なら予定リストに〇をセット
                        if($castSchedule->title == '仕事') {
                            $workPlan[$key3] = '〇';
                        } else if($castSchedule->title == '休み') {
                            // 休みなら予定リストに✕をセット
                            $workPlan[$key3] = '✕';
                        }

                        break;
                    }
                }
            }

            // アイコン画像を設定する
            $files = $this->S3Client->getList($this->s3Backet, $castInfo['icon_path'], 1);
            // ファイルが存在したら、画像をセット
            if (is_countable($files) ? count($files) > 0 : 0) {
                $cast->set('icon', PATH_ROOT['URL_S3_BUCKET'].DS.$files[0]);
            } else {
                // 共通トップ画像をセット
                $cast->set('icon', PATH_ROOT['NO_IMAGE02']);
            }
            $cast->set('scheduleInfo', array_merge(['castInfo'=>$castInfo],['workPlan'=>$workPlan]));
            // 出勤の選択状況を設定
            $cast->selected = in_array(strval($cast['id']), $castIds, true) ? true : false;
        }

        $this->set(compact('casts', 'dateList', 'workSchedule'));
        $this->render();
    }

    /**
     * 出勤スケジュール 登録処理
     * @return void
     */
    public function saveWorkSchedule()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['SIGNUP_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Owner');

        // レコードが存在するか
        // レコードがない場合は、新規で登録を行う。
        if (!$this->WorkSchedules->exists(['shop_id' =>$this->viewVars['shopInfo']['id']])) {

            $newWorkSchedule = $this->WorkSchedules->newEntity($this->request->getData());
            $newWorkSchedule->shop_id = $this->viewVars['shopInfo']['id'];
        } else {
            // スケジュールテーブルからidのみを取得する
            $oldWorkSchedule = $this->WorkSchedules->find('all')
                ->where(['shop_id' => $this->viewVars['shopInfo']['id']])
                ->first();
            $newWorkSchedule = $this->WorkSchedules
                ->patchEntity($oldWorkSchedule, $this->request->getData());

            // 選択済みのメンバーで再登録した場合、レコードの変更無しなるため、変更フラグを立てる
            if (count($newWorkSchedule->getDirty()) == 0) {
                $newWorkSchedule->setDirty('cast_ids', true);
            }
        }

        try {

            // レコード更新実行
            if (!$this->WorkSchedules->save($newWorkSchedule)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }
            // 更新情報を追加する
            $updates = $this->Updates->newEntity();
            $updates->set('content','本日のメンバーを更新しました。');
            $updates->set('shop_id', $this->viewVars['shopInfo']['id']);
            $updates->set('type', SHOP_MENU_NAME['WORK_SCHEDULE']);
            // レコード更新実行
            if (!$this->Updates->save($updates)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }

        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
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

        $start_date = new Time(date('Y-m-d 00:00:00'));
        $start_date->day(1);
        $end_date = new Time(date('Y-m-d 00:00:00'));
        $last_month = $end_date->modify('last day of next month');
        $end_date = new Time($last_month->format('Y-m-d') .' 23:59:59');

        // 店舗に所属する全てのスタッフを取得する
        $casts = $this->Casts->find('all')
            ->where(['shop_id' => $this->viewVars['shopInfo']['id']
                    , 'casts.status' => 1 , 'casts.delete_flag' => 0])
            ->contain(['Shops'
                , 'CastSchedules' => function (Query $q) use ($start_date, $end_date)  {
                    return $q
                    ->where(['CastSchedules.start >='=> $start_date
                            , 'CastSchedules.start <='=> $end_date])
                    ->order(['CastSchedules.start'=>'ASC']);
            }])->order(['casts.created'=>'DESC']);

        $workSchedule = $this->WorkSchedules->find('all')
            ->where(['shop_id' => $this->viewVars['shopInfo']['id']])
            ->first();
        $castIds = explode(',', $workSchedule['cast_ids']);

        // スタッフ配列リスト
        $tempList = array();

        $dateList = $this->Util->getPeriodDate();
        $workPlanList = array();
        // 未入力値で初期化する
        for ($i=0; $i < count($dateList); $i++) {
            $workPlanList[] = 'ー';
        }

        // スタッフ情報を配列にセット
        foreach ($casts as $key1 => $cast) {

            $tempList = array('castInfo'=>$this->Util->getCastInfo($cast, $cast->shop));
            $cloneList = $workPlanList;

            // 予定期間２ヵ月分をループする
            foreach ($cast->cast_schedules as $key2 => $schedule) {
                $sDate = $schedule->start->format('m-d'); // 比較用にフォーマット
                // 予定期間２ヵ月分をループする
                foreach ($dateList as $key3 => $date) {
                    $array = explode(' ', $date); // 比較用に配列化
                    // 日付が一致した場合
                    if(str_replace('/','-', $array[0]) == $sDate) {
                        // 仕事なら予定リストに〇をセット
                        if($schedule->title == '仕事') {
                            $cloneList[$key3] = '〇';
                        } else if($schedule->title == '休み') {
                            // 休みなら予定リストに✕をセット
                            $cloneList[$key3] = '✕';
                        }

                        break;
                    }
                }
            }

            $tempList = array_merge($tempList, array('workPlan'=>$cloneList));
            $cast->set('scheduleInfo', $tempList);

            // アイコン画像を設定する
            $files = $this->S3Client->getList($this->s3Backet, $cast['scheduleInfo']['castInfo']['icon_path'], 1);
            // ファイルが存在したら、画像をセット
            if (is_countable($files) ? count($files) > 0 : 0) {
                $cast->set('icon', PATH_ROOT['URL_S3_BUCKET'].DS.$files[0]);
            } else {
                // 共通トップ画像をセット
                $cast->set('icon', PATH_ROOT['NO_IMAGE02']);
            }
            // 出勤の選択状況を設定
            $cast->selected = in_array(strval($cast['id']), $castIds, true) ? true : false;
        }

        $this->set(compact('casts', 'dateList', 'workSchedule'));

        $this->render('/Owner/Shops/work_schedule');
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
     * 設定 画面処理
     *
     * @return void
     */
    public function option()
    {
        $option = $this->ShopOptions->get($this->viewVars['shopInfo']['id']);
        // マスタコード取得
        $masCodeFind = array('option_menu_color');
        // セレクトボックスを作成する
        $mast_data = $this->Util->getSelectList($masCodeFind,$this->MasterCodes,false);

        // 登録ボタン押下時
        if ($this->request->is('ajax')) {

            $flg = true; // 返却フラグ
            $errors = ""; // 返却メッセージ
            $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
            $message = RESULT_M['SIGNUP_SUCCESS']; // 返却メッセージ
            $auth = $this->request->session()->read('Auth.Owner');

            // パラメタセット
            $option->set(['menu_color'=>$this->request->getData('menu_color')[0]]);

            try{
                if(!$option->errors()) {
                    if (!$this->ShopOptions->save($option)) {
                        throw new RuntimeException('レコードの更新ができませんでした。');
                    }
                } else {

                    foreach ($option->errors() as $key1 => $value1) {
                        foreach ($value1 as $key2 => $value2) {
                            $this->Flash->error($value2);
                        }
                    }
                }
            } catch (RuntimeException $e) {
                $this->log($this->Util->setLog($auth, $e));
                $flg = false;
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

            $this->set(compact('option','mast_data'));

            $this->render('/Owner/Shops/option');
            $response = array(
                'html' => $this->response->body(),
                'error' => $errors,
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;

        }

        $this->set(compact('option','mast_data'));
        $this->render();
    }

    /**
     * 全てのお知らせを取得する処理
     *
     * @return void
     */
    public function getAllNotice($shop_id, $notice_path, $user_id = null)
    {
        $notice = $this->Util->getNotices($this->viewVars['shopInfo']['id']
            , $notice_path
            , empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']);
        $top_notice = array();
        $arcive_notice = array();
        $count = 0;
        foreach ($notice as $key1 => $rows) :
            foreach ($rows as $key2 => $row) :
                if ($count == 5) :
                    break;
                endif;
                array_push($top_notice, $row);
                unset($notice[$key1][$key2]);
                $count = $count + 1;
            endforeach;
        endforeach;
        foreach ($notice as $key => $rows) :
            if (count($rows) == 0) :
                unset($notice[$key]);
            endif;
        endforeach;
        foreach ($notice as $key1 => $rows) :
            $tmp_array = array();
            foreach ($rows as $key2 => $row) :
                array_push($tmp_array, $row);
            endforeach;
            array_push($arcive_notice, array_values($tmp_array));
        endforeach;

        return array($top_notice, $arcive_notice);
    }

    /**
     * お知らせアーカイブ表示画面の処理
     *
     * @return void
     */
    public function viewCalendar()
    {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $this->confReturnJson(); // json返却用の設定
        $notice = $this->Util->getNotice($this->request->query["id"]);
        $this->response->body(json_encode($notice));
        return;
    }


}
