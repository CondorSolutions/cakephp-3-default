<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\I18n\Time;
use App\Util\OptionsUtil;

class SynchController extends AppController
{
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow(['fetchTerminalsManagerURL','fetchData','uploadFingerprints', 'uploadPunchLogs','sendHeartbeat']);
	}
	public function sendHeartbeat(){
		$terminal_id = $this->request->data['terminal_id'];
		$version =  $this->request->data['version'];
		//$this->log("fetching data for: " . $terminal_id);
		$heartbeatData = array();
		
		$this->loadModel('TerminalDetails');
		$query = $this->TerminalDetails->find('all')
			->where(['id'=>$terminal_id]);
		$terminalsDetails =  $query->first();
		//save sent info
		$terminalsDetails->version = $version;
		$this->TerminalDetails->save($terminalsDetails);
		
		$heartbeatData['terminal_pin'] = $terminalsDetails->pin;
		
		
		$this->RequestHandler->renderAs($this, 'json');
		//$this->log( json_encode($heartbeatData));
		$this->set('heartbeat_data', json_encode($heartbeatData));
		$this->set('_serialize', true);
	}
	
	public function fetchData(){
		$this->RequestHandler->renderAs($this, 'json');
	
		$this->log("fetching data for: " . $this->request->data['terminal_id']);
		
		//$terminal_id = 1040;
		$terminal_id = $this->request->data['terminal_id'];
		 
		$this->loadModel('TerminalsLocations');
		$terminalsLocationsQuery = $this->TerminalsLocations->find('all')
		->where(['terminal_id'=>$terminal_id]);
		$terminalsLocations =  $terminalsLocationsQuery->first();
		 
		$this->loadModel('LocationsUsers');
		$locationsUsersQuery = $this->LocationsUsers->find('all')
		->where(['location_id'=>$terminalsLocations['location_id']]);
		$locationsUsers =  $locationsUsersQuery->all();
		 
		$this->loadModel('Users');
		$this->loadModel('Persons');
	
		$data = array();
		$this->loadModel('Departments');
		$this->loadModel('Positions');
		$this->loadModel('Agencies');
		foreach ($locationsUsers as $locationsUser){
			$usersQuery = $this->Users->find('all')
			->where(['id'=>$locationsUser['user_id']]);
			$user =  $usersQuery->first();
	
			$personsQuery = $this->Persons->find('all')
			->where(['user_id'=>$locationsUser['user_id']]);
			$person =  $personsQuery->first();
	
	
			$user['person_id'] = $person['id'];
			$user['first_name'] = $person['first_name'];
			$user['last_name'] = $person['last_name'];
			$user['photo'] = $person['photo'];
			
			$departmentsQuery = $this->Departments->find('all')
				->where(['Departments.id'=>$user->Person->department_id]);
			$department = $departmentsQuery->first();
			$user['department'] = $department['name'];
			
			$positionsQuery = $this->Positions->find('all')
			->where(['Positions.id'=>$user->Person->position_id]);
			$position = $positionsQuery->first();
			$user['position'] = $position['name'];
			
			$agenciesQuery = $this->Agencies->find('all')
			->where(['Agencies.id'=>$user->Person->agency_id]);
			$agency = $agenciesQuery->first();
			$user['agency'] = $agency['name'];
			
			
			//$user['department'] = 
			
			//$data['users'][$locationsUser['user_id']]['user'] = $user;
			array_push($data,$user);
	
		}
		//$this->log( json_encode($data));
	
		$this->set('data', json_encode($data));
		$this->set('_serialize', true);
	}
	
	public function fetchTerminalsManagerURL(){
		$this->RequestHandler->renderAs($this, 'json');
		$data  =array();
		$this->set('data',OptionsUtil::getOption(OptionsUtil::TERMINALS_MANAGER_URL)->value1);
		$this->set('_serialize', true);
	}

	public function uploadFingerprints(){
		
		if ($_FILES["file"]["error"] > 0){
			$this->log("File upload error:");
			$this->log(" error code: " . $_FILES["file"]["error"]);
			$this->log(" refer to this site for error description: http://php.net/manual/en/features.file-upload.errors.php");
		}else{
			$filename = trim(strtoupper($_FILES["file"]["name"]));
			if(move_uploaded_file($_FILES["file"]["tmp_name"],OptionsUtil::getOption(OptionsUtil::FILES_PATH)->value1  .DS. 'Persons' .DS.  'fingerprints' .DS. $filename)){
			}else{
				$this->log("failed move_uploaded_file");
			}
		}
		
		$this->RequestHandler->renderAs($this, 'json');
		$this->set('data', json_encode("hello!"));
		$this->set('_serialize', true);
	}
	
	public function uploadPunchLogs(){
		$this->RequestHandler->renderAs($this, 'json');
		$this->loadModel('PunchLogs');
		
		$rawPunchLogs = json_decode($this->request->data['punchLogs']);
		$terminal_id = $this->request->data['terminal_id'];
		$saved = array();
		foreach ($rawPunchLogs as $rawPunchLog){
			$punchLog = $this->PunchLogs->newEntity();
			//$punchLog->terminal_id = $terminal_id;
			$punchLog->terminal_id = $rawPunchLog->TerminalID;
			$punchLog->ref_id = $rawPunchLog->ID;
			$punchLog->is_log_in = $rawPunchLog->IsLogIn;
			$punchLog->user_id = $rawPunchLog->UserID;
			//$punchLog->log_created = $rawPunchLog->Created;
			$punchLog->log_created = $this->decrypt($rawPunchLog->Hash);
			$punchLog->generic_remarks = $rawPunchLog->GenericRemarks;
			$punchLog->custom_remarks = $rawPunchLog->CustomRemarks;
			
			/* $punchLogsQuery = $this->PunchLogs->find('all')
			->where(['PunchLogs.terminal_id'=>$terminal_id, 'PunchLogs.user_id'=>$rawPunchLog->UserID, 'PunchLogs.ref_id'=>$rawPunchLog->ID]); */
			
			//Assume that punch log is unique based on user_id and log_ceated
			$t = new Time($rawPunchLog->Created);
			$punchLogsQuery = $this->PunchLogs->find('all')
			->where(['PunchLogs.user_id'=>$rawPunchLog->UserID, 'PunchLogs.log_created'=>$t]);
			
			$existingPunchLog = $punchLogsQuery->first();
			if(!$existingPunchLog){
				if ($this->PunchLogs->save($punchLog)) {
					array_push($saved,$punchLog->ref_id);
				}
			}
			else{
				
				$this->log("Punch Log already exists: ");
				/* $this->log($existingPunchLog->log_created->i18nFormat('yyyy-MM-dd HH:mm:ss'));
				$t = new Time($rawPunchLog->Created);
				$this->log($t->i18nFormat('yyyy-MM-dd HH:mm:ss')); */
				array_push($saved,$punchLog->ref_id);
			}
		}
		
		$this->set('data', json_encode($saved));
		$this->set('_serialize', true);
	}
}