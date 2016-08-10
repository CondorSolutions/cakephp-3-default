<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Location;
use Cake\Event\Event;

class StandardShiftsController extends AppController
{
	public function index()
	{
		//main list found in admin controller
		return $this->redirect(['controller' => 'admin', 'action' => 'index']);
	}
	
	public function add()
	{
		$this->loadModel('StandardShifts');
		$standardShift = $this->StandardShifts->newEntity();
		if ($this->request->is('post')) {
			$standardShift = $this->StandardShifts->patchEntity($standardShift, $this->request->data);
			if ($this->StandardShifts->save($standardShift)) {
				$this->Flash->success(__('New Standard Shift has been saved.'));
				return $this->redirect(['action' => 'index']);//refer to index()
			}
		}
		$this->set(compact('standardShift'));
		$this->set('_serialize', ['standardShift']);
	}
	
	public function edit($id = null){
		$standardShift = $this->StandardShifts->get($id);
		
		if ($this->request->is(['patch', 'post', 'put'])) {
			$standardShift = $this->StandardShifts->patchEntity($standardShift, $this->request->data);
			if ($this->StandardShifts->save($standardShift)) {
				$this->Flash->success(__('The Standard Shift has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The Standard Shift could not be saved. Please, try again.'));
			}
		}
		$this->set(compact('standardShift'));
		$this->set('_serialize', ['standardShift']);
	}
	
	public function delete($id = null){
		//$this->request->allowMethod(['post', 'delete']);
		$standardShift = $this->StandardShifts->get($id);
		if ($this->StandardShifts->delete($standardShift)) {
			$this->Flash->success(__('The Standard Shift has been deleted.'));
		} else {
			$this->Flash->error(__('The Standard Shift could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}
}