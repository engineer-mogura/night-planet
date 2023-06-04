<?php
namespace App\Shell\Task;

use Cake\Log\Log;
use Cake\Console\Shell;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\CommonComponent;

/**
 * Mysqldump shell task.
 */
class AnalyticsReportTask extends Shell
{
    public function initialize() {
        $this->Common = new CommonComponent(new ComponentRegistry());
    }
    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * 新着画像投稿を集計する処理
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->execAnalyticsReport();
    }

    /**
     * 各店舗のアクセスレポートを集計する処理を呼び出す
     * @return mixed
     */
    private function execAnalyticsReport()
    {
        $date = date('Ymd-His');
        $ca = $this->name . ':' . __FUNCTION__ . ':';
        $this->log($ca . 'START', LOG_DEBUG);

        $result = $this->Common->AnalyticsReport();
        if ($result) {
          $this->log($ca . 'アクセスレポート集計処理が成功しました。', LOG_DEBUG);
        } else {
          $this->log($ca . 'アクセスレポート集計処理が失敗しました。', LOG_ERR);
        }
        $this->log($ca . 'END', LOG_DEBUG);
    }
}
