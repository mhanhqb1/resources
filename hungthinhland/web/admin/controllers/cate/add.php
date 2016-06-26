<?php
$err = '';
if(isset($_POST['submit'])){
	$name = '';
	if($_POST['txtName'] != ''){
		$name = $_POST['txtName'];
	}else{
		$err[] = 'Vui lòng nhập tên!';
	}
	if($name){
		$cate = new CATE;
		$cate->setName($name);
		$cate->insert();
		header("Location: index.php?controller=cate");
		exit();
	}
}
require "views/cate/views_add.php";
?>