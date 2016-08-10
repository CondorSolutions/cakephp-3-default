<?php
namespace App\Model\Table;

use App\Model\Entity\Address;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Addresses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Entities
 * @property \Cake\ORM\Association\BelongsTo $RefBrgies
 * @property \Cake\ORM\Association\BelongsTo $RefCitymuns
 * @property \Cake\ORM\Association\BelongsTo $RefProvinces
 * @property \Cake\ORM\Association\BelongsTo $RefRegions
 */
class AddressesTable extends Table
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

        $this->table('addresses');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('RefBrgies', [
            'foreignKey' => 'ref_brgy_id'
        ]);
        $this->belongsTo('RefCitymuns', [
            'foreignKey' => 'ref_citymun_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RefProvinces', [
            'foreignKey' => 'ref_province_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RefRegions', [
            'foreignKey' => 'ref_region_id',
            'joinType' => 'INNER'
        ]);
        
        $this->addBehavior('Muffin/Footprint.Footprint');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('entity_type', 'create')
            ->notEmpty('entity_type');

        $validator
            ->allowEmpty('description');

        $validator
            ->integer('line_1')
            ->requirePresence('line_1', 'create')
            ->notEmpty('line_1');

        $validator
            ->integer('line_2')
            ->requirePresence('line_2', 'create')
            ->notEmpty('line_2');

        $validator
            ->integer('created_by')
            ->allowEmpty('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmpty('modified_by');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    /* public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['ref_brgy_id'], 'RefBrgys'));
        $rules->add($rules->existsIn(['ref_citymun_id'], 'RefCitymuns'));
        $rules->add($rules->existsIn(['ref_province_id'], 'RefProvinces'));
        $rules->add($rules->existsIn(['ref_region_id'], 'RefRegions'));
        return $rules;
    } */
}
