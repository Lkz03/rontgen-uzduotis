<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class LoansTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('loans');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('title')
            ->numeric('max_amount')
            ->greaterThan('max_amount', 0)
            ->integer('max_interest')
            ->integer('min_interest')
            ->integer('max_duration_months')
            ->integer('min_duration_months')
            ->notEmptyDateTime('created')
            ->notEmptyDateTime('modified');

        return $validator;
    }
}