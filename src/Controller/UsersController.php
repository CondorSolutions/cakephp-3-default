<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Service\ReferenceService;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Address;
use App\Model\Entity\Person;
use Cake\Routing\Router;
use App\Util\OptionsUtil;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
	public function initialize()
	{
		parent::initialize();
	}
	/**
     * beforeFilter method
     * @param  Event  $event
     * @return void
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
       $this->Auth->allow(['login', 'logout', 'activate', 'resetpw','resend']);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
    	$users = $this->paginate($this->Users);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
        
        $locationsTable = TableRegistry::get('Locations');
        $locationsQuery = $locationsTable->find('all');
        $this->set('locations',  json_encode($locationsQuery->all()));
        
        $locationsUsersTable = TableRegistry::get('LocationsUsers');
        $locationsUsersQuery = $locationsUsersTable->find('all');
        $this->set('locationsUsers',  json_encode($locationsUsersQuery->all()));
    }
    
    public function assignToLocations(){
    	
    	$locationsUsersTable = TableRegistry::get('LocationsUsers');
    	foreach ($this->request->data['user_id'] as $user_id){
    		foreach ($this->request->data['location_id'] as $location_id){
    			$locationsUser = $locationsUsersTable->newEntity();
    			$locationsUser->user_id = $user_id;
    			$locationsUser->location_id = $location_id;
    			$locationsUsersTable->save($locationsUser);
    		}
    	}
    	$locationsUsersQuery = $locationsUsersTable->find('all');
    	$this->set('data',  json_encode( $locationsUsersQuery->all()));
    }

    public function removeFromLocation(){
    	$locationsUsersTable = TableRegistry::get('LocationsUsers');
    	$locationsUsersTable->deleteAll(['location_id'=>$this->request->data['location_id'],'user_id'=>$this->request->data['user_id']]);
    	$locationsUsersQuery = $locationsUsersTable->find('all');
    	$this->set('data',  json_encode( $locationsUsersQuery->all()));
    }
    
    public function getPlaces(){//ajax
    	$address = new Address();
    	$data = $address->getRefChildred($this->request->data['type'], $this->request->data['parent_code']);
    	$this->set(compact('data'));
    	$this->set('_serialize', 'data');
    }
    
    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
    	$user = $this->Users->get($id, [
    			'contain' => ['Roles']
    			]);
    	
    	$this->set('user', $user);
    	$this->set('_serialize', ['user']);
    }
    
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $personId = $user->person->id;
       
      	if ($this->Users->delete($user)) {
      		$this->loadModel('Addresses');
      		$this->Addresses->deleteAll(['entity_id'=>$personId, 'entity_type' => 'Person']);
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        
        
        return $this->redirect(['action' => 'index']);
    }
	
	    /**
     * login method
     *
     * @return void Redirects.
     */
	 
    public function login()
    {
        if ($this->request->is('post')) {
        	//check if activated
        	$users = $this->Users->findByEmail($this->request->data['email']);
        	
        	$user = $users->first();
        	
        	if($user){
        		if($user->active == 1){
        			$user = $this->Auth->identify();
        			
        			if ($user) {
        				$this->Auth->setUser($user);
        				$authUser = $this->Auth->user();
        				$this->log($authUser['roles'][0]['name']);
        				if($authUser['roles'][0]['name'] == 'User'){
        					$this->redirect(['action' => 'profile']);
        				}
        				else{
        					return $this->redirect($this->Auth->redirectUrl());
        				}
        				
        			} else {
        				$this->Flash->error(
        						__('Username or password is incorrect'),
        						'default',
        						[],
        						'auth'
        				);
        			}
        		}
        		else
        		{
        			$this->Flash->error('Account not yet activated. Please check your email for activation procedure.');
        			$this->set('showResendActivation', true);
        		}
        	}
        	else{
        		$this->Flash->error('User does not exist');
        	}
            
        }
        $this->viewBuilder()->layout('login_page');
    }

    public function resend($type = null){
    	if ($this->request->is('post')) {
    		$users = $this->Users->findByEmail($this->request->data['email']);
    		$user = $users->first();
    		if($user){
    			if($type=='activation'){
    				$this->_sendNewUserNotification($user);
    				$this->Flash->error('Activation link sent to ' . $this->request->data['email']);
    			}
    			else
    			{
    				if($user->active == 0){
    					//$this->set('showResendActivation', true); does not work when redirected
    					$this->Flash->error($this->request->data['email'] . ' has not yet been activated.');
    					return $this->redirect(['action' => 'login']);
    				}
    				else{
    					$this->_sendResetPassword($user);
    					$this->Flash->success('Reset password link sent to ' . $this->request->data['email']);
    					return $this->redirect(['action' => 'login']);
    				}
    			}
    		}
    		else{
    			$this->Flash->error($this->request->data['email'] . ' does not exist');
    		}
    	}
    	$this->set('type', $type);
    	$this->viewBuilder()->layout('login_page');
    }
    
    /**
     * logout method
     * @return void redirect to login.
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    
    public function dummyContent()
    {
    	
    }
    
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    	$user = $this->Users->newEntity();
    	if ($this->request->is('post')) {
    		if(isset($this->request->data['auto-activate'] ))
    			$this->request->data['active'] = 1;
    		$this->request->data['status'] = 'active';
    		$user = $this->Users->patchEntity($user, $this->request->data);
    		if ($this->Users->save($user)) {
    			//person
    			$personsTable = TableRegistry::get('Persons');
    			$person = $personsTable->newEntity();
    			$person->person_type = 'User';
    			$person->user_id = $user->id;
    			$person->last_name = $this->request->data['last_name'];
    			$person->first_name = $this->request->data['first_name'];
    			$person->middle_name = $this->request->data['middle_name'];
    			
    			$personsTable->save($person);
    			if($this->request->data['photo']['name']==""){
    				//$person->photo = '';
    			}else{
    				$person->photo = $this->request->data['photo'];
    			}
    			$personsTable->save($person);
    			//role
    			$rolesUsersTable = TableRegistry::get('RolesUsers');
    			$rolesUser = $rolesUsersTable->newEntity();
    			$rolesUser->role_id = $this->request->data['role'];
    			$rolesUser->user_id = $user['id'];
    			$rolesUsersTable->save($rolesUser);
    			$this->Flash->success(__('The user has been saved.'));
    			if(!isset($this->request->data['auto-activate'] ))
    				$this->_sendNewUserNotification($user);
    			return $this->redirect(['action' => 'index']);
    		} else {
    			$this->Flash->error(__('The user could not be saved. Please, try again.'));
    		}
    	}
    	$rolesAll = $this->Users->Roles->find('all', ['limit' => 200]);
    	$this->set('rolesAll',$rolesAll);
    	$this->set(compact('user'));
    	$this->set('_serialize', ['user']);
    }
    
    public function activate($user_id=null, $activation_id=null){
    	$user = $this->Users->get($user_id);
    	$this->set('user', $user);
    	if ($this->request->is(['patch', 'post', 'put'])) {
    		$activation_id = $this->request->data['activation_id'];
    		if($this->request->data['password']==$this->request->data['confirm_password']){
    			$user->password = $this->request->data['password'];
    			$user->active = 1;
    			$this->Users->save($user);
    			$userActivationsTable = TableRegistry::get('UserActivations');
    			$userActivationsTable->deleteAll(['user_id'=>$user_id, 'type' =>'activation']);
    			$this->Flash->success("Account activated. You may now login.");
    			return $this->redirect(['action' => 'login']);
    		}
    		else
    		{
    			$this->Flash->error(__('Confirm password mismatch.'));
    		}
    		$this->set('activation_id', $activation_id);
    	}
    	else
    	{
    		if($user->active == 0){
    			$userActivationsTable = TableRegistry::get('UserActivations');
    			$userActivation = $userActivationsTable->get($activation_id);
    			if($userActivation->type == 'activation'){//validates if new user activation
    				$this->set('activation_id', $userActivation->id);
    			}
    			else {
    				return $this->redirect(['action' => 'login']);
    			}
    		}
    		else
    		{
    			$this->Flash->error(__('Your account has already been activated.'));
    			return $this->redirect(['action' => 'login']);
    		}
    	}
    	//$this->viewBuilder()->layout('default_public');
    	$this->viewBuilder()->layout('login_page');
    }

    private function _sendResetPassword($user){
    	$unique_id = uniqid();
    	$userActivationsTable = TableRegistry::get('UserActivations');
    	$userActivation = $userActivationsTable->newEntity();
    	$userActivation->id = $unique_id;
    	$userActivation->user_id = $user->id;
    	$userActivation->type = 'reset_password';
    	$userActivationsTable->save($userActivation);
    	
    	$this->_configTransport();
    	
    	$email = new Email('default');
    	//$this->log($email);
    	$email->viewVars([
    			'activation_id' => $unique_id,
    			'user' => $user,
    			'appHome' => Router::url('/', true),
    			]);
    	 
    	$result = $email->from([OptionsUtil::getOption(OptionsUtil::NO_REPLY_ADDRESS)->value1 => OptionsUtil::getOption(OptionsUtil::APP_NAME)->value1])
    	->template('reset_password','default')
    	->emailFormat('html')
    	->to($user->email)
    	->subject('Reset Password')
    	->send('My message');
    }
    
    private function _configTransport(){
    	Email::dropTransport('default');
    	 
    	Email::configTransport('default', [
		    'host' => OptionsUtil::getOption(OptionsUtil:: MAIL_HOST)->value1,
		    'port' => OptionsUtil::getOption(OptionsUtil:: MAIL_PORT)->value1,
		    'username' => OptionsUtil::getOption(OptionsUtil:: MAIL_USERNAME)->value1,
		    'password' => OptionsUtil::getOption(OptionsUtil:: MAIL_PASSWORD)->value1,
		    'className' => 'Smtp'
		]);
    }
    public function resetpw($user_id=null, $activation_id=null){
    	$user = $this->Users->get($user_id);
    	$this->set('user', $user);
    	if ($this->request->is(['patch', 'post', 'put'])) {
    		$activation_id = $this->request->data['activation_id'];
    		$this->set('activation_id', $activation_id);
    		$this->log($activation_id);
    		if($this->request->data['password']==$this->request->data['confirm_password']){
    			$user->password = $this->request->data['password'];
    			$this->Users->save($user);
    			$userActivationsTable = TableRegistry::get('UserActivations');
    			$userActivationsTable->deleteAll(['user_id'=>$user_id, 'type' =>'reset_password']);
    			$this->Flash->success("Password updated. You may now login.");
    			return $this->redirect(['action' => 'login']);
    		}
    		else
    		{
    			$this->Flash->error(__('Confirm password mismatch.'));
    		}
    		
    	}
    	else
    	{
    		$this->set('activation_id', $activation_id);
    	}
    	
    	$this->viewBuilder()->layout('login_page');
    }
    
    private function _sendNewUserNotification($user){
    	$unique_id = uniqid();
    	$userActivationsTable = TableRegistry::get('UserActivations');
    	$userActivation = $userActivationsTable->newEntity();
    	$userActivation->id = $unique_id;
    	$userActivation->user_id = $user->id;
    	$userActivation->type = 'activation';
    	$userActivationsTable->save($userActivation);
    	
    	$email = new Email('default');
    	$email->viewVars([
    			'activation_id' => $unique_id, 
    			'user' => $user,
    			'appHome' => Router::url('/', true),
		]);
    	
    	$result = $email->from([OptionsUtil::getOption(OptionsUtil::NO_REPLY_ADDRESS)->value1 => OptionsUtil::getOption(OptionsUtil::APP_NAME)->value1])
	    	->template('account_activation','default')
	    	->emailFormat('html')
	    	->to($user->email)
	    	->subject('Account Activation')
	    	->send('My message'); 
    }
    
    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    	$user = $this->Users->get($id, [
    			'contain' => ['Roles']
    			]);
    	
    	$rolesAll = $this->Users->Roles->find('all', ['limit' => 200]);
    	$this->set('rolesAll',$rolesAll);
    	if ($this->request->is(['patch', 'post', 'put'])) {
    		$user = $this->Users->patchEntity($user, $this->request->data);
    		if ($this->Users->save($user)) {
    			$personTable = TableRegistry::get('Persons');
    			$query = $personTable->find('all')
    				->where(['Persons.person_type'=>'User','Persons.user_id'=>$user->id]);
    			$person =  $query->first();
    			$person->first_name = $this->request->data['first_name'];
    			$person->middle_name = $this->request->data['middle_name'];
    			$person->last_name = $this->request->data['last_name'];
    			if($this->request->data['photo']['name']==""){
    				//$person->photo = '';
    			}else{
    				$person->photo = $this->request->data['photo'];
    			}
    			if($personTable->save($person)){
    				$this->Flash->success(__('The user has been saved.'));
    				//return $this->redirect(['action' => 'index']);
    				return $this->redirect(['action' => 'edit/' . $id]);
    			}
    		} else {
    			$this->Flash->error(__('The user could not be saved. Please, try again.'));
    		}
    	}
    
    	$roles = $this->Users->Roles->find('list', ['limit' => 200]);
    	$this->set(compact('user', 'roles'));
    	$this->set('_serialize', ['user']);
    
    	$refRegionsTable = TableRegistry::get('RefRegions');
    	$refRegionsQuery = $refRegionsTable->find('all');
    	$this->set('refRegions',json_encode($refRegionsQuery->all()));
    
    	$addressTable = TableRegistry::get('Addresses');
    	$addresses = $addressTable->find('all')
    	->where(['entity_type'=>'Person','entity_id'=>$user->person->id]);
    	$this->set('addresses',json_encode($addresses->all()));
    	
    	//Employment info
    	$this->loadModel('Departments');
    	$departmentsQuery = $this->Departments->find('all');
    	$this->set('departments', $departmentsQuery->all());
    	
    	$this->loadModel('Positions');
    	$positionsQuery = $this->Positions->find('all');
    	$this->set('positions', $positionsQuery->all());
    	
    	$this->loadModel('Agencies');
    	$agenciesQuery = $this->Agencies->find('all');
    	$this->set('agencies', $agenciesQuery->all());
    	
    }
    
    public function saveContactInfo(){
    	$personTable = TableRegistry::get('Persons');
    	$query = $personTable->find('all')
    		->where(['Persons.person_type'=>'User','Persons.user_id'=>$this->request->data['user_id']]);
    	$person =  $query->first();
    	
    	$person->mobile = $this->request->data['mobile'];
    	$person->landline = $this->request->data['landline'];
    	$person->personal_email = $this->request->data['personal_email'];
    	$person = $personTable->save($person);
    	
    	$addressTable = TableRegistry::get('Addresses');
    	$addressTable->deleteAll(['entity_type'=>'Person','entity_id'=>$person->id]);
    	
    	for($i = 0; $i <$this->request->data['address_count'];$i++ ){
    		if(isset($this->request->data['address_name_'.$i])){
    			$addressTable = TableRegistry::get('Addresses');
    			$address = $addressTable->newEntity();
    			$address->entity_type = 'Person';
    			$address->entity_id = $person->id;
    			$address->display_index = $i;
    			$address->description = $this->request->data['address_name_'.$i];
    			$address->ref_region_code = $this->request->data['ref_region_'.$i];
    			$address->ref_province_code = $this->request->data['ref_province_'.$i];
    			$address->ref_citymun_code = $this->request->data['ref_citymun_'.$i];
    			$address->ref_brgy_code = $this->request->data['ref_brgy_'.$i];
    			$address->line_1 = $this->request->data['line_1_'.$i];
    			$address->line_2 = $this->request->data['line_2_'.$i];
    			 
    			$addressTable->save($address);
    		}
    	}
    	return $this->redirect(['action' => 'edit/' . $this->request->data['user_id']]);
    }
    
    public function savePersonalInfo(){
    	$personTable = TableRegistry::get('Persons');
    	$query = $personTable->find('all')
    	->where(['Persons.person_type'=>'User','Persons.user_id'=>$this->request->data['user_id']]);
    	$person =  $query->first();
    	 
    	if( isset($this->request->data['gender'])){
    		$person->gender = $this->request->data['gender'];
    	}
    	$person->dob = $this->request->data['dob'];
    	$person->birth_place = $this->request->data['birth_place'];
    	$person->citizenship = $this->request->data['citizenship'];
    	$person->tin = $this->request->data['tin'];
    	$person->sss = $this->request->data['sss'];
    	$person->philhealth = $this->request->data['philhealth'];
    	$person->pagibig = $this->request->data['pagibig'];
    	$person = $personTable->save($person);
    	
    	return $this->redirect(['action' => 'edit/' . $this->request->data['user_id']]);
    }
    
    public function saveEmploymentInfo(){
    	$personTable = TableRegistry::get('Persons');
    	$query = $personTable->find('all')
    		->where(['Persons.person_type'=>'User','Persons.user_id'=>$this->request->data['user_id']]);
    	$person =  $query->first();
    	$person->department_id = $this->request->data['department_id'];
    	$person->position_id = $this->request->data['position_id'];
    	$person->agency_id = $this->request->data['agency_id'];
    	$person = $personTable->save($person);
    	$this->Flash->success(__('The user has been saved.'));
    	return $this->redirect(['action' => 'edit/' . $this->request->data['user_id']]);
    }
    
    //---CALENDAR---
    public function calendar($id = null){
    	$user = $this->Users->get($id, [
    			'contain' => ['Roles']
    			]);
    	$this->set('user', $user);
    	
    	$this->loadModel('StandardShifts');
    	$standardShiftsQuery = $this->StandardShifts->find('all');
    	$this->set('standardShifts', json_encode($standardShiftsQuery->all()));
    	
    	$this->loadModel('UsersStandardShifts');
    	$usersStandardShiftsQuery = $this->UsersStandardShifts->find('all')
    		->where(['UsersStandardShifts.user_id'=>$id]);
    	$this->set('usersStandardShifts', json_encode($usersStandardShiftsQuery->all()));
    	
    	$this->loadModel('StandardDayOffs');
    	$standardDayOffsQuery = $this->StandardDayOffs->find('all');
    	$this->set('standardDayOffs', json_encode($standardDayOffsQuery->all()));
    	
    	$this->loadModel('UsersStandardDayOffs');
    	$usersStandardDayOffsQuery = $this->UsersStandardDayOffs->find('all')
    		->where(['UsersStandardDayOffs.user_id'=>$id])
    		->contain(['StandardDayOffs']);;
    	$this->set('usersStandardDayOffs', json_encode($usersStandardDayOffsQuery->all()));
    	
    	$this->loadModel('Shifts');
    	$shiftsQuery = $this->Shifts->find('all')
    		->where(['Shifts.user_id'=>$id, 'Shifts.date is'=>null])
    		->contain(['Repeats']);
    	$this->set('userRepeatedShifts', json_encode($shiftsQuery->all()));
    	
    	$this->loadModel('DayOffs');
    	$dayOffsQuery = $this->DayOffs->find('all')
	    	->where(['DayOffs.user_id'=>$id, 'DayOffs.date is'=>null])
	    	->contain(['Repeats']);
    	$this->set('userRepeatedDayOffs', json_encode($dayOffsQuery->all()));
    	
    	$date = date("Y-m-d H:i:s");
    	$number = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
    	$shiftsQuery = $this->Shifts->find('all')
    		->where(['Shifts.user_id'=>$id, 'Shifts.date >='=>date('Y') . '-' . date('n') . '-' . '1', 'Shifts.date <='=>date('Y') . '-' . date('n') . '-' . $number]);
    	$this->set('userSpecialShifts', json_encode($shiftsQuery->all()));
    	
    	$dayOffsQuery = $this->DayOffs->find('all')
    		->where(['DayOffs.user_id'=>$id, 'DayOffs.date >='=>date('Y') . '-' . date('n') . '-' . '1', 'DayOffs.date <='=>date('Y') . '-' . date('n') . '-' . $number]);
    	$this->set('userSpecialDayOffs', json_encode($dayOffsQuery->all()));
    }
    
    public function addStandardShifts(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$this->loadModel('UsersStandardShifts');
    	$usersStandardShift = $this->UsersStandardShifts->newEntity();
    	$usersStandardShift->user_id =  $this->request->data['user_id'];
    	$usersStandardShift->	standard_shift_id =  $this->request->data['standard_shift_id'];
    	$this->UsersStandardShifts->save($usersStandardShift);
    	
    	$usersStandardShiftsQuery = $this->UsersStandardShifts->find('all')
    		->where(['UsersStandardShifts.user_id'=>$this->request->data['user_id']]);
    	$this->set('usersStandardShifts', json_encode($usersStandardShiftsQuery->all()));
    }
    
    public function removeStandardShift(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$this->loadModel('UsersStandardShifts');
    	$this->UsersStandardShifts->deleteAll(['user_id'=>$this->request->data['user_id'],'standard_shift_id'=>$this->request->data['standard_shift_id']]);
    	$usersStandardShiftsQuery = $this->UsersStandardShifts->find('all')
    		->where(['UsersStandardShifts.user_id'=>$this->request->data['user_id']]);
    	$this->set('usersStandardShifts', json_encode($usersStandardShiftsQuery->all()));
    }
    
    public function addStandardDayOffs(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$this->loadModel('UsersStandardDayOffs');
    	$usersStandardDayOff = $this->UsersStandardDayOffs->newEntity();
    	$usersStandardDayOff->user_id =  $this->request->data['user_id'];
    	$usersStandardDayOff->	standard_day_off_id =  $this->request->data['standard_day_off_id'];
    	$this->UsersStandardDayOffs->save($usersStandardDayOff);
    	 
    	$usersStandardDayOffsQuery = $this->UsersStandardDayOffs->find('all')
    	->where(['UsersStandardDayOffs.user_id'=>$this->request->data['user_id']]);
    	$this->set('usersStandardDayOffs', json_encode($usersStandardDayOffsQuery->all()));
    }
    
    public function removeStandardDayOff(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$this->loadModel('UsersStandardDayOffs');
    	$this->UsersStandardDayOffs->deleteAll(['user_id'=>$this->request->data['user_id'],'standard_day_off_id'=>$this->request->data['standard_day_off_id']]);
    	 
    	$usersStandardDayOffsQuery = $this->UsersStandardDayOffs->find('all')
    	->where(['UsersStandardDayOffs.user_id'=>$this->request->data['user_id']]);
    	$this->set('usersStandardDayOffs', json_encode($usersStandardDayOffsQuery->all()));
    }
    
    public function addCustomRepeatingShift(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	
    	$this->loadModel('Shifts');
    	$shift = $this->Shifts->newEntity();
    	$shift->user_id =  $this->request->data['user_id'];
    	$shift->name =  $this->request->data['shift_name'];
    	$shift->start =  date("G:i", strtotime(str_replace(' ', '', $this->request->data['shift_start'])));
    	$shift->end = date("G:i", strtotime(str_replace(' ', '',  $this->request->data['shift_end'])));
    	$shift = $this->Shifts->save($shift);
    	
    	$this->loadModel('Repeats');
    	$repeat = $this->Repeats->newEntity();
    	$repeat->entity_type = 'Shifts';
    	$repeat->entity_id = $shift->id;
    	$repeat->every =  $this->request->data['every'];
    	$repeat->every_count =  $this->request->data['every_count'];
    	$repeat->start =  $this->request->data['shift_date_start'];
    	$repeat->end =  $this->request->data['shift_date_end'];
    	$repeat->day_1 =  ($this->request->data['day_1'] == 'true') ? true : false;
    	$repeat->day_2 =  ($this->request->data['day_2'] == 'true') ? true : false;
    	$repeat->day_3 = ($this->request->data['day_3'] == 'true') ? true : false;
    	$repeat->day_4= ($this->request->data['day_4'] == 'true') ? true : false;
    	$repeat->day_5 = ($this->request->data['day_5'] == 'true') ? true : false;
    	$repeat->day_6 =  ($this->request->data['day_6'] == 'true') ? true : false;
    	$repeat->day_7 =  ($this->request->data['day_7'] == 'true') ? true : false;
    	$repeat = $this->Repeats->save($repeat);
    	
    	$this->loadModel('Shifts');
    	$shiftsQuery = $this->Shifts->find('all')
    		->where(['Shifts.user_id'=>$this->request->data['user_id'], 'Shifts.date is'=>null])
    		->contain(['Repeats']);
    	$this->set('userRepeatedShifts', json_encode($shiftsQuery->all()));
    }
    
    public function addCustomRepeatingDayOff(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$this->loadModel('DayOffs');
    	$dayOff = $this->DayOffs->newEntity();
    	$dayOff->user_id =  $this->request->data['user_id'];
    	$dayOff->name =  $this->request->data['day_off_name'];
    	$dayOff = $this->DayOffs->save($dayOff);
    	
    	$this->loadModel('Repeats');
    	$repeat = $this->Repeats->newEntity();
    	$repeat->entity_type = 'DayOffs';
    	$repeat->entity_id = $dayOff->id;
    	$repeat->every =  $this->request->data['every'];
    	$repeat->every_count =  $this->request->data['every_count'];
    	$repeat->start =  $this->request->data['day_off_date_start'];
    	$repeat->end =  $this->request->data['day_off_date_end'];
    	$repeat->day_1 =  ($this->request->data['day_1'] == 'true') ? true : false;
    	$repeat->day_2 =  ($this->request->data['day_2'] == 'true') ? true : false;
    	$repeat->day_3 = ($this->request->data['day_3'] == 'true') ? true : false;
    	$repeat->day_4= ($this->request->data['day_4'] == 'true') ? true : false;
    	$repeat->day_5 = ($this->request->data['day_5'] == 'true') ? true : false;
    	$repeat->day_6 =  ($this->request->data['day_6'] == 'true') ? true : false;
    	$repeat->day_7 =  ($this->request->data['day_7'] == 'true') ? true : false;
    	$repeat = $this->Repeats->save($repeat);
    	 
    	$this->loadModel('DayOffs');
    	$dayOffQuery = $this->DayOffs->find('all')
    	->where(['DayOffs.user_id'=>$this->request->data['user_id'], 'DayOffs.date is'=>null])
    	->contain(['Repeats']);
    	$this->set('userRepeatedDayOffs', json_encode($dayOffQuery->all()));
    }
    
    public function removeCustomRepeatingShift(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$this->loadModel('Repeats');
    	
    	$this->loadModel('Shifts');
    	$shift = $this->Shifts->get($this->request->data['custom_repeating_shift_id']);
    	$this->Repeats->deleteAll(['entity_id'=>$shift->id, 'entity_type' => 'Shifts']);
    	$this->Shifts->deleteAll(['user_id'=>$this->request->data['user_id'],'id'=>$this->request->data['custom_repeating_shift_id']]);
    
    	$this->loadModel('Shifts');
    	$shiftsQuery = $this->Shifts->find('all')
    		->where(['Shifts.user_id'=>$this->request->data['user_id'], 'Shifts.date is'=>null])
    		->contain(['Repeats']);
    	$this->set('userRepeatedShifts', json_encode($shiftsQuery->all()));
    }
    
    public function removeCustomRepeatingDayOff(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$this->loadModel('Repeats');
    	 
    	$this->loadModel('DayOffs');
    	$dayOff = $this->DayOffs->get($this->request->data['custom_repeating_day_off_id']);
    	$this->Repeats->deleteAll(['entity_id'=>$dayOff->id, 'entity_type' => 'DayOffs']);
    	$this->DayOffs->deleteAll(['user_id'=>$this->request->data['user_id'],'id'=>$this->request->data['custom_repeating_day_off_id']]);
    
    	$this->loadModel('DayOffs');
    	$dayOffsQuery = $this->DayOffs->find('all')
    		->where(['DayOffs.user_id'=>$this->request->data['user_id'], 'DayOffs.date is'=>null])
    		->contain(['Repeats']);
    	$this->set('userRepeatedDayOffs', json_encode($dayOffsQuery->all()));
    }
    
    public function addSpecialShifts(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$this->loadModel('Shifts');
    	foreach ($this->request->data['dates'] as $date){
    		$shift = $this->Shifts->newEntity();
    		$shift->user_id =  $this->request->data['user_id'];
    		$shift->name =  $this->request->data['shift_name'];
    		$shift->start =  date("G:i", strtotime(str_replace(' ', '', $this->request->data['shift_start'])));
    		$shift->end = date("G:i", strtotime(str_replace(' ', '',  $this->request->data['shift_end'])));
    		$shift->date =  $date;
    		$shift = $this->Shifts->save($shift);
    	}
    	
    	$m = $this->request->data['current_month'];
    	$y = $this->request->data['current_year'];
    	$number = cal_days_in_month(CAL_GREGORIAN, $m, $y);
    	
    	$shiftsQuery = $this->Shifts->find('all')
    		->where(['Shifts.user_id'=>$this->request->data['user_id'], 'Shifts.date >='=>$y . '-' . $m . '-' . '1', 'Shifts.date <='=>$y . '-' . $m . '-' . $number]);
    	$this->set('userSpecialShifts', json_encode($shiftsQuery->all()));
    }
    
    public function addSpecialDayOffs(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	
    	$this->loadModel('DayOffs');
    	foreach ($this->request->data['dates'] as $date){
    		$dayOff = $this->DayOffs->newEntity();
    		$dayOff->user_id =  $this->request->data['user_id'];
    		$dayOff->name =  $this->request->data['day_off_name'];
    		$dayOff->date =  $date;
    		$dayOff = $this->DayOffs->save($dayOff);
    	}
    	 
    	$m = $this->request->data['current_month'];
    	$y = $this->request->data['current_year'];
    	$number = cal_days_in_month(CAL_GREGORIAN, $m, $y);
    	$dayOffsQuery = $this->DayOffs->find('all')
    		->where(['DayOffs.user_id'=>$this->request->data['user_id'], 'DayOffs.date >='=>$y . '-' . $m . '-' . '1', 'DayOffs.date <='=>$y . '-' . $m . '-' . $number]);
    	$this->set('userSpecialDayOffs', json_encode($dayOffsQuery->all()));
    }
    
    public function removeSpecialShift(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$this->loadModel('Shifts');
    	$this->Shifts->deleteAll(['user_id'=>$this->request->data['user_id'],'id'=>$this->request->data['special_shift_id']]);
    	
    	$m = $this->request->data['current_month'];
    	$y = $this->request->data['current_year'];
    	$number = cal_days_in_month(CAL_GREGORIAN, $m, $y);
    	$shiftsQuery = $this->Shifts->find('all')
    		->where(['Shifts.user_id'=>$this->request->data['user_id'], 'Shifts.date >='=>$y . '-' . $m . '-' . '1', 'Shifts.date <='=>$y . '-' . $m . '-' . $number]);
    	$this->set('userSpecialShifts', json_encode($shiftsQuery->all()));
    }
    
    public function removeSpecialDayOff(){
    	if(!isset($this->request->data['user_id'])){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$this->loadModel('DayOffs');
    	$this->DayOffs->deleteAll(['user_id'=>$this->request->data['user_id'],'id'=>$this->request->data['special_day_off_id']]);
    	 
    	$m = $this->request->data['current_month'];
    	$y = $this->request->data['current_year'];
    	$number = cal_days_in_month(CAL_GREGORIAN, $m, $y);
    	$dayOffsQuery = $this->DayOffs->find('all')
    		->where(['DayOffs.user_id'=>$this->request->data['user_id'], 'DayOffs.date >='=>$y . '-' . $m . '-' . '1', 'DayOffs.date <='=>$y . '-' . $m . '-' . $number]);
    	$this->set('userSpecialDayOffs', json_encode($dayOffsQuery->all()));
    }
    
    public function getShiftsByMonth($user_id, $year, $month){
    	if(!isset($user_id)){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    	$days = array();
    	for($i = 1; $i <= $number; $i++){
    		$days[$i] = $this->getShifts($user_id, $year, $month, $i, false);
    	}
    	//$this->log($days);
    	$this->set('monthShifts', json_encode($days));
    	
    	$this->loadModel('Shifts');
    	$number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    	$shiftsQuery = $this->Shifts->find('all')
    	->where(['Shifts.user_id'=>$user_id, 'Shifts.date >='=>$year . '-' . $month . '-' . '1', 'Shifts.date <='=>$year . '-' . $month . '-' . $number]);
    	$this->set('userSpecialShifts', json_encode($shiftsQuery->all()));
    	
    	$this->loadModel('DayOffs');
    	$number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    	$dayOffsQuery = $this->DayOffs->find('all')
    		->where(['DayOffs.user_id'=>$user_id, 'DayOffs.date >='=>$year . '-' . $month . '-' . '1', 'DayOffs.date <='=>$year . '-' . $month . '-' . $number]);
    	$this->set('userSpecialDayOffs', json_encode($dayOffsQuery->all()));
    }
    
    public function getShifts($user_id, $year, $month, $day, $isAjax = true){
    	if(!isset($user_id)){//handles when ajax request is sent while user has been logged out //TODO: add to other ajax requests
    		return $this->redirect(['action' => 'index']);
    	}
    	$dayShift = array();
    	$date =$year . '/'. $month .'/'.$day;
    	/* $this->log($date);
    	$this->log(date('N', mktime(0, 0, 0, $month, $day, $year))); */
    	//A. Day Offs
    	//A.2. Custom Repeating Offs
    	$this->loadModel('DayOffs');
    	$dayOffsQuery = $this->DayOffs->find('all')
    		->where(['DayOffs.user_id'=>$user_id, 'DayOffs.date is'=>null])
    		->contain(['Repeats']);
    	$customRepeatingDayOffs = $dayOffsQuery->all();
    	$userCustomRepeatingDayOff = null;
    	//$this->log($customRepeatingDayOffs);
    	foreach ($customRepeatingDayOffs as $customRepeatingDayOff){
    		//$this->log($customRepeatingDayOff->repeat);
    		for($i = 1; $i <= 7; $i++){
    			if(date('N', mktime(0, 0, 0, $month, $day, $year)) == $i && $customRepeatingDayOff->repeat['day_' . $i] ==1 )
    				$userCustomRepeatingDayOff = $customRepeatingDayOff;
    		}
    	}
    	if($userCustomRepeatingDayOff != null){
    		$dayShift['day_off'] = $userCustomRepeatingDayOff;
    	}
    	else {//check standard day off
    		$this->loadModel('UsersStandardDayOffs');
    		$usersStandardDayOffsQuery = $this->UsersStandardDayOffs->find('all')
	    		->where(['UsersStandardDayOffs.user_id'=>$user_id])
	    		->contain(['StandardDayOffs']);
    		$usersStandardDayOffs = $usersStandardDayOffsQuery->all();
    		foreach ($usersStandardDayOffs as $usersStandardDayOff){
    			if($usersStandardDayOff->standard_day_off->day != null){//weekly
    				if(date('N', mktime(0, 0, 0, $month, $day, $year))==$usersStandardDayOff->standard_day_off->day){
    					$dayShift['day_off'] = $usersStandardDayOff;
    				}
    			}
    			else{//holidays
    				if(date('n/j/y', mktime(0, 0, 0, $month, $day, $year)) == date($usersStandardDayOff->standard_day_off->date)){//off found
    					$dayShift['day_off'] = $usersStandardDayOff;
    				}
    			}
    		}
    	}
    	
    	$this->loadModel('Shifts');
    	if(!isset($dayShift['day_off'])){
    		//-----
    		$shiftsQuery = $this->Shifts->find('all')
	    		->where(['Shifts.user_id'=>$user_id, 'Shifts.date is'=>null])
	    		->contain(['Repeats']);
    		$customRepeatingShifts = $shiftsQuery->all();
    		$usercustomRepeatingShifts = array();
    		foreach ($customRepeatingShifts as $customRepeatingShift){
    			for($i = 1; $i <= 7; $i++){
    				if(date('N', mktime(0, 0, 0, $month, $day, $year)) == $i && $customRepeatingShift->repeat['day_' . $i] ==1 )
    					array_push($usercustomRepeatingShifts,$customRepeatingShift);
    			}
    		}
    		if(count($usercustomRepeatingShifts)>0){
    			$dayShift['shifts'] = $usercustomRepeatingShifts;
    		}
    		else{//check standard shifts
    			$this->loadModel('UsersStandardShifts');
    			$usersStandardShiftsQuery = $this->UsersStandardShifts->find('all')
	    			->where(['UsersStandardShifts.user_id'=>$user_id])
	    			->contain(['StandardShifts']);
    			$usersStandardShifts = $usersStandardShiftsQuery->all();
    			$usersStandardShiftsArray = array();
    			foreach ($usersStandardShifts as $usersStandardShift){
    				array_push($usersStandardShiftsArray, $usersStandardShift);
    			}
    			$dayShift['shifts'] = $usersStandardShiftsArray;
    		}
    	}
    	
    	//override with special shift
    	$shiftsQuery = $this->Shifts->find('all')
    		->where(['Shifts.user_id'=>$user_id, 'Shifts.date'=>$date]);
    	$specialShifts = $shiftsQuery->all();
    	if(count($specialShifts) > 0){
    		unset($dayShift['day_off']);
    		$dayShift['shifts'] = $specialShifts;
    	}
    	
    	//override with special day off
    	$dayOffsQuery = $this->DayOffs->find('all')
    		->where(['DayOffs.user_id'=>$user_id, 'DayOffs.date'=>$date]);
    	$specialDayOffs = $dayOffsQuery->first();
    	if(count($specialDayOffs) > 0){
    		unset($dayShift['shifts']);
    		$dayShift['day_off'] = $specialDayOffs;
    	}
    	
    	//$this->log($dayShift);
    	
    	if($isAjax){
    		$this->set('userShifts', json_encode($dayShift));
    	}
    	else{
    		
    		return $dayShift;
    	}
    }
    
    public function profile(){
    	
    }
}
