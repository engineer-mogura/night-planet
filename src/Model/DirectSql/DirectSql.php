<?php

namespace App\Model\DirectSql;

use Cake\ORM\Query;
use Cake\Datasource\ConnectionManager;

/**
 *
 */
class DirectSql {

    protected static $conn = null;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    function __construct() {
        $this::$conn = ConnectionManager::get('default');
        // TODO: 本番運用時には, false に変更すること
        $this::$conn->logQueries(true);
    }
}
