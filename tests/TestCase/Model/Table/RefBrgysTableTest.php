<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RefBrgysTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RefBrgysTable Test Case
 */
class RefBrgysTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RefBrgysTable
     */
    public $RefBrgys;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ref_brgys'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RefBrgys') ? [] : ['className' => 'App\Model\Table\RefBrgysTable'];
        $this->RefBrgys = TableRegistry::get('RefBrgys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RefBrgys);

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
