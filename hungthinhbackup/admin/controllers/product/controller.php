<?php
if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'list':
			require_once "controllers/product/list.php";
			break;
		case 'add':
			require_once "controllers/product/add.php";
			break;
		case 'edit':
			require_once "controllers/product/edit.php";
			break;
		case 'del':
			require_once "controllers/product/del.php";
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "controllers/product/list.php";
}