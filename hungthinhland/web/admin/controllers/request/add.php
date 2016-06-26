<?php
$err = '';
if(isset($_POST['submit'])){
	$image = $name = $website = '';
	$check = getimagesize($_FILES["fImage"]["tmp_name"]);
	if($check !== false || $_FILES['fImage']['error'] == 0){
		$image = str_replace(' ','_',$_FILES['fImage']['name']);
	}else{
		$err[] = 'Vui lòng chọn hình ảnh!';
	}
	if($_POST['txtName'] != ''){
		$name = $_POST['txtName'];
	}else{
		$err[] = 'Vui lòng nhập tên sản phẩm!';
	}
	if($_POST['txtWebsite'] != ''){
		$website = $_POST['txtWebsite'];
	}else{
		$err[] = 'Vui lòng nhập thông tin chi tiết sản phẩm!';
	}
	$active = $_POST['rdoActived'];
	if($image && $name && $website){
		$company = new COMPANY;
		$company->setName($name);
		$company->setImage($image);
		$company->setWebsite($website);
		$company->setIsActived($active);
		if($company->checkImageExist()){
			$company->insert();
			$upload = new UPLOAD($_FILES['fImage']['name'], $_FILES['fImage']['type'], $_FILES['fImage']['tmp_name'], $_FILES['fImage']['size']);
			$upload->process($image,'company');
			header("Location: index.php?controller=company");
			exit();
		}else{
			$err[] = 'Hình ảnh này đã tồn tại.';
		}
	}
}
require "views/company/views_add.php";
?>