<?php

/* 
 * Email config for production environment
 */

class EmailConfig {

	public $smtp = array(
		'transport'     => 'Smtp',
		'from'          => array('developer.php.vn@gmail.com' => 'Bmaps'),
		'host'          => 'ssl://smtp.gmail.com',
		'username'      => 'developer.php.vn@gmail.com',
		'password'      => 'dev@123456',
		'port'          => 465,
		'timeout'       => 30,
		'client'        => null,
		'log'           => false,
		'charset'       => 'utf-8',
		'headerCharset' => 'utf-8',
	);

}
