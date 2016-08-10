<?php
namespace App\Model\Table;

use App\Model\Entity\Repeat;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Repeats Model
 *
 * @property \Cake\ORM\Association\HasMany $Shifts
 */
class RepeatsTable extends Table
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

        $this->table('repeats');
        $this->displayField('id');
        $this->primaryKey('id');

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
            ->allowEmpty('every');

        $validator
            ->integer('every_count')
            ->allowEmpty('every_count');

        $validator
            ->date('start')
            ->allowEmpty('start');

        $validator
            ->date('end')
            ->allowEmpty('end');

        return $validator;
    }
}
