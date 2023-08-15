<?php

namespace App\Controller\Developer;

use Cake\Log\Log;
use Cake\I18n\Time;
use Cake\Event\Event;
use RuntimeException;
use Token\Util\Token;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Mailer\MailerAwareTrait;

/**
 * Developers Controller
 *
 * @property \App\Model\Table\DevelopersTable $Developers
 *
 * @method \App\Model\Entity\Developer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevelopersController extends AppController {
    use MailerAwareTrait;
    public $components = array('Security');

    public function beforeFilter(Event $event) {
        // AppController.beforeFilterをコールバック
        $this->Security->setConfig('blackHoleCallback', 'blackhole');
        // 店舗スイッチアクションのセキュリティ無効化 AJAXを使用しているので
        $this->Security->setConfig('unlockedActions', ['saveNews', 'updateNews', 'deleteNews']);
        parent::beforeFilter($event);
        // デベロッパ用テンプレート
        $this->viewBuilder()->layout('developerDefault');
        // デベロッパに関する情報をセット
        if (!is_null($user = $this->Auth->user())) {
            $developer = $this->Developers->find("all")
                ->where(['developers.email' => $user['email']])
                ->first();
            $userInfo = $this->Util->getDeveloperInfo($developer);
            $this->set(compact('userInfo'));
        }
    }

    public function index() {
        $developer = $this->Developers->newEntity();
        // 認証されてる場合
        if (!is_null($user = $this->Auth->user())) {

            // デベロッパに所属する全ての店舗を取得する
            $developer = $this->Developers->find('all')
                ->where(['email' => $user['email']])->toArray();

            // 非表示または論理削除している場合はログイン画面にリダイレクトする
            if (!$this->checkStatus($user)) {
                return $this->redirect($this->Auth->logout());
            }
        }
        //$val = $this->Analytics->getAnalytics();
        $this->set(compact('developer'));
        $this->render();
    }

    public function login() {
        // レイアウトを使用しない
        $this->viewBuilder()->autoLayout(false);

        if ($this->request->is('post')) {

            // バリデーションはログイン用を使う。
            $developer = $this->Developers->newEntity($this->request->getData(), ['validate' => 'developerLogin']);

            if (!$developer->errors()) {

                if ($developer) {
                    // セッションにユーザー情報を保存する
                    $this->Auth->setUser($developer);
                    Log::info($this->Util->setAccessLog(
                        $developer,
                        $this->request->params['action']
                    ), 'access');

                    return $this->redirect(['action' => 'index']);
                }
                // ログイン失敗
                $this->Flash->error(RESULT_M['FRAUD_INPUT_FAILED']);
            } else {
                Log::error($this->Util->setAccessLog(
                    $developer,
                    $this->request->params['action']
                ) . '　失敗', 'access');
                foreach ($developer->errors() as $key1 => $value1) {
                    foreach ($value1 as $key2 => $value2) {
                        $this->Flash->error($value2);
                    }
                }
            }
        } else {
            $developer = $this->Developers->newEntity();
        }
        $this->set('developer', $developer);
    }

    /**
     * セッション情報を削除し、ログアウトする
     */
    public function logout() {
        $auth = $this->request->session()->read('Auth.Developer');
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
     * ニュース 画面表示処理
     *
     * @return void
     */
    public function news() {
        // ニュース取得
        $allNews = $this->getAllNews();
        $top_news = $allNews[0];
        $arcive_news = $allNews[1];
        $this->set(compact('top_news', 'arcive_news'));
        return $this->render();
    }

    /**
     * ニュース 登録処理
     * @return void
     */
    public function saveNews() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $isDuplicate = false; // 画像重複フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['SIGNUP_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Developer');
        $id = $auth['id']; // ログインユーザID
        $files = array();

        $fileMax = PROPERTY['FILE_MAX']; // ファイルアップの制限数
        $files_befor = array(); // 新規なので空の配列

        // エンティティにマッピングする
        $news = $this->News->newEntity($this->request->getData());
        // バリデーションチェック
        if ($news->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($news); // エラーメッセージをセット
            $response = array('success' => false, 'message' => $errors);
            $this->response->body(json_encode($response));
            return;
        }

        // ニュース用のディレクトリを掘る
        $date = new Time();
        $newsPath =  DS . $date->format('Y')
            . DS . $date->format('m') . DS . $date->format('d')
            . DS . $date->format('Ymd_His');
        $dir = preg_replace('/(\/\/)/', '/', WWW_ROOT . $this->viewVars['userInfo']['news_path']
            . $newsPath);
        $dir = new Folder($dir, true, 0755);
        $news->dir = $newsPath; // ニュースのパスをセット
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
                    $convertFile = $this->Util->file_upload($file, $files_befor, $dir->path, $limitFileSize);

                    // ファイル名が同じ場合は処理をスキップする
                    if ($convertFile === false) {
                        $isDuplicate = true;
                        continue;
                    }
                }
            }
            // レコード更新実行
            if (!$this->News->save($news)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }
        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
        }

        // 例外が発生している場合にメッセージをセットして返却する
        if (!$flg) {
            // アップロード失敗の時、処理を中断する
            if (file_exists($dir->path)) {
                $dir->delete(); // フォルダ削除
            }
            $message = RESULT_M['SIGNUP_FAILED'];
            $response = array(
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;
        }
        // ニュース取得
        $allNews = $this->getAllNews();
        $top_news = $allNews[0];
        $arcive_news = $allNews[1];

        $this->set(compact('top_news', 'arcive_news'));

        $this->render('/Developer/Developers/news');
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
     * ニュースアーカイブ表示画面の処理
     *
     * @return void
     */
    public function viewNews() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $this->confReturnJson(); // json返却用の設定

        $news = $this->Util->getNews(
            $this->request->query["id"],
            $this->viewVars['userInfo']['news_path']
        );

        $this->response->body(json_encode($news));
        return;
    }

    /**
     * ニュースアーカイブ更新処理
     *
     * @return void
     */
    public function updateNews() {

        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $isRemoved = false; // ディレクトリ削除フラグ
        $isDuplicate = false; // 画像重複フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['UPDATE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Developer');
        $id = $auth['id']; // ログインユーザID
        $tmpDir = null; // バックアップ用
        $dir = preg_replace(
            '/(\/\/)/',
            '/',
            WWW_ROOT . $this->request->data["dir_path"]
        );
        // 対象ディレクトリパス取得
        $dir = new Folder($dir, true, 0755);
        $files = array();
        $fileMax = PROPERTY['FILE_MAX'];

        // エンティティにマッピングする
        $news = $this->News->patchEntity($this->News
            ->get($this->request->data['news_id']), $this->request->getData());
        // バリデーションチェック
        if ($news->errors()) {
            // 入力エラーがあれば、メッセージをセットして返す
            $errors = $this->Util->setErrMessage($news); // エラーメッセージをセット
            $response = array('result' => false, 'errors' => $errors);
            $this->response->body(json_encode($response));
            return;
        }

        $delFiles = json_decode($this->request->data["del_list"], true);
        // 既に登録された画像があればデコードし格納、無ければ空の配列を格納する
        ($image_befor = json_decode($this->request->data["json_data"], true)) > 0
            ?: $image_befor = array();

        try {

            // 削除対象ディレクトリパス存在チェック
            if (!file_exists($dir->path)) {
                throw new RuntimeException('ディレクトリが存在しません。');
            }

            // ロールバック用のディレクトリサイズチェック
            if ($dir->dirsize() > CAPACITY['MAX_NUM_BYTES_DIR']) {
                throw new RuntimeException('ディレクトリサイズが大きすぎます。');
            }

            // 既に登録された画像がある場合は、ファイルのバックアップを取得
            if (count($image_befor) > 0) {
                // 一時ディレクトリ作成
                $tmpDir = new Folder(WWW_ROOT . $this->viewVars['userInfo']['tmp_path']
                    . DS . time(), true, 0777);
                // 一時ディレクトリにバックアップ実行
                if (!$dir->copy($tmpDir->path)) {
                    throw new RuntimeException('バックアップに失敗しました。');
                }
            }

            // 削除する画像分処理する
            foreach ($delFiles as $key => $file) {
                $delFile = new File(WWW_ROOT . DS . $file['path']);
                // ファイル削除処理実行
                if (!$delFile->delete()) {
                    throw new RuntimeException('画像の削除に失敗しました。');
                }
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
                    $convertFile = $this->Util->file_upload($file, $image_befor, $dir->path, $limitFileSize);

                    // ファイル名が同じ場合は処理をスキップする
                    if ($convertFile === false) {
                        $isDuplicate = true;
                        continue;
                    }
                }
            }

            // レコード更新実行
            if (!$this->News->save($news)) {
                throw new RuntimeException('レコードの登録ができませんでした。');
            }
        } catch (RuntimeException $e) {
            $this->log($this->Util->setLog($auth, $e));
            $flg = false;
        }

        // 例外が発生している場合にメッセージをセットして返却する
        if (!$flg) {
            if (file_exists($tmpDir->path)) {
                // ファイルを戻す前にアップロードされたファイルがある場合があるため、空にしておく
                $files = $dir->find('.*\.*');
                foreach ($files as $file) {
                    $file = new File($dir->path . DS . $file);
                    $file->delete(); // このファイルを削除します
                }
                $tmpDir->copy($dir->path);
                $tmpDir->delete(); // tmpフォルダ削除
            }
            $message = RESULT_M['UPDATE_FAILED'];
            $flg = false;
            $response = array(
                'success' => $flg,
                'message' => $message
            );
            $this->response->body(json_encode($response));
            return;
        }

        // 一時ディレクトリ削除
        if (file_exists($tmpDir->path)) {
            $tmpDir->delete(); // tmpフォルダ削除
        }

        // ニュース取得
        $allNews = $this->getAllNews();
        $top_news = $allNews[0];
        $arcive_news = $allNews[1];

        $this->set(compact('top_news', 'arcive_news'));
        $this->render('/Developer/Developers/news');
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
     * ニュースアーカイブ削除処理
     *
     * @return void
     */
    public function deleteNews() {
        // AJAXのアクセス以外は不正とみなす。
        if (!$this->request->is('ajax')) {
            throw new MethodNotAllowedException('AJAX以外でのアクセスがあります。');
        }
        $flg = true; // 返却フラグ
        $isRemoved = false; // ディレクトリ削除フラグ
        $errors = ""; // 返却メッセージ
        $this->confReturnJson(); // responceがjsonタイプの場合の共通設定
        $message = RESULT_M['DELETE_SUCCESS']; // 返却メッセージ
        $auth = $this->request->session()->read('Auth.Developer');
        $id = $auth['id']; // ログインユーザID
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
            $tmpDir = new Folder(WWW_ROOT . $this->viewVars['userInfo']['tmp_path']
                . DS . time(), true, 0777);
            // 一時ディレクトリにバックアップ実行
            if (!$dir->copy($tmpDir->path)) {
                throw new RuntimeException('バックアップに失敗しました。');
            }
            // ニュースディレクトリ削除処理実行
            if (!$dir->delete()) {
                throw new RuntimeException('ディレクトリの削除ができませんでした。');
            }
            // ディレクトリ削除フラグを立てる
            $isRemoved = true;
            // 削除対象レコード取得
            $news = $this->News->get($this->request->getData('id'));
            // レコード削除実行
            if (!$this->News->delete($news)) {
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
        // ニュース取得
        $allNews = $this->getAllNews();
        $top_news = $allNews[0];
        $arcive_news = $allNews[1];

        $this->set(compact('top_news', 'arcive_news'));
        $this->render('/Developer/Developers/news');
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
     * 全てのニュースを取得する処理
     *
     * @return void
     */
    public function getAllNews() {
        $news = $this->Util->getNewss($this->viewVars['userInfo']['news_path'], null);
        $top_news = array();
        $arcive_news = array();
        $count = 0;
        foreach ($news as $key1 => $rows) :
            foreach ($rows as $key2 => $row) :
                if ($count == 5) :
                    break;
                endif;
                array_push($top_news, $row);
                unset($news[$key1][$key2]);
                $count = $count + 1;
            endforeach;
        endforeach;
        foreach ($news as $key => $rows) :
            if (count($rows) == 0) :
                unset($news[$key]);
            endif;
        endforeach;
        foreach ($news as $key1 => $rows) :
            $tmp_array = array();
            foreach ($rows as $key2 => $row) :
                array_push($tmp_array, $row);
            endforeach;
            array_push($arcive_news, array_values($tmp_array));
        endforeach;

        return array($top_news, $arcive_news);
    }

    public function blackhole($type) {
        switch ($type) {
            case 'csrf':
                $this->Flash->error(__('不正な送信が行われました'));
                $this->redirect(array('controller' => 'developers', 'action' => 'index'));
                break;
            default:
                $this->Flash->error(__('不正な送信が行われました'));
                $this->redirect(array('controller' => 'developers', 'action' => 'index'));
                break;
        }
    }
}
