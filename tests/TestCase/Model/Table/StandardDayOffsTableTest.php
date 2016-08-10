<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StandardDayOffsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StandardDayOffsTable Test Case
 */
class StandardDayOffsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StandardDayOffsTable
     */
    public $StandardDayOffs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('StandardDayOffs') ? [] : ['className' => 'App\Model\Table\StandardDayOffsTable'];
        $this->StandardDayOffs = TableRegistry::get('StandardDayOffs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StandardDayOffs);

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
