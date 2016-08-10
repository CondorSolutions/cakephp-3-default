<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Location;
use Cake\Event\Event;

class StandardDayOffsController extends AppController
{
	public function index()
	{
		//main list found in admin controller
		return $this->redirect(['controller' => 'admin', 'action' => 'index']);
	}
	
	public function add()
	{
		$this->loadModel('StandardDayOffs');
		$standardDayOff = $this->StandardDayOffs->newEntity();
		
		if ($this->request->is('post')) {
			$date =date($this->request->data['date']);
			$standardDayOff = $this->StandardDayOffs->patchEntity($standardDayOff, $this->request->data);
			$standardDayOff->date = $date;
			if ($this->StandardDayOffs->save($standardDayOff)) {
				$this->Flash->success(__('New Standard Day Off has been saved.'));
				return $this->redirect(['action' => 'index']);//refer to index()
			}
		}
		$this->set(compact('standardDayOff'));
		$this->set('_serialize', ['standardDayOff']);
	}
	
	public function edit($id = null){
		$standardDayOff = $this->StandardDayOffs->get($id);
		
		if ($this->request->is(['patch', 'post', 'put'])) {
			$date =date($this->request->data['date']);
			$standardDayOff = $this->StandardDayOffs->patchEntity($standardDayOff, $this->request->data);
			$standardDayOff->date = $date;
			if ($this->StandardDayOffs->save($standardDayOff)) {
				$this->Flash->success(__('The Standard Day Off has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The Standard Day Off could not be saved. Please, try again.'));
			}
		}
		$this->set(compact('standardDayOff'));
		$this->set('_serialize', ['standardDayOff']);
	}
	
	public function delete($id = null){
		//$this->request->allowMethod(['post', 'delete']);
		$standardDayOff = $this->StandardDayOffs->get($id);
		if ($this->StandardDayOffs->delete($standardDayOff)) {
			$this->Flash->success(__('The Standard Day Off has been deleted.'));
		} else {
			$this->Flash->error(__('The Standard Day Off could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}
}