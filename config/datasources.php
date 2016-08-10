<?php 
return [
	'Datasources' => [
		'lookup' => [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'cposph_dev_cimsterm',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
		],
		'shard_002' => [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'cposph_cims-tna_002',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
		],
		'shard_cs5025' => [
			'className' => 'Cake\Database\Connection',
			'driver' => 'Cake\Database\Driver\Mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'cposph_cims-tna_cs5025',
			'encoding' => 'utf8',
			'timezone' => 'UTC',
			'cacheMetadata' => true,
		],
	],
];