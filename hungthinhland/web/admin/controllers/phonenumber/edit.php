<?php
$err = '';
$id = $_GET['id'];
$phonenumber = new PHONENUMBER;
$check = true;
if(isset($_POST['submit'])){
	$phone = $name = $vitri = '';
	if($_POST['txtPhone'] != ''){
		$phone = $_POST['txtPhone'];
	}else{
		$err[] = 'Vui lòng nhập phone number!';
	}
	if($_POST['txtName'] != ''){
		$name = $_POST['txtName'];
	}else{
		$err[] = 'Vui lòng nhập tên sản phẩm!';
	}
	if($_POST['txtVitri'] != ''){
		$vitri = $_POST['txtVitri'];
	}else{
		$err[] = 'Vui lòng nhập thông tin chi tiết sản phẩm!';
	}
	$active = $_POST['rdoActived'];
	$lienhe = $_POST['rdoLienhe'];
	if($phone && $name && $vitri){
		$phonenumber->setName($name);
		$phonenumber->setPhone($phone);
		$phonenumber->setVitri($vitri);
		$phonenumber->setIsActived($active);
		$phonenumber->setIsLienhe($lienhe);
		$phonenumber->update($id);
		header("Location: index.php?controller=phonenumber");
		exit();
	}
}
$data = $phonenumber->listOne($id);
require "views/phonenumber/views_edit.php";
?>