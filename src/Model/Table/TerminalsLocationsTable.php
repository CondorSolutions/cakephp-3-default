<?php
namespace App\Model\Table;

use App\Model\Entity\TerminalsLocation;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TerminalsLocations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Terminals
 */
class TerminalsLocationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('terminals_locations');
        $this->primaryKey(['location_id', 'terminal_id']);
        $this->belongsTo('Locations', [
        		'foreignKey' => 'location_id',
        		'joinType' => 'INNER'
        		]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        return $validator;
    }

    
}
