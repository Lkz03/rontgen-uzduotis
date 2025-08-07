<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class LoanRequest extends Entity
{
    protected $_accessible = [
        'user_id' => true,
        'amount' => true,
        'duration' => true,
        'created' => true,
        'modified' => true
    ];
}