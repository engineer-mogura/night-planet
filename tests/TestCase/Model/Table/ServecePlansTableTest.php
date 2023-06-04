<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ServecePlansTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ServecePlansTable Test Case
 */
class ServecePlansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ServecePlansTable
     */
    public $ServecePlans;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ServecePlans',
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
        $config = TableRegistry::getTableLocator()->exists('ServecePlans') ? [] : ['className' => ServecePlansTable::class];
        $this->ServecePlans = TableRegistry::getTableLocator()->get('ServecePlans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ServecePlans);

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
