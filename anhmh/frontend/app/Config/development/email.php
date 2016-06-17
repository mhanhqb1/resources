<?php

/* 
 * Email config for production environment
 */

class EmailConfig {

	public $smtp = array(
		'transport'     => 'Smtp',
		'from'          => array('vcctestemail123@gmail.com' => 'Bmaps'),
		'bcc' 			=> 'vcctestemail123@gmail.com',
		'host'          => 'email-smtp.us-west-2.amazonaws.com',
        'username'      => 'AKIAI44GJGPWEUUKPEXQ',
		'password'      => 'As82VVQ8lqGablyt9pSUkc3dZMGVfO7H3QZv1rUE0Hai',
		'port'          => 587,
		'timeout'       => 30,
		'client'        => null,
		'log'           => false,
		'charset'       => 'utf-8',
		'headerCharset' => 'utf-8',
        'tls'           => true
	);

}
