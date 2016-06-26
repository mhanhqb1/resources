<?php
$err = '';
$id = $_GET['id'];
$company = new company;
$check = true;
if(isset($_POST['submit'])){
	$image = $name = $website = '';
	if($_FILES["fNewImage"]["tmp_name"] != ''){
		$check = getimagesize($_FILES["fNewImage"]["tmp_name"]);
		if($check !== false || $_FILES['fNewImage']['error'] == 0){
			$image = str_replace(' ','_',$_FILES['fNewImage']['name']);
		}else{
			$err[] = 'Vui lòng chọn hình ảnh!';
			$check = false;
		}
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
	if($check && $name && $website){
		$company->setName($name);
		$company->setWebsite($website);
		$company->setIsActived($active);
		if($image){
			$company->setImage($image);
			if($company->checkImageExist()){
				$upload = new UPLOAD($_FILES['fNewImage']['name'], $_FILES['fNewImage']['type'], $_FILES['fNewImage']['tmp_name'], $_FILES['fNewImage']['size']);
				$upload->process($image,'company');
				$company->update($id,$image);
				header("Location: index.php?controller=company");
				exit();
			}else{
				$err[] = 'Hình ảnh đã tồn tại.';
			}
			
		}else{
			$company->update($id);
			header("Location: index.php?controller=company");
			exit();
		}
		
		
	}
}
$data = $company->listOne($id);
require "views/company/views_edit.php";
?>