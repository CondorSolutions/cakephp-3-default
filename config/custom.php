<?php 
return [
	'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
	'Users' =>[
		'statuses' =>['active','suspended'],
		'default_photo' => 'default-photo.jpg',
	],
	'EmailTransport' => [
		'default' => [
			'className' => 'Smtp',
			// The following keys are used in SMTP transports
			'host' => '',
			'port' => 465,
			'timeout' => 30,
			'username' => '',
			'password' => '',
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