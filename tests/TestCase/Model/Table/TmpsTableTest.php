<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TmpsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TmpsTable Test Case
 */
class TmpsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TmpsTable
     */
    public $Tmps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Tmps',
        'app.Shops',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tmps') ? [] : ['className' => TmpsTable::class];
        $this->Tmps = TableRegistry::getTableLocator()->get('Tmps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tmps);

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
