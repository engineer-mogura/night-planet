<?php
namespace App\Controller;

use Cake\Log\Log;
use Cake\Event\Event;
use Token\Util\Token;
use Cake\Collection\Collection;

/**
 * Controls the data flow into shops object and updates the view whenever data changes.
 */
class ExeShellController extends AppController
{

    static public $shell_path = ""; // シェル実行パス
    static public $php_path   = ""; // PHPパス
    static public $exec_path  = ""; // 実行パス

    public function beforeFilter(Event $event)
    {
        // AppController.beforeFilterをコールバック
        parent::beforeFilter($event);

        // PHPパス判定
        if (strpos(ADMIN_DOMAIN, 'local') === false) {
          // レンタルサーバーのPHPパスを設定する
          ExeShellController::$exec_path = '/usr/local/php/7.1/bin/php ';
        } else {
          // ローカル仮想サーバーのPHPパスを設定する
          ExeShellController::$exec_path = 'php ';
        }
        // シェル実行パスを設定する
        ExeShellController::$shell_path  = ROOT . DS .'bin/cake.php ';
        // 実行パスを設定する
        ExeShellController::$exec_path   = ExeShellController::$exec_path . ExeShellController::$shell_path;

    }

    public function backup()
    {
      Log::info('--------'.__LINE__ . '::' . __METHOD__ . '::処理を開始します。--------', 'batch_bk');
      exec(ExeShellController::$exec_path .$this->request->param('action') , $output, $result);
      Log::info(__LINE__ . '::' . __METHOD__ . '::' . "アウトプット:".$output . "結果コード:" . $result, 'batch_bk');
      Log::info('--------'.__LINE__ . '::' . __METHOD__ . '::処理を終了します。--------', 'batch_bk');
      // ダミー画面を表示する
      // シンプルレイアウトを使用
      $this->viewBuilder()->layout('simpleDefault');
      return $this->render("/exeshell/result");
    }

    /**
     * 新着フォト投稿DB登録処理
     *
     * @return void
     */
    public function saveNewPhotosRank()
    {
      Log::info('--------'.__LINE__ . '::' . __METHOD__ . '::処理を開始します。--------', 'batch_snpr');
      exec(ExeShellController::$exec_path .$this->request->param('action') , $output, $result);
      Log::info(__LINE__ . '::' . __METHOD__ . '::' . "アウトプット:".$output . "結果コード:" . $result, 'batch_snpr');
      Log::info('--------'.__LINE__ . '::' . __METHOD__ . '::処理を終了します。--------', 'batch_snpr');
      // ダミー画面を表示する
      // シンプルレイアウトを使用
      $this->viewBuilder()->layout('simpleDefault');
      return $this->render("/exeshell/result");
    }

    /**
     * 各店舗のアクセスレポートを集計する処理
     *
     * @return void
     */
    public function analyticsReport()
    {
      Log::info('--------'.__LINE__ . '::' . __METHOD__ . '::処理を開始します。--------', 'batch_ar');
      exec(ExeShellController::$exec_path .$this->request->param('action') , $output, $result);
      Log::info(__LINE__ . '::' . __METHOD__ . '::' . "アウトプット:".$output . "結果コード:" . $result, 'batch_ar');
      Log::info('--------'.__LINE__ . '::' . __METHOD__ . '::処理を終了します。--------', 'batch_ar');
      // ダミー画面を表示する
      // シンプルレイアウトを使用
      $this->viewBuilder()->layout('simpleDefault');
      return $this->render("/exeshell/result");
    }

}
