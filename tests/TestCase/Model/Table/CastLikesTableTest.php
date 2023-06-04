<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CastLikesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CastLikesTable Test Case
 */
class CastLikesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CastLikesTable
     */
    public $CastLikes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CastLikes',
        'app.casts',
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
        $config = TableRegistry::getTableLocator()->exists('CastLikes') ? [] : ['className' => CastLikesTable::class];
        $this->CastLikes = TableRegistry::getTableLocator()->get('CastLikes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CastLikes);

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
