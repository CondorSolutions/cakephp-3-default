<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Option;
use App\Util\OptionsUtil;
use Cake\Utility\Hash;

class OptionsController extends AppController
{

    public function index()
    {
        $optionsUtil = new OptionsUtil();
        $optionsUtil->initOptions();
    	
       $query = $this->Options->find('all');
     	$options = $query->toArray();
      //$options = $query->all();
       //$this->log($options);
       $result = Hash::combine($options, '{n}.code', '{n}');
       $this->set('options', $result);
      // $combined = $result = Hash::combine($a, '{n}.User.id', '{n}.User.Data');
       
       /*  $this->set(compact('options'));
        $this->set('_serialize', ['options']); */
    }
    
    public function update(){
    	$query = $this->Options->find('all');
    	$options = $query->toArray();
    	foreach ($options as $option){
    		$option->value1 = $this->request->data[$option->code];
    		$this->Options->save($option);
    	}
    	$this->Flash->success(__('System Settings saved.'));
    	return $this->redirect(['action' => 'index']);
    }
}
