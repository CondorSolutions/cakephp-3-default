<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * Location Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property \Cake\I18n\Time $created
 * @property int $created_by
 * @property \Cake\I18n\Time $modified
 * @property int $modified_by
 */
class Location extends Entity
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
    
    /* public function getTerminals($location_id = null){
    	$webUtil = new WebUtil();
    	return $webUtil->sendRequest('terminals/getTerminals.json');
    	//Log::write('debug',"test");
    } */
    
    
    
}
