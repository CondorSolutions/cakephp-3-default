<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersStandardShiftsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersStandardShiftsTable Test Case
 */
class UsersStandardShiftsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersStandardShiftsTable
     */
    public $UsersStandardShifts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users_standard_shifts',
        'app.users',
        'app.roles',
        'app.roles_users',
        'app.standard_shifts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsersStandardShifts') ? [] : ['className' => 'App\Model\Table\UsersStandardShiftsTable'];
        $this->UsersStandardShifts = TableRegistry::get('UsersStandardShifts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersStandardShifts);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
