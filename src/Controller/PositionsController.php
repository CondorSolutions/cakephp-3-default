<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Position;
/**
 * Positions Controller
 *
 * @property \App\Model\Table\PositionsTable $Positions
 */
class PositionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Departments']
        ];
        $positions = $this->paginate($this->Positions);

        $this->set(compact('positions'));
        $this->set('_serialize', ['positions']);
    }

    public function ajaxFindByDepartment(){
    	$positionsQuery = $this->Positions->findByDepartmentId($this->request->data['department_id']);
    	$this->log($positionsQuery->all());
    	$positions = $positionsQuery->all();
    	$this->set(compact('positions'));
    	$this->set('_serialize', ['positions']);
    }
    /**
     * View method
     *
     * @param string|null $id Position id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $position = $this->Positions->get($id, [
            'contain' => ['Departments']
        ]);

        $this->set('position', $position);
        $this->set('_serialize', ['position']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $position = $this->Positions->newEntity();
        if ($this->request->is('post')) {
            $position = $this->Positions->patchEntity($position, $this->request->data);
            if ($this->Positions->save($position)) {
                $this->Flash->success(__('The position has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The position could not be saved. Please, try again.'));
            }
        }
        $departments = $this->Positions->Departments->find('list', ['limit' => 200]);
        $this->set(compact('position', 'departments'));
        $this->set('_serialize', ['position']);
    }
    
    public function addAjax(){
    	if ($this->request->is('post')) {
    		$this->log($this->request->data['name']);
    		//$department = $this->Departments->patchEntity($department, $this->request->data);
    		$position = new Position();
    		$position->department_id =$this->request->data['department_id'];
    		$position->name =$this->request->data['name'];
    		if ($this->Positions->save($position)) {
    			$this->set('position', json_encode($position));
    		} else {
    			$this->set('error', 'The position could not be saved. Please, try again.');
    		}
    	}
    	 
    }

    /**
     * Edit method
     *
     * @param string|null $id Position id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $position = $this->Positions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $position = $this->Positions->patchEntity($position, $this->request->data);
            if ($this->Positions->save($position)) {
                $this->Flash->success(__('The position has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The position could not be saved. Please, try again.'));
            }
        }
        $departments = $this->Positions->Departments->find('list', ['limit' => 200]);
        $this->set(compact('position', 'departments'));
        $this->set('_serialize', ['position']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Position id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $position = $this->Positions->get($id);
        if ($this->Positions->delete($position)) {
            $this->Flash->success(__('The position has been deleted.'));
        } else {
            $this->Flash->error(__('The position could not be deleted. Please, try again.'));
        }
       // return $this->redirect(['action' => 'index']);
        return $this->redirect(['controller' => 'admin', 'action' => 'index']);
    }
}
