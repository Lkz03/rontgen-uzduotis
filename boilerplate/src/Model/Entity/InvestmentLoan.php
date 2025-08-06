<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class InvestmentLoan extends Entity
{
    protected $_accessible = [
        'title' => true,
        'max_amount' => true,
        'max_interest' => true,
        'min_interest' => true,
        'max_duration_months' => true,
        'min_duration_months' => true,
        'created' => true,
        'modified' => true
    ];
}