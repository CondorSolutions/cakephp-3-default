<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RefCitymunsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RefCitymunsTable Test Case
 */
class RefCitymunsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RefCitymunsTable
     */
    public $RefCitymuns;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ref_citymuns'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RefCitymuns') ? [] : ['className' => 'App\Model\Table\RefCitymunsTable'];
        $this->RefCitymuns = TableRegistry::get('RefCitymuns', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RefCitymuns);

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
