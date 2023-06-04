<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MasterRoleFixture
 */
class MasterRoleFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'master_role';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'role' => ['type' => 'string', 'length' => 64, 'null' => false, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => 'ロール名', 'precision' => null, 'fixed' => null],
        'role_name' => ['type' => 'string', 'length' => 64, 'null' => false, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => 'ロール名', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb3_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'role' => 'Lorem ipsum dolor sit amet',
                'role_name' => 'Lorem ipsum dolor sit amet',
                'created' => '2022-11-21 11:51:48',
                'modified' => '2022-11-21 11:51:48',
            ],
        ];
        parent::init();
    }
}
