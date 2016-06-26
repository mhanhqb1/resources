<?php
if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'list':
			require_once "controllers/phonenumber/list.php";
			break;
		case 'add':
			require_once "controllers/phonenumber/add.php";
			break;
		case 'edit':
			require_once "controllers/phonenumber/edit.php";
			break;
		case 'del':
			require_once "controllers/phonenumber/del.php";
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "controllers/phonenumber/list.php";
}