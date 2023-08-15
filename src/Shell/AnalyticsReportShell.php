<?php

namespace App\Shell;

use Cake\Log\Log;
use Cake\Console\Shell;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\BatchComponent;

/**
 * DatabaseBackup shell command.
 */
class AnalyticsReportShell extends Shell {
    public $tasks = ['AnalyticsReport']; // ← タスクの読み込み

    function initialize() {
        // コンポーネントを参照(コンポーネントを利用する場合)
        $this->Batch = new BatchComponent(new ComponentRegistry());
    }
    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     * 引数がNullの場合は本番運用での処理と同様となる
     * args1 開始日</br>
     * args2 終了日</abr>
     * @return bool|int|null Success or error code.
     */
    public function main() {
        // タスクの実行
        $result = $this->Batch->analyticsReport($this->args[0], $this->args[1]);
        if ($result) {
            Log::info(__LINE__ . '::' . __METHOD__ . "::バッチ処理が成功しました。", "batch_ar");
        } else {
            Log::error(__LINE__ . '::' . __METHOD__ . "::バッチ処理が失敗しました。", "batch_ar");
        }
    }
}
