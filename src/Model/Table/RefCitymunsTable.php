<?php
namespace App\Model\Table;

use App\Model\Entity\RefCitymun;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RefCitymuns Model
 *
 */
class RefCitymunsTable extends Table
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

        $this->table('ref_citymuns');
        $this->displayField('name');
        $this->primaryKey('id');
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
            ->allowEmpty('psgc_code');

        $validator
            ->allowEmpty('name');

        $validator
            ->allowEmpty('ref_region_code');

        $validator
            ->allowEmpty('ref_province_code');

        $validator
            ->allowEmpty('code');

        return $validator;
    }
}
