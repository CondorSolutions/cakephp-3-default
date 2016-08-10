<?php 
return [
	'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),
	'App' =>[
		'name' => 'CIMS Time and Attendance',
		'company_name' => 'Condor POS Solutions RP Inc.',
		'files_path' => WWW_ROOT . 'files',
		'noreply_address' => 'noreply@condorpos.ph',
	],
	'Terminals'=>[
		'manager_url' => 'http://terminals.condorpos.ph/',
		'account_id' => 2,
		'account_key' => 'e4018ac3bb7f7c558aafb956e3d8d58f866d8ec9'
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
	'Datasources' => [
		'default' => [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Mysql',
			'persistent' => false,
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'cims-tna',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'flags' => [],
			'cacheMetadata' => true,
			'log' => false,
			'quoteIdentifiers' => false,
			'url' => env('DATABASE_URL', null),
		],
	
	/**
	 * The test connection is used during the test suite.
	*/
		'test' => [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Mysql',
			'persistent' => false,
			'host' => 'localhost',
			//'port' => 'non_standard_port_number',
			'username' => 'my_app',
			'password' => 'secret',
			'database' => 'test_myapp',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
			'quoteIdentifiers' => false,
			'log' => false,
			//'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
			'url' => env('DATABASE_TEST_URL', null),
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