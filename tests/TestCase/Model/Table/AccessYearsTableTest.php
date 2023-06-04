<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccessYearsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccessYearsTable Test Case
 */
class AccessYearsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccessYearsTable
     */
    public $AccessYears;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AccessYears',
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
        $config = TableRegistry::getTableLocator()->exists('AccessYears') ? [] : ['className' => AccessYearsTable::class];
        $this->AccessYears = TableRegistry::getTableLocator()->get('AccessYears', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccessYears);

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
