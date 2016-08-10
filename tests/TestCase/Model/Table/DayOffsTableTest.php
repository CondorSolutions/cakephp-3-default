<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DayOffsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DayOffsTable Test Case
 */
class DayOffsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DayOffsTable
     */
    public $DayOffs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.day_offs',
        'app.users',
        'app.roles',
        'app.roles_users',
        'app.repeats',
        'app.shifts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DayOffs') ? [] : ['className' => 'App\Model\Table\DayOffsTable'];
        $this->DayOffs = TableRegistry::get('DayOffs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DayOffs);

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
