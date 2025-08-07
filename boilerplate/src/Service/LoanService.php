<?php

namespace App\Service;

use Cake\ORM\TableRegistry;
use Cake\Datasource\Exception\RecordNotFoundException;

class LoanService
{
    public static function disburseLoan($loanId, $requestId, $userId)
    {
        $Loans = TableRegistry::getTableLocator()->get('Loans');
        $LoanRequests = TableRegistry::getTableLocator()->get('LoanRequests');
        $Wallets = TableRegistry::getTableLocator()->get('Wallets');
        $Transactions = TableRegistry::getTableLocator()->get('Transactions');

        $loan = $Loans->get($loanId, ['contain' => ['Wallets']]);
        $loanRequest = $LoanRequests->get($requestId, ['conditions' => ['user_id' => $userId]]);

        if (!$loan || !$loanRequest) {
            throw new RecordNotFoundException('Loan or request not found');
        }

        $borrowerWallet = $Wallets->find()
            ->where(['user_id' => $userId])
            ->first();

        if (!$borrowerWallet) {
            throw new \Exception('User does not have a wallet');
        }

        $amount = $loanRequest->amount;

        if ($loan->wallet->balance < $amount) {
            throw new \Exception('Insufficient funds in loan wallet');
        }

        $transaction = $Transactions->newEntity([
            'wallet_id' => $loan->wallet_id,
            'target_wallet_id' => $borrowerWallet->id,
            'amount' => $loanRequest->amount,
            'type' => 'loan_disbursement',
            'status' => 'completed',
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s')
        ]);

        if (!$Transactions->save($transaction)) {
            throw new \Exception('Transaction failed to save');
        }

        $loan->used_amount += $amount;
        $Loans->save($loan);

        // Update wallet balances
        $loan->wallet->balance -= $amount;
        $borrowerWallet->balance += $amount;

        if (!$Wallets->saveMany([$loan->wallet, $borrowerWallet])) {
            throw new \Exception('Failed to update wallet balances');
        }
    }
}
