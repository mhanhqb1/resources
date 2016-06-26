<?php
if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'list':
			require_once "controllers/tintuc/list.php";
			break;
		case 'add':
			require_once "controllers/tintuc/add.php";
			break;
		case 'edit':
			require_once "controllers/tintuc/edit.php";
			break;
		case 'del':
			require_once "controllers/tintuc/del.php";
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "controllers/tintuc/list.php";
}