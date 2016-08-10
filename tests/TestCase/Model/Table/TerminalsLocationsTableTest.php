<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TerminalsLocationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TerminalsLocationsTable Test Case
 */
class TerminalsLocationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TerminalsLocationsTable
     */
    public $TerminalsLocations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.terminals_locations',
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
        $config = TableRegistry::exists('TerminalsLocations') ? [] : ['className' => 'App\Model\Table\TerminalsLocationsTable'];
        $this->TerminalsLocations = TableRegistry::get('TerminalsLocations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TerminalsLocations);

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
