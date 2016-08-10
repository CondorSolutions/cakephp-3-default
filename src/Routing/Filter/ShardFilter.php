<?php
namespace App\Routing\Filter;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Routing\DispatcherFilter;
use Cake\Log\Log;

class ShardFilter extends DispatcherFilter
{
	public function beforeDispatch(Event $event)
	{
		$request = $event->data['request'];
		// Find the account map data for the current request. Missing accounts will raise errors.
		$accounts = TableRegistry::get('Accounts');
		//Log::write('error', $request->subdomains());
		
		$subdomain = $request->subdomains()[0];
		$mapping = $accounts->findByCode($subdomain)->firstOrFail();
		// Alias the active account's shard to our 'default' connection.
		//$alias = 'shard_' . str_pad($mapping->id, 3, "0", STR_PAD_LEFT);
		$alias = 'shard_' . $subdomain;
		
		ConnectionManager::alias($alias , 'default');

		// Store the active account in the session
		Configure::write('Account.active', $mapping->id);
	}
}