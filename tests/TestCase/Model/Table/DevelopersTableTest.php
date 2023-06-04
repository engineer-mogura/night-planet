<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevelopersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevelopersTable Test Case
 */
class DevelopersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DevelopersTable
     */
    public $Developers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Developers',
        'app.News',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Developers') ? [] : ['className' => DevelopersTable::class];
        $this->Developers = TableRegistry::getTableLocator()->get('Developers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Developers);

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
