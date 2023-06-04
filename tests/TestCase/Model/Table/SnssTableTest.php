<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SnssTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SnssTable Test Case
 */
class SnssTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SnssTable
     */
    public $Snss;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Snss',
        'app.Shops',
        'app.casts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Snss') ? [] : ['className' => SnssTable::class];
        $this->Snss = TableRegistry::getTableLocator()->get('Snss', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Snss);

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
