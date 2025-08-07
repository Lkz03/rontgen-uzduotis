<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class LoanApplicationsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Loans');
        $this->loadModel('LoanRequests');
        $this->loadComponent('Flash');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function request()
    {
        $loanRequest = $this->LoanRequests->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $userId = $this->Auth->user('id');

            $loanRequest = $this->LoanRequests->patchEntity($loanRequest, $data);
            $loanRequest->user_id = $userId;

            if ($this->LoanRequests->save($loanRequest)) {
                $this->Flash->success(__('Your loan request has been submitted successfully.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Your loan request could not be submitted. Please check the errors and try again.'));
            }
        }

        $this->set(compact('loanRequest'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $userId = $this->Auth->user('id');

        $this->loadModel('LoanRequests');

        $loanRequests = $this->LoanRequests->find()
            ->where(['LoanRequests.user_id' => $userId])
            ->toArray();

        $matchingLoans = [];

        foreach ($loanRequests as $request) {
            $loans = $this->Loans->find('matching', ['loanRequest' => $request])->toArray();
            
            $filteredLoans = array_filter($loans, function($loan) use ($request) {
                Log::debug("Loan ID {$loan->id} remaining_amount: " . $loan->remaining_amount);
                return $loan->remaining_amount >= $request->amount;
            });

            $matchingLoans[$request->id] = array_values($filteredLoans);
        }
        
        $this->set(compact('loanRequests', 'matchingLoans'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reuqest Loan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $request = $this->LoanRequests->get($id);
        
        if ($this->LoanRequests->delete($request)) {
            $this->Flash->success(__('The loan has been deleted.'));
        } else {
            $this->Flash->error(__('The loan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
