<?php

/**
 * The production database settings. These get merged with the global settings.
 */
return array(
    'default' => array(
        'connection' => array(
            'dsn' => 'mysql:host=bremendb.c1aed49iadpp.ap-northeast-1.rds.amazonaws.com:3306;dbname=bremen',
            'username' => 'bremen_user',
            'password' => 'ta17em88++',
        ),
        'timezone' => '+9:00',
    ),
    'replica1' => array(
	  	'connection' => array(
	    	'dsn' => 'mysql:host=bremendb2.c1aed49iadpp.ap-northeast-1.rds.amazonaws.com:3306;dbname=bremen',
	    	'username' => 'bremen_user',
	    	'password' => 'ta17em88++',
  		),
  		'timezone' => '+9:00',
        'type'         => 'pdo',
        'identifier'   => '`',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'enable_cache' => true,
        'profiling'    => false,
        'readonly'     => false,
	),
);
