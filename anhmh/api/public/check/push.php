<?php

// Put your device token here (without spaces):
if (empty($_GET['token'])) {
    $deviceToken = 'd7968207446f30152dc08d2d1a01d85107037f637c2f0758a9f1b826c18892ca';
} else {
    $deviceToken = $_GET['token'];
}

if (empty($_GET['pem_local'])) {
    $pem_path = '../../fuel/packages/apns/Development_BremenPushNotificationKeyNoPass.pem';
} else {
    $pem_path = 'bremen_push_dev.pem';
}

// Put your private key's passphrase here:
$passphrase = '';

// Put your alert message here:
//$message = 'My first push notification!';
$message = '{"aps":{"alert":"Test push","badge":0},"bremen":"{\"id\":1707,\"user_id\":314,\"receive_user_id\":146,\"place_id\":0,\"place_review_id\":789,\"type\":1,\"name\":\"vcc.kien.13\",\"place_name\":\"\",\"count_follow\":3,\"count_like\":0,\"count_comment\":0}"}';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $pem_path);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);

// Encode the payload as JSON
//$payload = json_encode($body);
$payload = $message;

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);

echo '<br/>';
if (isset($_SERVER['FUEL_ENV'])) {
    echo $_SERVER['FUEL_ENV'];
} else {
    echo 'Not set FUEL_ENV';
}

