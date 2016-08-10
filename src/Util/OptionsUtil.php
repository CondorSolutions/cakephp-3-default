<?php
namespace App\Util;

use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\Network\Http\Client;
use App\Model\Entity\Option;
use Cake\ORM\TableRegistry;

class OptionsUtil 
{
	public static function getOption($code){
		$table = TableRegistry::get('Options');
		$query = $table->find('all')
			->where(['Options.code'=>$code]);
		$option = $query->first();
		return $option;
	}
	
	public function initOptions(){
		$defaults = $this->_defaults();
		$table = TableRegistry::get('Options');
		foreach ($defaults as $code => $defaultOption){
			
			$query = $table->find('all')
				->where(['Options.code'=>$code]);
			$option = $query->first();
			
			if(!$option){
				//Log::write('error', $defaultOption);
				$option = $table->newEntity();
				$option->code = $code;
				$option->section = $defaultOption['SECTION'];
				$option->value1 = $defaultOption['VALUE1'];
				$table->save($option);
			}
			//Log::write('error', json_encode($option));
		}
	}

	private function _defaults(){
		return [
			self::APP_NAME => 
			[
				'SECTION' => self::GENERAL ,
				'VALUE1' => 'CIMS Time and Attendance',
			],
			self::COMPANY_NAME =>
			[
				'SECTION' => self::GENERAL ,
				'VALUE1' => 'Condor Solutions RP Inc.',
			],
			self::FILES_PATH => 
			[
				'SECTION' => self::GENERAL ,
				'VALUE1' => 'files',
			],
			self::NO_REPLY_ADDRESS =>
			[
				'SECTION' => self::EMAIL ,
				'VALUE1' => 'noreply@condorpos.ph',
			],
			self::MAIL_HOST => 
			[
				'SECTION' => self::EMAIL ,
				'VALUE1' => 'ssl://mail.condorpos.ph',
			],
			self::MAIL_PORT =>
			[
				'SECTION' => self::EMAIL ,
				'VALUE1' =>  '465',
			],
			self::MAIL_USERNAME =>
			[
				'SECTION' => self::EMAIL ,
				'VALUE1' =>  'tech.admin@condorpos.ph',
			],
			self::MAIL_PASSWORD => 
			[
				'SECTION' => self::EMAIL ,
				'VALUE1' =>  '',
			],
			self::TERMINALS_MANAGER_URL => 
			[
				'SECTION' => self::EMAIL ,
				'VALUE1' =>  'http://192.168.2.22/dev/cims-terminals/',
			],
			/* self::TERMINALS_MANAGER_ACCOUNT_ID => 
			[
				'SECTION' => self::TERMINALS ,
				'VALUE1' =>  '',
			], */
			self::TERMINALS_MANAGER_ACCOUNT_KEY =>
			[
				'SECTION' => self::TERMINALS ,
				'VALUE1' =>  '',
			],
			self::TERMINALS_DEFAULT_PIN => 
			[
				'SECTION' => self::TERMINALS ,
				'VALUE1' =>  '3341',
			],
		];
	}
	//Sections
	const GENERAL = 'GENERAL';
	const EMAIL = 'EMAIL';
	const TERMINALS = 'TERMINALS';
	
	//Application Options
	const APP_NAME = 'APP_NAME';
	const COMPANY_NAME = 'COMPANY_NAME';
	const FILES_PATH = 'FILES_PATH';
	
	//Email Options
	const NO_REPLY_ADDRESS = 'NO_REPLY_ADDRESS';
	const MAIL_HOST = 'MAIL_HOST';
	const MAIL_PORT = 'MAIL_PORT';
	const MAIL_USERNAME = 'MAIL_USERNAME';
	const MAIL_PASSWORD = 'MAIL_PASSWORD';
	
	//Terminals Management
	const TERMINALS_MANAGER_URL = 'TERMINALS_MANAGER_URL';
	//const TERMINALS_MANAGER_ACCOUNT_ID = 'TERMINALS_MANAGER_ACCOUNT_ID';
	const TERMINALS_MANAGER_ACCOUNT_KEY = 'TERMINALS_MANAGER_ACCOUNT_KEY';
	const TERMINALS_DEFAULT_PIN = 'TERMINALS_DEFAULT_PIN';
}