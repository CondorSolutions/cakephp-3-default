<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersStandardDayOff Entity.
 *
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $standard_day_off_id
 * @property \App\Model\Entity\StandardDayOff $standard_day_off
 */
class UsersStandardDayOff extends Entity
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
        'user_id' => false,
        'standard_day_off_id' => false,
    ];
}
