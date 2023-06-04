<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShopInfoLikesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShopInfoLikesTable Test Case
 */
class ShopInfoLikesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShopInfoLikesTable
     */
    public $ShopInfoLikes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ShopInfoLikes',
        'app.ShopInfos',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShopInfoLikes') ? [] : ['className' => ShopInfoLikesTable::class];
        $this->ShopInfoLikes = TableRegistry::getTableLocator()->get('ShopInfoLikes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShopInfoLikes);

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
