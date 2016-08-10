<?php
namespace App\Util;

use Cake\Log\Log;
use Cake\Core\Configure;
use App\Model\Entity\TerminalDetail;
use Cake\ORM\TableRegistry;
use App\Util\OptionsUtil;

class TerminalUtil
{
	public function sendRequest($path){
		try{
			$fullPath = OptionsUtil::getOption(OptionsUtil::TERMINALS_MANAGER_URL)->value1  . $path;
			$http = new Client();
			$response = $http->post($fullPath, [
					'account_id' => OptionsUtil::getOption(OptionsUtil::TERMINALS_MANAGER_ACCOUNT_ID)->value1,
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
		}catch(Exception $e){
			Log::write('error',$path . ' HttpSocket Error:'.$e->getMessage());
			return null;
		}
	}
	
	public function getTerminals(){
		$webUtil = new WebUtil();
		return $webUtil->sendRequest('terminals/getTerminals.json');
	}
	
	public function addDefaultTerminalDetail($id){
		$terminalDetailsTable = TableRegistry::get('TerminalDetails');
		$terminalDetail = $terminalDetailsTable->newEntity();
		$terminalDetail->id = $id;
		$terminalDetail->pin = OptionsUtil::getOption(OptionsUtil::TERMINALS_DEFAULT_PIN)->value1;
		$terminalDetailsTable->save($terminalDetail);
		return $terminalDetail;
	}
}