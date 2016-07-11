<?php
if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'list':
			require_once "controllers/users/list.php";
			break;
		case 'add':
			require_once "controllers/users/add.php";
			break;
		case 'edit':
			require_once "controllers/users/edit.php";
			break;
		case 'del':
			require_once "controllers/users/del.php";
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "controllers/users/list.php";
}