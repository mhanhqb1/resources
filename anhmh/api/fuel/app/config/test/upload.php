<?php 
return array(	
    'upload_dir' => '/var/www/oceanize/upload/',
	'img_dir' => '/var/www/html/oceanize/upload/img/',
	'path' => '/var/www/html/oceanize/upload/img/' . date('Y/m/d') . '/',
	'auto_process' => false,
	'normalize' => true,
	'change_case' => 'lower',
	'randomize' => true,
	'ext_whitelist' => array('jpeg', 'jpg', 'gif', 'png', 'mp4', 'flv'),
);