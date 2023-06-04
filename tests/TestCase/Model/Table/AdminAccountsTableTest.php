<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdminAccountsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdminAccountsTable Test Case
 */
class AdminAccountsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AdminAccountsTable
     */
    public $AdminAccounts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AdminAccounts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AdminAccounts') ? [] : ['className' => AdminAccountsTable::class];
        $this->AdminAccounts = TableRegistry::getTableLocator()->get('AdminAccounts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdminAccounts);

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
