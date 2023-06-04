<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;

/**
 * Mysqldump shell task.
 */
class MysqldumpTask extends Shell
{
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
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->execMysqldump();
    }

    /**
     * mysqldumpを実行する
     * @return mixed
     */
    private function execMysqldump()
    {
        // コネクションオブジェクト取得
        $con = ConnectionManager::get('default');
        $date = date('Ymd-His');
        $command = sprintf('mysqldump -u %s -p%s %s > %sbackup.sql', $con->config()['username'], $con->config()['password'], $con->config()['database'], PATH_ROOT['BACKUP'].'/'. $date);
        exec($command, $output, $result);
        return $result;
    }
}
