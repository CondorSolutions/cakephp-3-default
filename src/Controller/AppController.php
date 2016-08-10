<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Muffin\Footprint\Auth\FootprintAwareTrait;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Ceeram\Blame\Controller\BlameTrait;
use App\Util\TerminalUtil;

use App\Model\Entity\Location;



/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	use FootprintAwareTrait;
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
		
		$this->loadComponent('Auth', [
				'loginAction' => [
					'controller' => 'Users',
					'action' => 'login'
				],
				'loginRedirect' => [
					'controller' => 'Users',
					'action' => 'index'
				],
				'authError' => 'Did you really think you are allowed to see that?',
				'authenticate' => [
					'Form' => [
						'fields' => [
							'username' => 'email',
							'password' => 'password'
						],
						'scope' => ['Users.active' => true],
						'contain' => ['Roles']
					]
				],
				'authorize' => [
					'TinyAuth.Tiny' => [
						'roleColumn' => 'role_id',
						'rolesTable' => 'Roles',
						'multiRole' => true,
						'pivotTable' => 'roles_users',
						'superAdminRole' => null,
						'authorizeByPrefix' => false,
						'prefixes' => [],
						'allowUser' => false,
						'adminPrefix' => null,
						'autoClearCache' => Configure::read('debug')
					]
				]
			]
		);
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
    	if( $this->Auth->user()){
    		$authUser = $this->Auth->user();
    		$this->set('authUser', $authUser);
    		$usersTable = TableRegistry::get('Users');
    		$usersQuery = $usersTable->find('all')
    			->where(['Users.id'=>$authUser['id']]);
    		$loggedUser = $usersQuery->first();
    		$this->set('loggedUser', $loggedUser);
    		$rolesTable = TableRegistry::get('Roles');
    		$rolesQuery = $rolesTable->find('all');
    		 $roles = $rolesQuery->all();
    		$this->set('roles', $roles->toArray()); 
    		
    		$usersQuery = $usersTable->find('all');
    		$this->set('usersCount', $usersQuery->count());
    		$locationsTable = TableRegistry::get('Locations');
    		$locationsQuery = $locationsTable->find('all');
    		$this->set('locationsCount', $locationsQuery->count());
    		
    		$terminalUtil = new TerminalUtil();
    		$this->set('terminalsCount', count($terminalUtil->getTerminals()));
    		
    		$this->set('activeAccount',Configure::read('Account.active'));
    	}
    	
    	
    	if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) 
    	{
            $this->set('_serialize', true);
        }
    }
    
    public function decrypt($encrypted_string){
    	$key = "Yb5MFZbSrvb+m9bJxmkyem4k9NkYPdcusH8Vb7HzfwY=";
    	$iv = "HtWxnsSzKVXTSYydCzLGlKZ1rKaTy/H8O1HmtlAubm0=";
    	if($encrypted_string != ""){
    		return $this->decryptRJ256($key,$iv ,$encrypted_string);
    	}
    	else{
    		return '';
    	}
    }
    
    
    function decryptRJ256($key,$iv,$encrypted)
    {
    	//PHP strips "+" and replaces with " ", but we need "+" so add it back in...
    	$encrypted = str_replace(' ', '+', $encrypted);
    
    	//get all the bits
    	$key = base64_decode($key);
    	$iv = base64_decode($iv);
    	$encrypted = base64_decode($encrypted);
    
    	$rtn = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encrypted, MCRYPT_MODE_CBC, $iv);
    	$rtn = $this->unpad($rtn);
    	return($rtn);
    }
    
    //removes PKCS7 padding
    function unpad($value)
    {
    	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    	$packing = ord($value[strlen($value) - 1]);
    	if($packing && $packing < $blockSize)
    	{
    		for($P = strlen($value) - 1; $P >= strlen($value) - $packing; $P--)
    		{
    		if(ord($value{$P}) != $packing)
    		{
    		$packing = 0;
    		}
    		}
    		}
    
    		return substr($value, 0, strlen($value) - $packing);
    }
	
}
