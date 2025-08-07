<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class LoanRequestsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('loanRequests');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->numeric('amount')
            ->greaterThan('amount', 0)
            ->integer('duration')
            ->notEmptyDateTime('created')
            ->notEmptyDateTime('modified');

        return $validator;
    }
}