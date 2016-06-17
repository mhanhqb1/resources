<?php

/**
 * The production database settings. These get merged with the global settings.
 */
return array(
    'default' => array(
        'connection' => array(
            'dsn' => 'mysql:host=localhost;dbname=anhmh',
            'username' => 'root',
            'password' => '',
        ),
        'timezone' => '+9:00',
    ),
    'replica1' => array(
	  	'connection' => array(
	    	'dsn' => 'mysql:host=localhost;dbname=anhmh',
	    	'username' => 'root',
	    	'password' => '',
  		),
  		'timezone' => '+7:00',
        'type'         => 'pdo',
        'identifier'   => '`',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'enable_cache' => true,
        'profiling'    => false,
        'readonly'     => false,
	),
);
