<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class LoansController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Loans');
        $this->loadComponent('Flash');     // for flash messages
    }

    /**
     * Check if current user is admin
     *
     * @return bool
     */
    private function isAdmin()
    {
        $user = $this->Auth->user();
        return $user && isset($user['role']) && $user['role'] === 'admin';
    }

    /**
     * Require admin access for action
     */
    private function requireAdmin()
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(__('Access denied. Admin privileges required.'));
            return $this->redirect(['controller' => 'Client', 'action' => 'dashboard']);
        }
        return true;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if (!$this->requireAdmin()) {
            return;
        }

        $loan = $this->Loans->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (!empty($data['min_duration_picker'])) {
                $data['min_duration_months'] = $data['min_duration_picker'];
            }
            if (!empty($data['max_duration_picker'])) {
                $data['max_duration_months'] = $data['max_duration_picker'];
            }

            $loan = $this->Loans->patchEntity($loan, $data);

            if ($this->Loans->save($loan)) {
                $this->Flash->success(__('The loan has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The loan could not be saved. Please, try again.'));
        }
        
        $this->set(compact('loan'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        if (!$this->requireAdmin()) {
            return;
        }

        $loans = $this->Loans->find('all');
        Log::debug('Loans found: ' . count($loans->toArray()));
        
        $this->set(compact('loans'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Investment Loan id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if (!$this->requireAdmin()) {
            return;
        }

        $this->request->allowMethod(['post', 'delete']);
        $loan = $this->Loans->get($id);
        
        if ($this->Loans->delete($loan)) {
            $this->Flash->success(__('The loan has been deleted.'));
        } else {
            $this->Flash->error(__('The loan could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
