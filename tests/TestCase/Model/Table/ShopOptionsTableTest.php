<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShopOptionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShopOptionsTable Test Case
 */
class ShopOptionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShopOptionsTable
     */
    public $ShopOptions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ShopOptions',
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
        $config = TableRegistry::getTableLocator()->exists('ShopOptions') ? [] : ['className' => ShopOptionsTable::class];
        $this->ShopOptions = TableRegistry::getTableLocator()->get('ShopOptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShopOptions);

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
