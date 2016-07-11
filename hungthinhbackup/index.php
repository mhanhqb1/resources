<?php
session_start();
// error_reporting(0);
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once "library/Database.php";
$contact = new CONTACT;
$contactData = $contact->listAll();
$phoneNumber = new PHONENUMBER;
$phoneNumberData = $phoneNumber->listAll();
$slider = new SLIDER;
$slider_data = $slider->listAll();
$count = 0;
require_once "templates/header.php";
$db = new DATABASE;
$db->connect();
if(isset($_GET['controller'])){
	switch ($_GET['controller']) {
		case 'tintuc':
			require_once "templates/tintuc.php";
			break;
		case 'tintucchitiet':
			require_once "templates/newsdetail.php";
			break;
		case 'gioithieu':
			require_once "templates/gioithieu.php";
			break;
		case 'duan':
			require_once "templates/duan.php";
			break;
		case 'tuyendung':
			require_once "templates/tuyendung.php";
			break;	
		case 'lienhe':
			require_once "templates/lienhe.php";
			break;
		default:
			require_once "templates/main.php";
			break;
	}
}else{
	require_once "templates/main.php";
}
require_once "templates/footer.php";
ob_flush();
?>