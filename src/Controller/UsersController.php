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
        if ($this->Users->delete($user)) {
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
        				return $this->redirect($this->Auth->redirectUrl());
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
    		$this->log($this->request->data);
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
    	
    	$email = new Email('default');
    	$email->viewVars([
    			'activation_id' => $unique_id,
    			'user' => $user,
    			'appHome' => Router::url('/', true),
    			]);
    	 
    	$result = $email->from([Configure::read('App.noreply_address') => Configure::read('App.name')])
    	->template('reset_password','default')
    	->emailFormat('html')
    	->to($user->email)
    	->subject('Reset Password')
    	->send('My message');
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
    	
    	$result = $email->from([Configure::read('App.noreply_address') => Configure::read('App.name')])
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
    	$this->log($this->request->data);
    	return $this->redirect(['action' => 'edit/' . $this->request->data['user_id']]);
    }
    
    public function savePersonalInfo(){
    	$this->log($this->request->data);
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
}
