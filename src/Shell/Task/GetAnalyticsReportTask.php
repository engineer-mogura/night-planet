<?php

namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use App\Controller\ApiGooglesController;

/**
 * GetAnalyticsReport shell task.
 */
class GetAnalyticsReportTask extends Shell {
    public function initialize() {
        parent::initialize();
        $this->ApiGoogles = new ApiGooglesController();
    }
    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main() {
        $this->execGetAnalyticsReport();
    }

    /**
     * GetAnalyticsReportを実行する
     * @return mixed
     */
    private function execGetAnalyticsReport() {
        // 
        $this->ApiGoogles->index();
        return $result;
    }
}
