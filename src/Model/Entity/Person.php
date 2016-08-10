<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Log\Log;
use App\Util\OptionsUtil;
/**
 * Person Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $created
 * @property int $created_by
 * @property \Cake\I18n\Time $modified
 * @property int $modified_by
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $type
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $photo
 * @property string $mobile
 * @property string $landline
 * @property string $personal_email
 * @property \Cake\I18n\Time $dob
 * @property string $birth_place
 * @property string $gender
 * @property string $citizenship
 * @property string $tin
 * @property string $sss
 * @property string $philhealth
 * @property string $pagibig
 */
class Person extends Entity
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
    
    protected function _getFullName() {
    	return $this->_properties['first_name'] . ' ' . $this->_properties['last_name'];
    }
    
    protected function _getPhotoPath(){
    	$filePath = 'files/Persons/photo/' . Configure::read('Users.default_photo');
    	
    	if($this->_properties['photo'])
    		if(file_exists(OptionsUtil::getOption(OptionsUtil::FILES_PATH)->value1 . DS . 'Persons' . DS . 'photo' . DS . $this->_properties['id'] . DS . $this->_properties['photo']))
    			$filePath = 'files/Persons/photo/' .$this->_properties['id'] . '/' . $this->_properties['photo'];
    		return $filePath;
    }
}
