<?php
namespace App\Util;

use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\Network\Http\Client;
use App\Util\OptionsUtil;

class WebUtil
{
	public function sendRequest($path){
		try{
			$url = OptionsUtil::getOption(OptionsUtil::TERMINALS_MANAGER_URL)->value1;
			if(OptionsUtil::getOption(OptionsUtil::TERMINALS_MANAGER_URL)->value1){
				$fullPath = $url  . $path;
				$http = new Client();
				$response = $http->post($fullPath, [
						'account_id' => Configure::read('Account.active'),
						'account_key' => OptionsUtil::getOption(OptionsUtil::TERMINALS_MANAGER_ACCOUNT_KEY)->value1,
						'terminal_type' => 'tna'
						]);
				
				$decoded = json_decode($response->body, true);
				if(array_key_exists('RESULT', $decoded)){
					return $decoded['DATA'];
				}else{
					Log::write('error',$path . " ERROR:");
					Log::write('error',$response);
					return null;
				}
			}
			else{
				return null;
			}
			
		}catch(Exception $e){
			Log::write('error',$path . ' HttpSocket Error:'.$e->getMessage());
			return null;
		}
	}
}