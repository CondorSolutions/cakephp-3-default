<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RefProvincesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RefProvincesTable Test Case
 */
class RefProvincesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RefProvincesTable
     */
    public $RefProvinces;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ref_provinces'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RefProvinces') ? [] : ['className' => 'App\Model\Table\RefProvincesTable'];
        $this->RefProvinces = TableRegistry::get('RefProvinces', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RefProvinces);

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
