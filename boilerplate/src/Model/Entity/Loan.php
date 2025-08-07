<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Loan extends Entity
{
    protected $_accessible = [
        'title' => true,
        'max_amount' => true,
        'used_amount' => true,
        'max_interest' => true,
        'min_interest' => true,
        'max_duration_months' => true,
        'min_duration_months' => true,
        'wallet_id' => true,
        'created' => true,
        'modified' => true
    ];

    protected $_virtual = ['remaining_amount'];

    protected function _getRemainingAmount()
    {
        // Check if properties exist to avoid errors
        $maxAmount = $this->max_amount ?? 0;
        $usedAmount = $this->used_amount ?? 0;

        return $maxAmount - $usedAmount;
    }
}