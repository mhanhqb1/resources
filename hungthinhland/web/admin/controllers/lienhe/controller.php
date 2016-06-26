<?php
if(isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'list':
			require_once "controllers/lienhe/list.php";
			break;
		case 'add':
			require_once "controllers/lienhe/add.php";
			break;
		case 'edit':
			require_once "controllers/lienhe/edit.php";
			break;
		case 'del':
			require_once "controllers/lienhe/del.php";
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "controllers/lienhe/list.php";
}