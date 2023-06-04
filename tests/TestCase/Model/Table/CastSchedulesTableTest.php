<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CastSchedulesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CastSchedulesTable Test Case
 */
class CastSchedulesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CastSchedulesTable
     */
    public $CastSchedules;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CastSchedules',
        'app.Shops',
        'app.casts',
        'app.EventTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CastSchedules') ? [] : ['className' => CastSchedulesTable::class];
        $this->CastSchedules = TableRegistry::getTableLocator()->get('CastSchedules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CastSchedules);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
