<?php

/* 
 * Database config for production environment
 */

class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host'       => 'localhost',
		'login'      => 'user',
		'password'   => 'password',
		'database'   => 'database_name',
		'prefix'     => '',
		'encoding'   => 'utf8',
	);
}
