<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\castsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\castsTable Test Case
 */
class castsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\castsTable
     */
    public $casts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.casts',
        'app.Shops',
        'app.CastLikes',
        'app.CastSchedules',
        'app.Diarys',
        'app.Snss',
        'app.Updates',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('casts') ? [] : ['className' => castsTable::class];
        $this->casts = TableRegistry::getTableLocator()->get('casts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->casts);

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
