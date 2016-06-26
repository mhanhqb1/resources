<?php
if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'list':
			require_once "controllers/gioithieu/list.php";
			break;
		case 'add':
			require_once "controllers/gioithieu/add.php";
			break;
		case 'edit':
			require_once "controllers/gioithieu/edit.php";
			break;
		case 'del':
			require_once "controllers/gioithieu/del.php";
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "controllers/gioithieu/list.php";
}