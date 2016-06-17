<?php
$envConf = array(
	'img_url' => 'http://img.anhmh.localhost/',
    'fe_url' => 'http://front.anhmh.localhost/',
	'adm_url' => 'http://admin.anhmh.localhost/',
    'facebook' => array(
        'app_id' => '100274197065981',
        'app_secret' => 'ceb5eaddbebb4590a991cf32a956f2f6',
    ),
    'twitter' => array(
        'key' => 'diXip9KkGrJ0QGhRaxXMNtPve',
        'secret' => 'ugZG8bPb2oiDZMPU6XbdvLozCy5Di4ZYZCaKEsxHJWzyhroljk'
    ),    
    'send_email' => true,
    'test_email' => '', // will send to this email for testing   
    'api_check_security' => false,
);

if (isset($_SERVER['SERVER_NAME'])) {
    if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $_SERVER['SERVER_NAME'] . '.php')) {
        include_once (__DIR__ . DIRECTORY_SEPARATOR . $_SERVER['SERVER_NAME'] . '.php');
        $envConf = array_merge($envConf, $domainConf);
    }
}
if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'db.read.php')) {
    include_once (__DIR__ . DIRECTORY_SEPARATOR . 'db.read.php');
    $envConf = array_merge($envConf, $dbReadConf);
}
return $envConf;