<?php
$err = '';
$id = $_GET['id'];
$cate = new CATE;
if(isset($_POST['submit'])){
	$name= '';
	
	if($_POST['txtName'] != ''){
		$name = $_POST['txtName'];
	}else{
		$err[] = 'Vui lòng nhập tên!';
	}
	if($name){
		$cate->setName($name);
		$cate->update($id);
		header("Location: index.php?controller=cate");
		exit();
	}
}
$data = $cate->listOne($id);
require "views/cate/views_edit.php";
?>