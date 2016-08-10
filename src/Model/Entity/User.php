<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
/**
 * User Entity.
 *
 * @property int $id
 * @property int $active
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property \Cake\I18n\Time $created
 * @property int $created_by
 * @property \Cake\I18n\Time $modified
 * @property int $modified_by
 * @property \App\Model\Entity\Role[] $roles
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
	
	/**
     * _setPassword description
     *
     * @param string $password hashes password before storing to database
     */
    protected function _setPassword($password) {
        return (new DefaultPasswordHasher)->hash($password);
    }
    
    protected function _getPerson(){
    	$personTable = TableRegistry::get('Persons');
    	$query = $personTable->find('all')
    		->where(['Persons.person_type'=>'User','Persons.user_id'=>$this->_properties['id']]);
    	return $query->first();
    }
    
    protected function _getPhotoPath(){
    	$filePath = 'files/Persons/photo/' . Configure::read('Users.default_photo');
    	$person = $this->_getPerson();
    	if($person->photo)
    		if(file_exists(Configure::read('App.files_path') . DS . 'Persons' . DS . 'photo' . DS . $person->id . DS . $person->photo))
    			$filePath = 'files/Persons/photo/' .$person->id . '/' . $person->photo;
    		return $filePath;
    }
    
    protected function _getFullName(){
    	$personTable = TableRegistry::get('Persons');
    	$query = $personTable->find('all')
    	->where(['Persons.person_type'=>'User','Persons.user_id'=>$this->_properties['id']]);
    	$person = $query->first();
    	return $person->full_name;
    }
    
}
