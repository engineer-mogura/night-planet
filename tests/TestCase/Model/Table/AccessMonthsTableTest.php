<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccessMonthsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccessMonthsTable Test Case
 */
class AccessMonthsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccessMonthsTable
     */
    public $AccessMonths;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AccessMonths',
        'app.Shops',
        'app.Owners',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AccessMonths') ? [] : ['className' => AccessMonthsTable::class];
        $this->AccessMonths = TableRegistry::getTableLocator()->get('AccessMonths', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccessMonths);

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
