<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class PunchLog extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
