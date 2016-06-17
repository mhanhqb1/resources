<?php
$envConf = array(
	'img_url' => 'http://sv4.evolable-asia.z-hosts.com:84/',
	'fe_url' => 'http://dev.bremen-maps.jp/',
	'adm_url' => "http://sv4.evolable-asia.z-hosts.com:2017/",
    'facebook' => array(
        'app_id' => '798464446935720',
        'app_secret' => 'df8725019a5422ea145ebade4126470c',
    ),
    'send_email' => true,
    'test_email' => '', // always send to this email for testing     
    'api_check_security' => false,
);
if (isset($_SERVER['SERVER_NAME'])) {
    if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $_SERVER['SERVER_NAME'] . '.php')) {
        include_once (__DIR__ . DIRECTORY_SEPARATOR . $_SERVER['SERVER_NAME'] . '.php');
        $envConf = array_merge($envConf, $domainConf);
    }
}
return $envConf;