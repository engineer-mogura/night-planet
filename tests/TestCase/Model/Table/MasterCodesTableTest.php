<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterCodesTable Test Case
 */
class MasterCodesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterCodesTable
     */
    public $MasterCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MasterCodes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MasterCodes') ? [] : ['className' => MasterCodesTable::class];
        $this->MasterCodes = TableRegistry::getTableLocator()->get('MasterCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MasterCodes);

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
}
