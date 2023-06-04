<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiaryLikesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiaryLikesTable Test Case
 */
class DiaryLikesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DiaryLikesTable
     */
    public $DiaryLikes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DiaryLikes',
        'app.Diaries',
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
        $config = TableRegistry::getTableLocator()->exists('DiaryLikes') ? [] : ['className' => DiaryLikesTable::class];
        $this->DiaryLikes = TableRegistry::getTableLocator()->get('DiaryLikes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DiaryLikes);

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
