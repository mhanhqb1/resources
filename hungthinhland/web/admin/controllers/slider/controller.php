<?php
if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'list':
			require_once "controllers/slider/list.php";
			break;
		case 'add':
			require_once "controllers/slider/add.php";
			break;
		case 'edit':
			require_once "controllers/slider/edit.php";
			break;
		case 'del':
			require_once "controllers/slider/del.php";
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "controllers/slider/list.php";
}