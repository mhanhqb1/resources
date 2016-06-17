<?php

/* 
 * Database config for development environment
 */

class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host'       => 'localhost',
		'login'      => 'root',
		'password'   => '',
		'database'   => 'bremen',
		'prefix'     => '',
		'encoding'   => 'utf8',
	);
}
