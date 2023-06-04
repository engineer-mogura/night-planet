<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CastsFixture
 */
class CastsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'shop_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'role' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'nickname' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'birthday' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'three_size' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'blood_type' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'constellation' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'age' => ['type' => 'string', 'length' => 5, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'message' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'holiday' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'dir' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'remember_token' => ['type' => 'string', 'length' => 64, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'delete_flag' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'shop_key' => ['type' => 'index', 'columns' => ['shop_id'], 'length' => []],
        ],
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
                'shop_id' => 1,
                'role' => 'Lorem ip',
                'name' => 'Lorem ipsum dolor sit amet',
                'nickname' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'birthday' => '2022-11-21 11:51:43',
                'three_size' => 'Lorem ip',
                'blood_type' => 'Lorem ipsum dolor ',
                'constellation' => 'Lorem ipsum dolor ',
                'age' => 'Lor',
                'message' => 'Lorem ipsum dolor sit amet',
                'holiday' => 'Lorem ipsum dolor sit amet',
                'dir' => 'Lorem ipsum dolor sit amet',
                'remember_token' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'delete_flag' => 1,
                'created' => '2022-11-21 11:51:43',
                'modified' => '2022-11-21 11:51:43',
            ],
        ];
        parent::init();
    }
}
