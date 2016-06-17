<?php
$envConf = array(
	'img_url' => 'https://img.bmaps.world/',
    'fe_url' => 'https://bmaps.world/',
	'adm_url' => 'https://admin.bmaps.world/',
    'facebook' => array(
        'app_id' => '1774325229462079',
        'app_secret' => 'b13eccce50779dbb877600eb5cfcb7f1',
    ),
    'twitter' => array(
        'key' => 'QEo3QaWc4TLCyxkO4KqdBR29u',
        'secret' => '3oIUTkiFL7WkesWyd7iw22luK0YEv2eNxPnjbvaFklh4vqGpJT'
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