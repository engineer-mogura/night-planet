<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShopsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShopsTable Test Case
 */
class ShopsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShopsTable
     */
    public $Shops;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Shops',
        'app.Owners',
        'app.AccessMonths',
        'app.AccessWeeks',
        'app.AccessYears',
        'app.Adsenses',
        'app.CastSchedules',
        'app.casts',
        'app.Coupons',
        'app.Jobs',
        'app.Reviews',
        'app.ShopInfos',
        'app.ShopLikes',
        'app.ShopOptions',
        'app.Snss',
        'app.Tmps',
        'app.Updates',
        'app.WorkSchedules',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Shops') ? [] : ['className' => ShopsTable::class];
        $this->Shops = TableRegistry::getTableLocator()->get('Shops', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Shops);

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
