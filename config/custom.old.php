<?php 
return [
	'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
	'App' =>[
		//'name' => 'CIMS Time and Attendance',
		'company_name' => 'Condor POS Solutions RP Inc.',
		'files_path' => WWW_ROOT . 'files',
		'noreply_address' => 'noreply@condorpos.ph',
	],
	'Terminals'=>[
	'manager_url' => 'http://192.168.2.22/dev/cims-terminals/',
	//'manager_url' => 'http://terminals.condorpos.ph/',
	'account_id' => 2,
	'account_key' => 'c5c18098916f74b6d27eeece0fafd3d44eb880b4',
		//'account_key' => 'e4018ac3bb7f7c558aafb956e3d8d58f866d8ec9',
			'default_pin' => '3341',
	],
	'Datasources' => [
		'default' => [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Mysql',
			'persistent' => false,
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'cposph_dev_cims-taa-web',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'flags' => [],
			'cacheMetadata' => true,
			'log' => false,
			'quoteIdentifiers' => false,
			'url' => env('DATABASE_URL', null),
		],
	],
	'Users' =>[
		'statuses' =>['active','suspended'],
		'default_photo' => 'default-photo.jpg',
	],
	'EmailTransport' => [
		'default' => [
			'className' => 'Smtp',
			// The following keys are used in SMTP transports
			'host' => 'ssl://mail.condorpos.ph',
			'port' => 465,
			'timeout' => 30,
			'username' => 'tech.admin@condorpos.ph',
			'password' => 'Global2016',
			'client' => null,
			'tls' => null,
			'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
		],
	],
	
	'CakePdf' => [
		//'engine' => 'CakePdf.WkHtmlToPdf',
		'margin' => [
			'bottom' => 15,
			'left' => 20,
			'right' => 20,
			'top' => 20
		],
		'orientation' => 'landscape',
		'download' => false
	],
];