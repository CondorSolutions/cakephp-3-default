<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationsTerminalsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationsTerminalsTable Test Case
 */
class LocationsTerminalsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationsTerminalsTable
     */
    public $LocationsTerminals;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.locations_terminals',
        'app.locations',
        'app.terminals'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LocationsTerminals') ? [] : ['className' => 'App\Model\Table\LocationsTerminalsTable'];
        $this->LocationsTerminals = TableRegistry::get('LocationsTerminals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LocationsTerminals);

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
