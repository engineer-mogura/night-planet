<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShopInfosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShopInfosTable Test Case
 */
class ShopInfosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShopInfosTable
     */
    public $ShopInfos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ShopInfos',
        'app.Shops',
        'app.ShopInfoLikes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShopInfos') ? [] : ['className' => ShopInfosTable::class];
        $this->ShopInfos = TableRegistry::getTableLocator()->get('ShopInfos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShopInfos);

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
