<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdsensesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdsensesTable Test Case
 */
class AdsensesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AdsensesTable
     */
    public $Adsenses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Adsenses',
        'app.Owners',
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
        $config = TableRegistry::getTableLocator()->exists('Adsenses') ? [] : ['className' => AdsensesTable::class];
        $this->Adsenses = TableRegistry::getTableLocator()->get('Adsenses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Adsenses);

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
