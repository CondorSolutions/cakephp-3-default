<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersStandardDayOffsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersStandardDayOffsTable Test Case
 */
class UsersStandardDayOffsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersStandardDayOffsTable
     */
    public $UsersStandardDayOffs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users_standard_day_offs',
        'app.users',
        'app.roles',
        'app.roles_users',
        'app.standard_day_offs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsersStandardDayOffs') ? [] : ['className' => 'App\Model\Table\UsersStandardDayOffsTable'];
        $this->UsersStandardDayOffs = TableRegistry::get('UsersStandardDayOffs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersStandardDayOffs);

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
