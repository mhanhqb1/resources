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
$duan = new DUAN;
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
$data = $duan->listOne($id);
require_once "templates/header_duan.php";
require_once "templates/footer.php";
ob_flush();
?>