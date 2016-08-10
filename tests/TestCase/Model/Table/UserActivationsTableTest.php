<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserActivationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserActivationsTable Test Case
 */
class UserActivationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserActivationsTable
     */
    public $UserActivations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_activations',
        'app.users',
        'app.roles',
        'app.roles_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserActivations') ? [] : ['className' => 'App\Model\Table\UserActivationsTable'];
        $this->UserActivations = TableRegistry::get('UserActivations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserActivations);

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
