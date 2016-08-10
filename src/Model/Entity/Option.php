<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Option extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
