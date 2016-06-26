<?php
if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'list':
			require_once "controllers/cate/list.php";
			break;
		case 'add':
			require_once "controllers/cate/add.php";
			break;
		case 'edit':
			require_once "controllers/cate/edit.php";
			break;
		case 'del':
			require_once "controllers/cate/del.php";
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "controllers/cate/list.php";
}