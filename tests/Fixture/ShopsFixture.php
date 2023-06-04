<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShopsFixture
 */
class ShopsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'owner_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'area' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'genre' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'dir' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 40, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'catch' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'tel' => ['type' => 'string', 'length' => 15, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'staff' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'bus_from_time' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'bus_to_time' => ['type' => 'time', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'bus_hosoku' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'system' => ['type' => 'string', 'length' => 900, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_0900_ai_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'credit' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'pref21' => ['type' => 'string', 'length' => 3, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'addr21' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'strt21' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'status' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'delete_flag' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'owner_id' => ['type' => 'index', 'columns' => ['owner_id'], 'length' => []],
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
                'owner_id' => 1,
                'area' => 'Lorem ipsum dolor sit amet',
                'genre' => 'Lorem ipsum dolor sit amet',
                'dir' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'catch' => 'Lorem ipsum dolor sit amet',
                'tel' => 'Lorem ipsum d',
                'staff' => 'Lorem ipsum dolor sit amet',
                'bus_from_time' => '11:51:59',
                'bus_to_time' => '11:51:59',
                'bus_hosoku' => 'Lorem ipsum dolor sit amet',
                'system' => 'Lorem ipsum dolor sit amet',
                'credit' => 'Lorem ipsum dolor sit amet',
                'pref21' => 'L',
                'addr21' => 'Lorem ip',
                'strt21' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'delete_flag' => 1,
                'created' => '2022-11-21 11:51:59',
                'modified' => '2022-11-21 11:51:59',
            ],
        ];
        parent::init();
    }
}
