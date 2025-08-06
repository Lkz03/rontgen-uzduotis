<?php
namespace App\Controller;

use App\Controller\AppController;

class InvestmentLoansController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('InvestmentLoans');
        $this->loadModel('ProjectTypes');  // for dropdown options
        $this->loadModel('Locations');     // if you're saving location data separately
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

        $investmentLoan = $this->InvestmentLoans->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Override duration_months fields if pickers are used
            if (!empty($data['min_duration_picker'])) {
                $data['min_duration_months'] = $data['min_duration_picker'];
            }
            if (!empty($data['max_duration_picker'])) {
                $data['max_duration_months'] = $data['max_duration_picker'];
            }

            // Patch entity without associations
            $investmentLoan = $this->InvestmentLoans->patchEntity($investmentLoan, $data);

            if ($this->InvestmentLoans->save($investmentLoan)) {
                $this->Flash->success(__('The investment loan has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The investment loan could not be saved. Please, try again.'));
        }

        $this->set(compact('investmentLoan'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->loadModel('InvestmentLoans');

        // Fetch all investment loans (you can add pagination or filtering later)
        $investmentLoans = $this->InvestmentLoans->find('all');

        // Pass data to the view
        $this->set(compact('investmentLoans'));
    }

}
