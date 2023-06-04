<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccessWeeksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccessWeeksTable Test Case
 */
class AccessWeeksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccessWeeksTable
     */
    public $AccessWeeks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AccessWeeks',
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
        $config = TableRegistry::getTableLocator()->exists('AccessWeeks') ? [] : ['className' => AccessWeeksTable::class];
        $this->AccessWeeks = TableRegistry::getTableLocator()->get('AccessWeeks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccessWeeks);

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
