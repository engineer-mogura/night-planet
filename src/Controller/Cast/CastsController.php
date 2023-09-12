<?php

namespace App\Controller\Cast;

use Cake\Log\Log;
use Cake\I18n\Time;
use Cake\Event\Event;
use RuntimeException;
use Token\Util\Token;
use Cake\Mailer\Email;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Collection\Collection;
use Cake\Mailer\MailerAwareTrait;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;

/**
 * Controls the data flow into shops object and updates the view whenever data changes.
 */
class CastsController extends AppController {
    use MailerAwareTrait;
    public $components = array('Security');

    public function beforeFilter(Event $event) {
        // AppController.beforeFilterをコールバック
        $this->Security->setConfig('blackHoleCallback', 'blackhole');
        // 店舗スイッチアクションのセキュリティ無効化 AJAXを使用しているので
        $this->Security->setConfig('unlockedActions', [
            'saveProfile', 'saveTopImage', 'saveGallery', 'deleteGallery', 'saveDiary', 'deleteDiary', 'updateDiary', 'sns', 'editCalendar'
        ]);

        parent::beforeFilter($event);
        // スタッフに関する情報をセット
        if (!is_null($user = $this->Auth->user())) {
            if ($this->Casts->exists(['id' => $user['id']])) {
                $cast = $this->Casts->get($user['id']);
                // オーナーに関する情報をセット
                $shop = $this->Shops->find("all")
                    ->where(['shops.id' => $user['shop_id']])
                    ->contain(['Owners.ServecePlans'])
                    ->first();
                $castInfo = $this->Util->getCastInfo($cast, $shop);

                // アイコン画像を設定する
                $files = $this->S3Client->getList($this->s3Backet, $castInfo['icon_path'], 1);
                // ファイルが存在したら、画像をセット
                if (is_countable($files) ? count($files) > 0 : 0) {
                    $castInfo = $castInfo + array('icon' => PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
                } else {
                    // 共通トップ画像をセット
                    $castInfo = $castInfo + array('icon' => PATH_ROOT['NO_IMAGE02']);
                }
                $cast->icon = $castInfo['icon'];

                $this->set(compact('castInfo', 'cast'));
            } else {
                $session = $this->request->getSession();
                $session->destroy();
                $this->Flash->error('うまくアクセス出来ませんでした。もう一度やり直してみてください。');
            }
        }
    }

    /**
     * スタッフ画面トップの処理
     *
     * @return void
     */
    public function index() {
        $auth = $this->request->session()->read('Auth.Cast');
        $id = $auth['id']; // スタッフID

        $cast = $this->Casts->find('all')
            ->contain(['Shops', 'CastLikes' => function ($q) use ($id) {
                return $q
                    ->select([
                        'CastLikes.cast_id', 'total' => $q->func()->count('CastLikes.cast_id')
                    ])
                    ->group('CastLikes.cast_id')
                    ->where(['CastLikes.cast_id' => $id]);
            }, 'Diarys' => function ($q) use ($id) {
                return $q
                    ->select([
                        'Diarys.id', 'Diarys.cast_id', 'total' => $q->func()->count('Diarys.id')
                    ])
                    ->group('Diarys.id')
                    ->where(['Diarys.id' => $id]);
            }])
            ->where(['casts.id' => $id])
            ->first();

        // 非表示または論理削除している場合はログイン画面にリダイレクトする
        if (!$this->checkStatus($cast)) {
            return $this->redirect($this->Auth->logout());
        }
        if (!empty($this->viewVars['castInfo']['icon'])) {
            $cast->icon = $this->viewVars['castInfo']['icon'];
        }
        // JSONファイルをDB内容にて、更新する
        // JSONファイルに書き込むカラム情報
        $cast_schedule = $this->CastSchedules
            ->find('all')->select($this->CastSchedules)
            ->where(['shop_id' => $this->viewVars['castInfo']['shop_id'], 'cast_id' => $this->viewVars['castInfo']['id']]);

        $calendar_path = env('AWS_URL_HOST') . DS . env('AWS_BUCKET') . DS . $this->viewVars['castInfo']['schedule_path'] . DS . "calendar.json";
        $masterCodesFind = array('time', 'event');
        $selectList = $this->Util->getSelectList($masterCodesFind, $this->MasterCodes, true);

        $this->set(compact('cast', 'selectList', 'calendar_path'));
        $this->render();
    }

    /**
     * スタッフ画面トップの処理
     *
     * @return void
     */
    public function favo($page) {
        $auth = $this->request->session()->read('Auth.Cast');
        $id = $auth['id']; // スタッフID
        if ($page == 'favo') {
            $cast = $this->Casts->find('all')
                ->contain(['CastLikes' => function ($q) use ($id) {
                    return $q
                        ->select([
                            'CastLikes.cast_id', 'total' => $q->func()->count('CastLikes.cast_id')
                        ])
                        ->group('CastLikes.cast_id')
                        ->where(['CastLikes.cast_id' => $id]);
                }]);
        } else if ($page == 'likes') {
            $cast = $this->Casts->find('all')
                ->contain(['CastLikes' => function ($q) use ($id) {
                    return $q
                        ->select([
                            'CastLikes.cast_id', 'total' => $q->func()->count('CastLikes.cast_id')
                        ])
                        ->group('CastLikes.cast_id')
                        ->where(['CastLikes.cast_id' => $id]);
                }]);
        } else if ($page == 'diary') {
            $cast = $this->Casts->find('all')
                ->contain(['shops', 'CastLikes' => function ($q) use ($id) {
                    return $q
                        ->select([
                            'CastLikes.cast_id', 'total' => $q->func()->count('CastLikes.cast_id')
                        ])
                        ->group('CastLikes.cast_id')
                        ->where(['CastLikes.cast_id' => $id]);
                }]);
        }

        // 非表示または論理削除している場合はログイン画面にリダイレクトする
        if (!$this->checkStatus($cast)) {
            return $this->redirect($this->Auth->logout());
        }

        // JSONファイルをDB内容にて、更新する
        // JSONファイルに書き込むカラム情報
        $cast_schedule = $this->CastSchedules
            ->find('all')->select($this->CastSchedules)
            ->where(['id' => $this->viewVars['castInfo']['id'], 'shop_id' => $this->viewVars['castInfo']['shop_id']]);
        $cast_schedule = json_encode($cast_schedule);

        $masterCodesFind = array('time', 'event');
        $selectList = $this->Util->getSelectList($masterCodesFind, $this->MasterCodes, true);

        $this->set(compact('cast', 'selectList', 'cast_schedule'));
        $this->render();
    }

    /**
     * カレンダーの処理
     *
     * @param [type] $id
     * @return void
     */
    public function editCalendar() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = ""; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Cast');

        try {

            // イベント削除の場合
            if ($this->request->data["crud_type"] == "delete") {
                $message = RESULT_M['DELETE_SUCCESS'];
                $cast_schedules = $this->CastSchedules->get($this->request->data["id"]);
                if (!$this->CastSchedules->delete($cast_schedules)) {
                    throw new RuntimeException('レコードの削除ができませんでした。');
                    $message = RESULT_M['DELETE_FAILED'];
                }
            } elseif ($this->request->data["crud_type"] == "update") {
                // イベント編集の場合
                $message = RESULT_M['UPDATE_SUCCESS'];
                $cast_schedules = $this->CastSchedules->patchEntity(
                    $this->CastSchedules->get($this->request->getData('id')),
                    $this->request->getData()
                );
                if (!$this->CastSchedules->save($cast_schedules)) {
                    throw new RuntimeException('レコードの更新ができませんでした。');
                    $message = RESULT_M['UPDATE_FAILED'];
                }
            } elseif ($this->request->data["crud_type"] == "create") {
                // イベント追加の場合
                $message = RESULT_M['SIGNUP_SUCCESS'];
                $cast_schedules = $this->CastSchedules->newEntity($this->request->getData());
                if (!$this->CastSchedules->save($cast_schedules)) {
                    throw new RuntimeException('レコードの登録ができませんでした。');
                    $message = RESULT_M['SIGNUP_FAILED'];
                }
            }

            // JSONファイルを取得※なければ作成
            $file = $this->viewVars['castInfo']['schedule_path'] . DS . "calendar.json";
            // JSONファイルに書き込むカラム情報
            $Columns = array(
                'id', 'title', 'start', 'end', 'time_start', 'time_end', 'all_day'
            );

            $cast_schedule = $this->CastSchedules->find('all', array('fields' => $Columns))
                ->where([
                    'shop_id' => $this->viewVars['castInfo']['shop_id'], 'cast_id' => $this->viewVars['castInfo']['id']
                ]);

            // 読み込み
            $stream = fopen('s3://' . env('AWS_BUCKET') . DS . $file, 'w');
            // 「HogeHoge」を追記
            fwrite($stream, json_encode($cast_schedule));
            fclose($stream);
            // 書き込み
            file_put_contents('s3://' . env('AWS_BUCKET') . DS . $file, $stream);
        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
            $message = RESULT_M['UPDATE_FAILED'];
        }

        $response = array(
            'success' => $flg,
            'message' => $message
        );
        $this->response->body(json_encode($response));
        return;
    }

    /**
     * プロフィール画面の処理
     *
     * @return void
     */
    public function profile() {
        $auth = $this->request->session()->read('Auth.Cast');

        // 非表示または論理削除している場合はログイン画面にリダイレクトする
        if (!$this->checkStatus($this->Casts->get($this->viewVars['castInfo']['id']))) {
            return $this->redirect($this->Auth->logout());
        }

        $cast = $this->Casts->get($auth['id']);

        // // アイコン画像を設定する
        if (!empty($this->viewVars['castInfo']['icon'])) {
            $cast->icon = $this->viewVars['castInfo']['icon'];
        }

        // 作成するセレクトボックスを指定する
        $masCodeFind = array('time', 'constellation', 'blood_type', 'age');
        // セレクトボックスを作成する
        $selectList = $this->Util->getSelectList($masCodeFind, $this->MasterCodes, true);

        $this->set(compact('cast', 'selectList'));
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

        $auth = $this->request->session()->read('Auth.Cast');

        // 非表示または論理削除している場合はログイン画面にリダイレクトする
        if (!$this->checkStatus($this->Casts->get($this->viewVars['castInfo']['id']))) {
            return $this->redirect($this->Auth->logout());
        }

        $flg = true; // 返却フラグ
        $chkDuplicate = false; // ディレクトリ削除フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ

        // アイコン画像変更の場合
        if (isset($this->request->data["action_type"])) {

            $cast = $this->Casts->get($this->viewVars['castInfo']['id']);

            // アイコン画像を設定する
            $files = $this->S3Client->getList($this->s3Backet, $this->viewVars['castInfo']['icon_path'], 1);
            $fileBefor = null;
            // ファイルが存在したら、画像をセット
            if (is_countable($files) ? count($files) > 0 : 0) {
                $fileBefor = $files[0];
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
                        $this->viewVars['castInfo']['icon_path'],
                        $limitFileSize
                    );

                    // 画像ファイルアップロード
                    $upResult = $this->S3Rapper->upload(
                        $this->viewVars['castInfo']['icon_path'] . DS . $convertFile,
                        $file["tmp_name"]
                    );
                    // 同じファイル名でない場合は前の画像を削除
                    if (($this->viewVars['castInfo']['icon_path'] . DS . $convertFile !== $fileBefor) && !empty($fileBefor)) {
                        $delResult = $this->S3Rapper->delete($fileBefor);
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
            // 最新の画像をセット
            $cast->icon = PATH_ROOT['URL_S3_BUCKET'] . DS . $this->viewVars['castInfo']['icon_path'] . DS . $convertFile;
        } else {
            // バリデーションはプロフィール変更用を使う。
            $cast = $this->Casts->patchEntity($this->Casts
                ->get($auth['id']), $this->request->getData(), ['validate' => 'profile']);
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
                // レコード更新実行
                if (!$this->Casts->save($cast)) {
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
            if (!empty($this->viewVars['castInfo']['icon'])) {
                $cast->icon = $this->viewVars['castInfo']['icon'];
            }
        }

        // 作成するセレクトボックスを指定する
        $masCodeFind = array('time', 'constellation', 'blood_type', 'age');
        // セレクトボックスを作成する
        $selectList = $this->Util->getSelectList($masCodeFind, $this->MasterCodes, true);

        $this->set(compact('cast', 'selectList'));
        $this->render('/Cast/Casts/profile');
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
     * トップ画像 画面表示処理
     *
     * @return void
     */
    public function topImage() {
        $cast = $this->viewVars['cast'];
        // アイコン画像を設定する
        $files = $this->S3Client->getList(
            $this->s3Backet,
            $this->viewVars['castInfo']['top_image_path'],
            1
        );
        // ファイルが存在したら、画像をセット
        if (is_countable($files) ? count($files) > 0 : 0) {
            $cast->set('top_image', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
        } else {
            // 共通トップ画像をセット
            $cast->set('top_image', PATH_ROOT['CAST_TOP_IMAGE']);
        }
        $this->set(compact('cast'));
        $this->render();
    }

    /**
     * トップ画像 編集押下処理
     *
     * @return void
     */
    public function saveTopImage() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $chkDuplicate = false; // ディレクトリ削除フラグ
        // $isRemoved = false; // ディレクトリ削除フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['SIGNUP_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Cast');

        // トップ画像を設定する
        $fileBefor = $this->S3Client->getList(
            $this->s3Backet,
            $this->viewVars['castInfo']['top_image_path'],
            1
        );

        // 新しいファイルを取得
        $file = $this->request->getData('top_image_file');

        // ファイルが存在する、かつファイル名がblobの画像のとき
        if (!empty($file["name"]) && $file["name"] == 'blob') {
            $limitFileSize = CAPACITY['MAX_NUM_BYTES_FILE'];

            try {
                $convertFile = $this->Util->file_upload(
                    $file,
                    null,
                    $chkDuplicate,
                    $this->viewVars['castInfo']['top_image_path'],
                    $limitFileSize
                );
                // 画像ファイルアップロード
                $upResult = $this->S3Rapper->upload(
                    $this->viewVars['castInfo']['top_image_path'] . DS . $convertFile,
                    $file["tmp_name"]
                );
                // 同じファイル名でない場合は前の画像を削除
                if (($this->viewVars['castInfo']['top_image_path'] . DS . $convertFile !== $fileBefor[0]) && !empty($fileBefor)) {
                    $delResult = $this->S3Rapper->delete($fileBefor[0]);
                }

                // 更新情報を追加する
                $updates = $this->Updates->newEntity();
                $updates->set('content', $this->Auth->user('nickname') . 'さんがトップ画像を変更しました。');
                $updates->set('shop_id', $this->Auth->user('shop_id'));
                $updates->set('cast_id', $this->Auth->user('id'));
                $updates->set('type', SHOP_MENU_NAME['CAST_TOP_IMAGE']);
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

        $cast = $this->viewVars['cast'];
        // トップ画像を設定する
        $files = $this->S3Client->getList(
            $this->s3Backet,
            $this->viewVars['castInfo']['top_image_path'],
            1
        );
        // ファイルが存在したら、画像をセット
        if (is_countable($files) ? count($files) > 0 : 0) {
            $cast->set('top_image', PATH_ROOT['URL_S3_BUCKET'] . DS . $files[0]);
        } else {
            // 共通トップ画像をセット
            $cast->set('top_image', PATH_ROOT['CAST_TOP_IMAGE']);
        }

        $this->set(compact('cast'));
        $this->render('/Cast/Casts/top_image');
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
     * トップ画像 削除押下処理
     *
     * @return void
     */
    public function deleteTopImage() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['DELETE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Cast');

        try {

            // ディクレトリ取得
            $dir = new Folder(
                preg_replace(
                    '/(\/\/)/',
                    '/',
                    WWW_ROOT . $this->viewVars['castInfo']['top_image_path']
                ),
                true,
                0755
            );

            $files = glob($dir->path . DS . '*.*');
            // 削除対象ファイルを取得
            $file = new File(preg_replace(
                '/(\/\/)/',
                '/',
                $files[0]
            ));

            // 日記ファイル削除処理実行
            if (!$file->delete()) {
                throw new RuntimeException('ファイルの削除ができませんでした。');
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
        // 空の配列
        $gallery = array();

        $this->set(compact('gallery'));
        $this->render('/Cast/Casts/top_image');
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
     * ギャラリー 画面表示処理
     *
     * @return void
     */
    public function gallery() {
        // ギャラリーリストを作成
        $gallery = array();

        $files = $this->S3Client->getList($this->s3Backet, $this->viewVars['castInfo']['image_path']);
        usort($files, $this->Util->sortByLastmod);
        foreach ($files as $file) {
            $timestamp = date('Y/m/d H:i', filemtime($file));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $file, "date" => $timestamp, "simple_path" => $file

            ));
        }
        $this->set(compact('gallery'));
        $this->render();
    }

    /**
     * sns 画面の処理
     *
     * @return void
     */
    public function sns() {
        $auth = $this->request->session()->read('Auth.Cast');
        $id = $auth['id']; // スタッフID

        // 非表示または論理削除している場合はログイン画面にリダイレクトする
        if (!$this->checkStatus($this->Casts->get($this->viewVars['castInfo']['id']))) {
            return $this->redirect($this->Auth->logout());
        }

        // AJAXのアクセス以外は不正とみなす。
        if ($this->request->is('ajax')) {
            $flg = true; // 返却フラグ
            $errors = ""; // 返却メッセージ
            $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
            $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
            $plan = $this->viewVars['castInfo']['current_plan'];

            try {
                // プレミアムSプラン以外 かつ Instagramが入力されていた場合 不正なパターンでエラー
                if ($plan != SERVECE_PLAN['premium_s']['label'] && !empty($this->request->getData('instagram'))) {
                    throw new RuntimeException(RESULT_M['INSTA_ADD_CAST_FAILED'] . ' 不正アクセスがあります。');
                }
            } catch (RuntimeException $e) {

                // エラーメッセージをセット
                $search = array('_service_plan_');
                $replace = array(SERVECE_PLAN['premium_s']['name']);
                $message = $this->Util->strReplace($search, $replace, RESULT_M['INSTA_ADD_CAST_FAILED']);

                $this->log($this->Util->setLog($auth, $e));
                $response = array('success' => false, 'message' => $message);
                $this->response->body(json_encode($response));
                return;
            }

            // レコードが存在するか
            // レコードがない場合は、新規で登録を行う。
            if (!$this->Snss->exists(['cast_id' => $this->viewVars['castInfo']['id']])) {
                $sns = $this->Snss->newEntity($this->request->getData());
                $sns->cast_id = $this->viewVars['castInfo']['id'];
            } else {
                // snsテーブルからidのみを取得する
                $sns_id = $this->Snss->find()
                    ->select('id')
                    ->where(['cast_id' => $id])->first()->id;

                $sns = $this->Snss->patchEntity($this->Snss
                    ->get($sns_id), $this->request->getData());
            }

            // バリデーションチェック
            if ($sns->errors()) {
                // 入力エラーがあれば、メッセージをセットして返す
                $errors = $this->Util->setErrMessage($sns); // エラーメッセージをセット
                $response = array('success' => false, 'message' => $errors);
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

            $cast = $this->Casts->find()
                ->where(['id' => $this->viewVars['castInfo']['id']])
                ->contain(['Snss'])->first();
            if (!empty($this->viewVars['castInfo']['icon'])) {
                $cast->icon = $this->viewVars['castInfo']['icon'];
            }
            $this->set(compact('cast'));
            $this->render('/Cast/Casts/sns');
            $response = array(
                'html' => $this->response->body(),
                'error' => $errors,
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;
        }
        $cast = $this->Casts->find()
            ->where(['id' => $id])
            ->contain(['Snss'])->first();
        if (!empty($this->viewVars['castInfo']['icon'])) {
            $cast->icon = $this->viewVars['castInfo']['icon'];
        }
        $this->set(compact('cast'));
        $this->render();
    }

    /**
     * ギャラリー 編集押下処理
     *
     * @return void
     */
    public function saveGallery() {
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
        $auth = $this->request->session()->read('Auth.Cast');
        $files = array();

        // 既に登録された画像があればデコードし格納、無ければ空の配列を格納する
        ($files_befor = json_decode(
            $this->request->getData("gallery_befor"),
            true
        )) > 0 ?: $files_befor = array();

        $fileMax = PROPERTY['FILE_MAX']; // ファイル格納最大数

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
                    $convertFile = $this->Util->file_upload(
                        $file,
                        $files_befor,
                        $chkDuplicate,
                        $this->viewVars['castInfo']['image_path'],
                        $limitFileSize
                    );

                    // ファイル名が同じ場合は重複フラグをセットする
                    if ($convertFile === false) {
                        $isDuplicate = true;
                        continue;
                    }

                    $result = $this->S3Rapper->upload(
                        $this->viewVars['castInfo']['image_path'] . DS . $convertFile,
                        $file["tmp_name"]
                    );
                }
            }

            // 更新情報を追加する
            $updates = $this->Updates->newEntity();
            $updates->set('content', $this->Auth->user('nickname') . 'さんがギャラリーを追加しました。');
            $updates->set('shop_id', $this->Auth->user('shop_id'));
            $updates->set('cast_id', $this->Auth->user('id'));
            $updates->set('type', SHOP_MENU_NAME['CAST_GALLERY']);
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

        $files = $this->S3Client->getList($this->s3Backet, $this->viewVars['castInfo']['image_path']);
        usort($files, $this->Util->sortByLastmod);
        foreach ($files as $file) {
            $timestamp = date('Y/m/d H:i', filemtime($file));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $file, "date" => $timestamp, "simple_path" => $file

            ));
        }

        $this->set(compact('gallery'));
        $this->render('/Cast/Casts/gallery');
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
    public function deleteGallery() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['DELETE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Cast');

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

        $files = $this->S3Client->getList($this->s3Backet, $this->viewVars['castInfo']['image_path']);
        usort($files, $this->Util->sortByLastmod);
        foreach ($files as $file) {
            $timestamp = date('Y/m/d H:i', filemtime($file));
            array_push($gallery, array(
                "file_path" => PATH_ROOT['URL_S3_BUCKET'] . DS . $file, "date" => $timestamp, "simple_path" => $file

            ));
        }

        $this->set(compact('gallery'));
        $this->render('/Cast/Casts/gallery');
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
     * 日記 画面表示処理
     *
     * @return void
     */
    public function diary() {
        $allDiary = $this->getAllDiary(
            $this->viewVars['castInfo']['id'],
            $this->viewVars['castInfo']['diary_path'],
            null
        );
        $top_diary = $allDiary[0];
        $arcive_diary = $allDiary[1];
        $this->set(compact('top_diary', 'arcive_diary'));
        return $this->render();
    }

    /**
     * 日記 登録処理
     * @return void
     */
    public function saveDiary() {
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
        $auth = $this->request->session()->read('Auth.Cast');
        $files = array();

        $files_befor = array(); // 新規なので空の配列

        // エンティティにマッピングする
        $diary = $this->Diarys->newEntity($this->request->getData());
        // バリデーションチェック
        if ($diary->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($diary); // エラーメッセージをセット
            $response = array('success' => false, 'message' => $errors);
            $this->response->body(json_encode($response));
            return;
        }

        // 日記用のディレクトリを掘る
        $date = new Time();
        $diaryPath =  DS . $date->format('Y')
            . DS . $date->format('m') . DS . $date->format('d')
            . DS . $date->format('Ymd_His');
        $diary->dir = $diaryPath; // 日記のパスをセット
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
                    $convertFile = $this->Util->file_upload(
                        $file,
                        $files_befor,
                        $chkDuplicate,
                        $this->viewVars['castInfo']['diary_path'] . $diary->dir,
                        $limitFileSize
                    );

                    // ファイル名が同じ場合は重複フラグをセットする
                    if ($convertFile === false) {
                        $isDuplicate = true;
                        continue;
                    }

                    $result = $this->S3Rapper->upload(
                        $this->viewVars['castInfo']['diary_path'] . $diary->dir . DS . $convertFile,
                        $file["tmp_name"]
                    );
                }
            }
            // レコード更新実行
            if (!$this->Diarys->save($diary)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }
            // 更新情報を追加する
            $updates = $this->Updates->newEntity();
            $updates->set('content', $this->Auth->user('nickname') . 'さんが日記を追加しました。');
            $updates->set('shop_id', $this->Auth->user('shop_id'));
            $updates->set('cast_id', $this->Auth->user('id'));
            $updates->set('type', SHOP_MENU_NAME['DIARY']);
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
        // 日記取得
        $allDiary = $this->getAllDiary(
            $this->viewVars['castInfo']['id'],
            $this->viewVars['castInfo']['diary_path'],
            null
        );
        $top_diary = $allDiary[0];
        $arcive_diary = $allDiary[1];

        $this->set(compact('top_diary', 'arcive_diary'));
        $this->render('/Cast/Casts/diary');
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
     * 日記アーカイブ表示画面の処理
     *
     * @return void
     */
    public function viewDiary() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $this->confReturnJson(); // json返却用の設定

        $diary = $this->Util->getDiary(
            $this->request->query["id"],
            $this->viewVars['castInfo']['diary_path'],
            null
        );

        $this->response->body(json_encode($diary));
        return;
    }

    /**
     * 日記アーカイブ更新処理
     *
     * @return void
     */
    public function updateDiary() {

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
        $auth = $this->request->session()->read('Auth.Cast');
        $files = array();

        // エンティティにマッピングする
        // エンティティにマッピングする
        $diary = $this->Diarys->patchEntity($this->Diarys
            ->get($this->request->data['diary_id']), $this->request->getData());
        // バリデーションチェック
        if ($diary->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($diary); // エラーメッセージをセット
            $response = array('result' => false, 'errors' => $errors);
            $this->response->body(json_encode($response));
            return;
        }

        $delFiles = json_decode($this->request->data["del_list"], true);
        // 既に登録された画像があればデコードし格納、無ければ空の配列を格納する
        ($files_befor = json_decode($this->request->data["json_data"], true)) > 0
            ?: $files_befor = array();
        try {

            // 削除する画像分処理する
            foreach ($delFiles as $key => $file) {
                $file['path'] = str_replace(env('AWS_URL_HOST') . DS . env('AWS_BUCKET'), '', $file['path']);
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
                    $convertFile = $this->Util->file_upload(
                        $file,
                        $files_befor,
                        $chkDuplicate,
                        $this->request->data["dir_path"],
                        $limitFileSize
                    );

                    // ファイル名が同じ場合は処理をスキップする
                    if ($convertFile === false) {
                        $isDuplicate = true;
                        continue;
                    }
                    $result = $this->S3Rapper->upload(
                        $this->request->data["dir_path"] . DS . $convertFile,
                        $file["tmp_name"]
                    );
                }
            }

            // レコード更新実行
            if (!$this->ShopInfos->save($diary)) {
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

        // 日記取得
        $allDiary = $this->getAllDiary(
            $this->viewVars['castInfo']['id'],
            $this->viewVars['castInfo']['diary_path'],
            null
        );
        $top_diary = $allDiary[0];
        $arcive_diary = $allDiary[1];

        $this->set(compact('top_diary', 'arcive_diary'));
        $this->render('/Cast/Casts/diary');
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
     * 日記アーカイブ削除処理
     *
     * @return void
     */
    public function deleteDiary() {
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
            $diary = $this->Diarys->get($this->request->getData('id'));
            // レコード削除実行
            if (!$this->Diarys->delete($diary)) {
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

        // 日記取得
        $allDiary = $this->getAllDiary(
            $this->viewVars['castInfo']['id'],
            $this->viewVars['castInfo']['diary_path'],
            null
        );
        $top_diary = $allDiary[0];
        $arcive_diary = $allDiary[1];

        $this->set(compact('top_diary', 'arcive_diary'));
        $this->render('/Cast/Casts/diary');
        $response = array(
            'html' => $this->response->body(),
            'error' => $errors,
            'success' => $flg,
            'message' => $message
        );
        $this->response->body(json_encode($response));
        return;

        $flg = true; // 返却フラグ
        $isRemoved = false; // ディレクトリ削除フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['DELETE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Cast');
        $id = $auth['id']; // スタッフID
        $tmpDir = null; // バックアップ用

        try {
            $del_path = preg_replace(
                '/(\/\/)/',
                '/',
                WWW_ROOT . $this->request->getData('dir_path')
            );
            // 削除対象ディレクトリパス取得
            $dir = new Folder($del_path);
            // 削除対象ディレクトリパス存在チェック
            if (!file_exists($dir->path)) {
                throw new RuntimeException('ディレクトリが存在しません。');
            }

            // ロールバック用のディレクトリサイズチェック
            if ($dir->dirsize() > CAPACITY['MAX_NUM_BYTES_DIR']) {
                throw new RuntimeException('ディレクトリサイズが大きすぎます。');
            }

            // 一時ディレクトリ作成
            $tmpDir = new Folder(
                WWW_ROOT . $this->viewVars['castInfo']['tmp_path'] . DS . time(),
                true,
                0777
            );
            // 一時ディレクトリにバックアップ実行
            if (!$dir->copy($tmpDir->path)) {
                throw new RuntimeException('バックアップに失敗しました。');
            }

            // 日記ディレクトリ削除処理実行
            if (!$dir->delete()) {
                throw new RuntimeException('ディレクトリの削除ができませんでした。');
            }
            // ディレクトリ削除フラグを立てる
            $isRemoved = true;
            // 削除対象レコード取得
            $diary = $this->Diarys->get($this->request->getData('id'));
            // レコード削除実行
            if (!$this->Diarys->delete($diary)) {
                throw new RuntimeException('レコードの削除ができませんでした。');
            }
        } catch (RuntimeException $e) {
            // ディレクトリを削除していた場合は復元する
            if ($isRemoved) {
                $tmpDir->copy($dir->path);
            }
            // 一時ディレクトリがあれば削除する
            if (isset($tmpDir) && file_exists($tmpDir->path)) {
                $tmpDir->delete(); // tmpディレクトリ削除
            }
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

        // 一時ディレクトリ削除
        if (file_exists($tmpDir->path)) {
            $tmpDir->delete();
        }
        // 日記取得
        $allDiary = $this->getAllDiary(
            $this->viewVars['castInfo']['id'],
            $this->viewVars['castInfo']['diary_path'],
            null
        );
        $top_diary = $allDiary[0];
        $arcive_diary = $allDiary[1];

        $this->set(compact('top_diary', 'arcive_diary'));
        $this->render('/Cast/Casts/diary');
        $response = array(
            'html' => $this->response->body(),
            'error' => $errors,
            'success' => $flg,
            'message' => $message
        );
        $this->response->body(json_encode($response));
        return;
    }

    public function login() {
        // レイアウトを使用しない
        $this->viewBuilder()->autoLayout(false);

        if ($this->request->is('post')) {

            // バリデーションはログイン用を使う。
            $cast = $this->Casts->newEntity($this->request->getData(), ['validate' => 'castLogin']);

            if (!$cast->errors()) {
                $this->log($this->request->getData("remember_me"), "debug");
                $cast = $this->Auth->identify();
                if ($cast) {
                    $this->Auth->setUser($cast);
                    Log::info($this->Util->setAccessLog(
                        $cast,
                        $this->request->params['action']
                    ), 'access');

                    return $this->redirect($this->Auth->redirectUrl());
                }

                $this->Flash->error(RESULT_M['FRAUD_INPUT_FAILED']);
            } else {
                foreach ($cast->errors() as $key1 => $value1) {
                    foreach ($value1 as $key2 => $value2) {
                        $this->Flash->error($value2);
                    }
                }
            }
        } else {
            $cast = $this->Casts->newEntity();
        }
        $this->set('cast', $cast);
    }

    public function logout() {
        $auth = $this->request->session()->read('Auth.Cast');

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
     * スタッフ登録時の認証
     *
     * @param [type] $token
     * @return void
     */
    public function verify($token) {
        // シンプルレイアウトを使用
        $this->viewBuilder()->layout('simpleDefault');
        try {
            $tmp = $this->Tmps->get(Token::getId($token));
        } catch (RuntimeException $e) {
            $this->Flash->error('URLが無効になっています。');
            return $this->render('/common/error');
        }

        // 以下でトークンの有効期限や改ざんを検証することが出来る
        if (!$tmp->tokenVerify($token)) {
            $this->log($this->Util->setLog($tmp, RESULT_M['PASS_RESET_FAILED']));
            // 仮登録してるレコードを削除する
            $this->Tmps->delete($tmp);

            $this->Flash->error(RESULT_M['AUTH_FAILED']);
            return $this->render('/common/error');
        }

        // スタッフレイアウトを使用
        $this->viewBuilder()->layout('castDefault');

        // 仮登録時点で削除フラグは立っている想定。
        if ($tmp->delete_flag != 1) {
            // すでに登録しているとみなし、ログイン画面へ
            $this->Flash->success(RESULT_M['REGISTERED_FAILED']);
            return $this->redirect(['action' => 'login']);
        }
        // 店舗情報を取得
        $shopInfo = $this->Util->getShopInfo($this->Shops->get($tmp->shop_id));

        // ディレクトリ存在フラグ
        $exists = true;
        $newDir = "";
        while ($exists) {
            $newDir = $this->Util->makeRandStr(15);
            $checkExistsPath = $shopInfo['cast_path'] . DS . $newDir;
            $listObjects = $this->S3Client->getListObjects(null, $checkExistsPath, 1);
            if (is_null($listObjects['Contents'])) {
                $exists = false;
            }
        }

        // コネクションオブジェクト取得
        $connection = ConnectionManager::get('default');
        // トランザクション処理開始
        $connection->begin();

        try {
            // スタッフ情報セット
            $tmp->delete_flag = 0; // 論理削除フラグを下げる
            $data = [
                'shop_id' => $tmp->shop_id, 'role' => $tmp->role, 'nickname' => $tmp->nickname, 'name' => $tmp->name, 'email' => $tmp->email, 'password' => $tmp->password, 'age' => $tmp->age, 'dir' => $newDir, 'status' => $tmp->status, 'delete_flag' => $tmp->delete_flag
            ];

            // 新規エンティティ
            $cast = $this->Casts->patchEntity($this->Casts->newEntity(), $data);

            // バリデーションチェック
            if ($cast->errors()) {
                $errors = $this->Util->setErrMessage($cast); // エラーメッセージをセット
                throw new RuntimeException($errors);
            }

            // スタッフ登録
            if (!$this->Casts->save($cast)) {
                throw new RuntimeException('レコードの更新に失敗しました。');
            }
            // 更新情報を追加する
            $updates = $this->Updates->newEntity();
            $updates->set('content', '新しいスタッフを追加しました。');
            $updates->set('shop_id', $this->Auth->user('shop_id'));
            $updates->set('cast_id', $this->Auth->user('id'));
            $updates->set('type', SHOP_MENU_NAME['DIARY']);
            // レコード更新実行
            if (!$this->Updates->save($updates)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }

            // コミット
            $connection->commit();

            // 認証完了したら、メール送信
            $email = new Email('default');
            $email->setFrom([MAIL['SUPPORT_MAIL'] => MAIL['FROM_NAME']])
                ->setSubject($cast->name . "様、メールアドレスの認証が完了しました。")
                ->setTo($cast->email)
                ->setBcc(MAIL['SUPPORT_MAIL'])
                ->setTemplate("auth_success")
                ->setLayout("auth_success_layout")
                ->emailFormat("html")
                ->viewVars(['cast' => $cast])
                ->send();
            $this->set('cast', $cast);
            $this->log($email, 'debug');
            // 一時テーブル削除
            $this->Tmps->delete($tmp);
        } catch (RuntimeException $e) {
            // ロールバック
            $connection->rollback();
            $this->log($this->Util->setLog($cast, $e->__toString()));
            // 仮登録してるレコードを削除する
            $this->Tmps->delete($tmp);
            $this->Flash->error(RESULT_M['AUTH_FAILED'] . $e->getMessage());
            return $this->redirect(['action' => 'login']);
        }
        // 認証完了でログインページへ
        $this->Flash->success(RESULT_M['AUTH_SUCCESS']);
        return $this->redirect(['action' => 'login']);
    }

    public function passReset() {
        // シンプルレイアウトを使用
        $this->viewBuilder()->layout('simpleDefault');

        if ($this->request->is('post')) {

            // バリデーションはパスワードリセットその１を使う。
            $cast = $this->Casts->newEntity(
                $this->request->getData(),
                ['validate' => 'CastPassReset1']
            );

            if (!$cast->errors()) {
                // メールアドレスで取得
                $cast = $this->Casts->find()
                    ->where(['email' => $cast->email])->first();

                // 非表示または論理削除している場合はログイン画面にリダイレクトする
                if (!$this->checkStatus($cast)) {
                    return $this->redirect($this->Auth->logout());
                }

                $email = new Email('default');
                $email->setFrom([MAIL['SUPPORT_MAIL'] => MAIL['FROM_NAME']])
                    ->setSubject(MAIL['FROM_NAME_PASS_RESET'])
                    ->setTo($cast->email)
                    ->setBcc(MAIL['SUPPORT_MAIL'])
                    ->setTemplate("pass_reset_email")
                    ->setLayout("simple_layout")
                    ->emailFormat("html")
                    ->viewVars(['cast' => $cast])
                    ->send();
                $this->set('cast', $cast);

                $this->Flash->success('パスワード再設定用メールを送信しました。しばらくしても届かない場合は迷惑メールフォルダをご確認ください。');
                Log::info("ID：【" . $cast['id'] . "】アドレス：【" . $cast->email
                    . "】パスワード再設定用メールを送信しました。", 'pass_reset');

                return $this->render('/common/pass_reset_send');
            } else {
                // 送信失敗
                foreach ($cast->errors() as $key1 => $value1) {
                    foreach ($value1 as $key2 => $value2) {
                        $this->Flash->error($value2);
                        Log::error("ID：【" . $cast['id'] . "】アドレス：【" . $cast->email
                            . "】エラー：【" . $value2 . "】", 'pass_reset');
                    }
                }
            }
        } else {
            $cast = $this->Casts->newEntity();
        }
        $this->set('cast', $cast);
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
        $cast = $this->Auth->identify();
        try {
            $cast = $this->Casts->get(Token::getId($token));
        } catch (RuntimeException $e) {
            $this->Flash->error('URLが無効になっています。');
            return $this->render('/common/pass_reset_form');
        }

        // 以下でトークンの有効期限や改ざんを検証することが出来る
        if (!$cast->tokenVerify($token)) {
            Log::info("ID：【" . $cast->id . "】" . "アドレス：【" . $cast->email . "】" .
                "エラー：【" . RESULT_M['PASS_RESET_FAILED'] . "】アクション：【"
                . $this->request->params['action'] . "】", "pass_reset");

            $this->Flash->error(RESULT_M['PASS_RESET_FAILED']);
            return $this->render('/common/pass_reset_form');
        }

        if ($this->request->is('post')) {
            // パスワードリセットフォームの表示フラグ
            $is_reset_form = false;

            // バリデーションはパスワードリセットその２を使う。
            $validate = $this->Casts->newEntity(
                $this->request->getData(),
                ['validate' => 'CastPassReset2']
            );

            if (!$validate->errors()) {

                // 再設定したパスワードを設定する
                $hasher = new DefaultPasswordHasher();
                $cast->password =  $hasher->hash($this->request->getData('password'));
                // 自動ログインフラグを下げる
                $cast->remember_token = 0;

                // 一応ちゃんと変更されたかチェックする
                if (!$cast->isDirty('password')) {

                    Log::info("ID：【" . $cast->id . "】" . "アドレス：【" . $cast->email . "】" .
                        "エラー：【パスワードの変更に失敗しました。】アクション：【"
                        . $this->request->params['action'] . "】", "pass_reset");

                    $this->Flash->error('パスワードの変更に失敗しました。');
                    return $this->redirect(['action' => 'login']);
                }

                if ($this->Casts->save($cast)) {

                    // 変更完了したら、メール送信
                    $email = new Email('default');
                    $email->setFrom([MAIL['SUPPORT_MAIL'] => MAIL['FROM_NAME']])
                        ->setSubject($cast->name . "様、メールアドレスの変更が完了しました。")
                        ->setTo($cast->email)
                        ->setBcc(MAIL['SUPPORT_MAIL'])
                        ->setTemplate("pass_reset_success")
                        ->setLayout("simple_layout")
                        ->emailFormat("html")
                        ->viewVars(['cast' => $cast])
                        ->send();
                    $this->set('cast', $cast);

                    // 変更完了でログインページへ
                    $this->Flash->success(RESULT_M['PASS_RESET_SUCCESS']);
                    Log::info("ID：【" . $cast['id'] . "】アドレス：【" . $cast->email
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
            $this->set(compact('is_reset_form', 'cast'));
            return $this->render('/common/pass_reset_form');
        }
    }

    public function passChange() {
        $auth = $this->request->session()->read('Auth.Cast');

        if ($this->request->is('post')) {

            $isValidate = false; // エラー有無
            // バリデーションはパスワードリセットその３を使う。
            $validate = $this->Casts->newEntity(
                $this->request->getData(),
                ['validate' => 'CastPassReset3']
            );

            if (!$validate->errors()) {

                $hasher = new DefaultPasswordHasher();
                $cast = $this->Casts->get($this->viewVars['castInfo']['id']);

                // 非表示または論理削除している場合はログイン画面にリダイレクトする
                if (!$this->checkStatus($cast)) {
                    return $this->redirect($this->Auth->logout());
                }

                $equal_check = $hasher->check(
                    $this->request->getData('password'),
                    $cast->password
                );
                // 入力した現在のパスワードとデータベースのパスワードを比較する
                if (!$equal_check) {
                    $this->Flash->error('現在のパスワードが間違っています。');
                    return $this->render();
                }
                // 新しいパスワードを設定する
                $cast->password =  $hasher->hash($this->request->getData('password_new'));

                // 一応ちゃんと変更されたかチェックする
                if (!$cast->isDirty('password')) {

                    Log::info("ID：【" . $cast->id . "】" . "アドレス：【" . $cast->email . "】" .
                        "エラー：【パスワードの変更に失敗しました。】アクション：【"
                        . $this->request->params['action'] . "】", "pass_reset");

                    $this->Flash->error('パスワードの変更に失敗しました。');
                    return $this->render();
                }

                try {
                    // レコード更新実行
                    if (!$this->Casts->save($cast)) {
                        throw new RuntimeException('レコードの更新ができませんでした。');
                    }
                    // 変更完了したら、メール送信
                    $email = new Email('default');
                    $email->setFrom([MAIL['SUPPORT_MAIL'] => MAIL['FROM_NAME']])
                        ->setSubject($cast->name . "様、メールアドレスの変更が完了しました。")
                        ->setTo($cast->email)
                        ->setBcc(MAIL['SUPPORT_MAIL'])
                        ->setTemplate("pass_reset_success")
                        ->setLayout("simple_layout")
                        ->emailFormat("html")
                        ->viewVars(['cast' => $cast])
                        ->send();
                    $this->set('cast', $cast);

                    // 変更完了でログインページへ
                    $this->Flash->success(RESULT_M['PASS_RESET_SUCCESS']);
                    Log::info("ID：【" . $cast['id'] . "】アドレス：【" . $cast->email
                        . "】" . RESULT_M['PASS_RESET_SUCCESS'], 'pass_reset');

                    return $this->redirect(['action' => 'login']);
                } catch (RuntimeException $e) {
                    $this->log($this->Util->setLog($auth, $e));
                    $this->Flash->error('パスワードの変更に失敗しました。');
                }
            } else {
                $cast = $validate;
            }
        } else {
            $cast = $this->Casts->newEntity();
        }
        $cast->icon = $this->viewVars['cast']->icon;

        $this->set('cast', $cast);
        return $this->render();
    }

    /**
     * 全ての日記を取得する処理
     *
     * @return void
     */
    public function getAllDiary($id, $diary_path, $user_id = null) {
        $diary = $this->Util->getDiarys(
            $id,
            $this->viewVars['castInfo']['diary_path'],
            empty($this->viewVars['userInfo']) ? 0 : $this->viewVars['userInfo']['id']
        );
        $top_diary = array();
        $arcive_diary = array();
        $count = 0;
        foreach ($diary as $key1 => $rows) :
            foreach ($rows as $key2 => $row) :
                if ($count == 5) :
                    break;
                endif;
                array_push($top_diary, $row);
                unset($diary[$key1][$key2]);
                $count = $count + 1;
            endforeach;
        endforeach;
        foreach ($diary as $key => $rows) :
            if (count($rows) == 0) :
                unset($diary[$key]);
            endif;
        endforeach;
        foreach ($diary as $key1 => $rows) :
            $tmp_array = array();
            foreach ($rows as $key2 => $row) :
                array_push($tmp_array, $row);
            endforeach;
            array_push($arcive_diary, array_values($tmp_array));
        endforeach;

        return array($top_diary, $arcive_diary);
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

    public function blackhole($type) {
        switch ($type) {
            case 'csrf':
                $this->Flash->error(__('不正な送信が行われました'));
                $this->redirect(array('controller' => 'casts', 'action' => 'index'));
                break;
            default:
                $this->Flash->error(__('不正な送信が行われました'));
                $this->redirect(array('controller' => 'casts', 'action' => 'index'));
                break;
        }
    }
}
