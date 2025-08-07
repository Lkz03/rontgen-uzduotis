<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;
use Cake\Database\Expression\QueryExpression;
use Cake\Log\Log;

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
            ->numeric('used_amount')
            ->greaterThanOrEqual('used_amount', 0, 'Used amount cannot be negative')
            ->add('used_amount', 'lessThanOrEqualMaxAmount', [
                'rule' => function ($value, $context) {
                    return $value <= $context['data']['max_amount'];
                },
                'message' => 'Used amount cannot be greater than the maximum amount'
            ])
            ->integer('max_interest')
            ->integer('min_interest')
            ->integer('max_duration_months')
            ->integer('min_duration_months')
            ->notEmptyDateTime('created')
            ->notEmptyDateTime('modified');

        return $validator;
    }

    public function findMatching(Query $query, array $options)
    {
        $loanRequest = $options['loanRequest'];

        if (empty($loanRequest) || empty($loanRequest->amount)) {
            return $query;
        }

        $query
        ->where([
            'Loans.min_duration_months <=' => $loanRequest->duration,
            'Loans.max_duration_months >=' => $loanRequest->duration
        ]);

        return $query;
    }
}