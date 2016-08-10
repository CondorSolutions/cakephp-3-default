<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RefRegionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RefRegionsTable Test Case
 */
class RefRegionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RefRegionsTable
     */
    public $RefRegions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ref_regions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RefRegions') ? [] : ['className' => 'App\Model\Table\RefRegionsTable'];
        $this->RefRegions = TableRegistry::get('RefRegions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RefRegions);

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
}
