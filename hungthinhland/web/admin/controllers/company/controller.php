<?php
if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'list':
			require_once "controllers/company/list.php";
			break;
		case 'add':
			require_once "controllers/company/add.php";
			break;
		case 'edit':
			require_once "controllers/company/edit.php";
			break;
		case 'del':
			require_once "controllers/company/del.php";
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "controllers/company/list.php";
}