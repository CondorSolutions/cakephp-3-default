<?php
namespace App\Model\Table;

use App\Model\Entity\Option;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class OptionsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('options');
        $this->displayField('code');
        $this->primaryKey('code');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Footprint.Footprint');
    }

    
}
