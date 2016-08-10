<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Address Entity.
 *
 * @property int $id
 * @property \App\Model\Entity\Entity $entity
 * @property int $entity_id
 * @property string $description
 * @property int $line_1
 * @property int $line_2
 * @property int $ref_brgy_id
 * @property \App\Model\Entity\RefBrgy $ref_brgy
 * @property int $ref_citymun_id
 * @property \App\Model\Entity\RefCitymun $ref_citymun
 * @property int $ref_province_id
 * @property \App\Model\Entity\RefProvince $ref_province
 * @property int $ref_region_id
 * @property \App\Model\Entity\RefRegion $ref_region
 * @property \Cake\I18n\Time $created
 * @property int $created_by
 * @property \Cake\I18n\Time $modified
 * @property int $modified_by
 */
class Address extends Entity
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
    
    public function getRefChildred($type, $parent_code)
    {
    	$data = null;
    	$refQuery = null;
    	switch ($type){
    		case 'RefProvinces':
    			$refProvinceTable = TableRegistry::get('RefProvinces');
    			$refQuery = $refProvinceTable->find('all', ['conditions' => ['RefProvinces.ref_region_code'=>$parent_code]]);
    			break;
    			case 'RefCitymuns':
    				$refProvinceTable = TableRegistry::get('RefCitymuns');
    				$refQuery = $refProvinceTable->find('all', ['conditions' => ['RefCitymuns.ref_province_code'=>$parent_code]]);
    				break;
    				case 'RefBrgys':
    					$refProvinceTable = TableRegistry::get('RefBrgys');
    					$refQuery = $refProvinceTable->find('all', ['conditions' => ['RefBrgys.ref_citymun_code'=>$parent_code]]);
    					break;
    	}
    	$data = $refQuery->all();
    	return $data;
    }
}
