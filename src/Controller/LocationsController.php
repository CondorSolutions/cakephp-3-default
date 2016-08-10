<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Location;
use App\Util\TerminalUtil;
/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 */
class LocationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        //$locations = $this->paginate($this->Locations);
		$locations = $this->Locations->find('all');

        $this->set(compact('locations'));
        $this->set('_serialize', ['locations']);
        
       /*  $location = new Location();
        $this->set('terminals',  json_encode($location->getTerminals())); */
        
        $terminalUtil = new TerminalUtil();
        $terminals = $terminalUtil->getTerminals();
        $this->set('terminals',  json_encode($terminals));
        
        $terminalsLocationTable = TableRegistry::get('TerminalsLocations');
        $terminalsLocationQuery = $terminalsLocationTable->find('all');
        $this->set('terminalsLocations',  json_encode($terminalsLocationQuery->all()));
        
        $personsTable = TableRegistry::get('Persons');
        $personsQuery = $personsTable->find('all')
        	->where(['Persons.person_type'=>'User'])
        	->order(['Persons.last_name']);
        $this->set('persons',  json_encode($personsQuery->all()));
        
        $locationsUsersTable = TableRegistry::get('LocationsUsers');
        $locationsUsersQuery = $locationsUsersTable->find('all');
        $this->set('locationsUsers',  json_encode($locationsUsersQuery->all()));
    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => []
        ]);

        $this->set('location', $location);
        $this->set('_serialize', ['location']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $location = $this->Locations->newEntity();
        if ($this->request->is('post')) {
            $location = $this->Locations->patchEntity($location, $this->request->data);
            $this->log($location);
            if ($this->Locations->save($location)) {
            	$addressTable = TableRegistry::get('Addresses');
            	for($i = 0; $i <$this->request->data['address_count'];$i++ ){
            		if(isset($this->request->data['address_name_'.$i])){
            			$addressTable = TableRegistry::get('Addresses');
            			$address = $addressTable->newEntity();
            			$address->entity_type = 'Location';
            			$address->entity_id = $location->id;
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
            	
                $this->Flash->success(__('The location has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The location could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('location'));
        $this->set('_serialize', ['location']);
        
        $refRegionsTable = TableRegistry::get('RefRegions');
        $refRegionsQuery = $refRegionsTable->find('all');
        $this->set('refRegions',json_encode($refRegionsQuery->all()));
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $this->request->data);
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The location could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('location'));
        $this->set('_serialize', ['location']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $location = $this->Locations->get($id);
        if ($this->Locations->delete($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function addLocationTerminal()
    {
    	$terminalsLocationTable = TableRegistry::get('TerminalsLocations');
    	$terminalsLocation = $terminalsLocationTable->newEntity();
    	$terminalsLocation->location_id = $this->request->data['location_id'];
    	$terminalsLocation->terminal_id = $this->request->data['terminal_id'];
    	$data = $terminalsLocationTable->save($terminalsLocation);
    	
    	$this->set('data',  json_encode($data));
    }
    
    public function removeLocationTerminal()
    {
    	$terminalsLocationTable = TableRegistry::get('TerminalsLocations');
    	$data = $terminalsLocationTable->deleteAll(['location_id'=>$this->request->data['location_id'],'terminal_id'=>$this->request->data['terminal_id']]);
    	$this->set('data',  json_encode($data));
    }
    
    public function removeLocationUser(){
    	$locationsUsersTable = TableRegistry::get('LocationsUsers');
    	$locationsUsersTable->deleteAll(['location_id'=>$this->request->data['location_id'],'user_id'=>$this->request->data['user_id']]);
    	$locationsUsersQuery = $locationsUsersTable->find('all');
    	$this->set('data',  json_encode( $locationsUsersQuery->all()));
    }
    
}
