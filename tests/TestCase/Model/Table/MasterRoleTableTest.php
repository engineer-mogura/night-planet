<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterRoleTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterRoleTable Test Case
 */
class MasterRoleTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterRoleTable
     */
    public $MasterRole;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MasterRole',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MasterRole') ? [] : ['className' => MasterRoleTable::class];
        $this->MasterRole = TableRegistry::getTableLocator()->get('MasterRole', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MasterRole);

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
