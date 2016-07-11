<?php
session_start();
// error_reporting(0);
ob_start();
if(!isset($_SESSION['level']) || $_SESSION['level'] != 2){
	header("Location: login.php");
	exit();
}
require_once "../library/Database.php";
require_once "templates/top.php";
require_once "templates/left.php";
$db = new DATABASE;
$db->connect();
if(isset($_GET['controller'])){
	switch ($_GET['controller']) {
		case 'user':
			require_once "controllers/users/controller.php";
			break;
		case 'slider':
			require_once "controllers/slider/controller.php";
			break;
		case 'gioithieu':
			require_once "controllers/gioithieu/controller.php";
			break;
		case 'lienhe':
			require_once "controllers/lienhe/controller.php";
			break;
		case 'duan':
			require_once "controllers/duan/controller.php";
			break;
		case 'company':
			require_once "controllers/company/controller.php";
			break;
		case 'cate':
			require_once "controllers/cate/controller.php";
			break;
		case 'request':
			require_once "controllers/request/controller.php";
			break;
		case 'tintuc':
			require_once "controllers/tintuc/controller.php";
			break;
		case 'phonenumber':
			require_once "controllers/phonenumber/controller.php";
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "templates/default.php";
}
require_once "templates/bottom.php";
ob_flush();
?>