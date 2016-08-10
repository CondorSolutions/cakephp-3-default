<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use App\Model\Entity\TerminalDetail;
use App\Util\TerminalUtil;


class TerminalsController extends AppController
{
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow('fetchData');
	}
	
	
	public function index()
	{
		$terminalUtil = new TerminalUtil();
		$terminals = $terminalUtil->getTerminals();
		
		$terminalDetailObj = new TerminalDetail();
		foreach ($terminals as $key =>$terminal){
			
			
			$terminalDetailsTable = TableRegistry::get('TerminalDetails');
			$query = $terminalDetailsTable->find('all')
				->where(['TerminalDetails.id'=>$terminal['Terminal']['id']]);
			$terminalDetail =  $query->first();
			if(!$terminalDetail){
				$terminalDetail = $terminalUtil->addDefaultTerminalDetail($terminal['Terminal']['id']);
			}
			$terminals[$key]['Terminal']['TerminalDetail']['pin'] = $terminalDetail->pin;
			$terminals[$key]['Terminal']['TerminalDetail']['version'] = $terminalDetail->version;
		}
		//$this->log($terminals);
		$this->set('terminals', $terminals);
	}
	
	public function changePIN(){//ajax
		$this->loadModel('TerminalDetails');
		
		$newPIN = $this->request->data['new_pin'];
		$ids_str = "";
		foreach ($this->request->data['terminal_ids'] as $terminal_id){
			$terminalDetail = $this->TerminalDetails->get($terminal_id);
			$terminalDetail->pin = $newPIN;
			$this->TerminalDetails->save($terminalDetail);
		}
		$this->Flash->success(__('Terminal(s) PIN changed.'));
		/* $locationsUsersTable = TableRegistry::get('LocationsUsers');
		$locationsUsersTable->deleteAll(['location_id'=>$this->request->data['location_id'],'user_id'=>$this->request->data['user_id']]);
		$locationsUsersQuery = $locationsUsersTable->find('all');
		$this->set('data',  json_encode( $locationsUsersQuery->all())); */
	}
	
	/* public function sendHeartBeat(){
		RELOCATED to SynchController
	} */
}