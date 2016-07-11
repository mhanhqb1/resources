<?php
$err = '';
if(isset($_POST['submit'])){
	$image = $description = $detail = $title = '';
	$check = getimagesize($_FILES["fImage"]["tmp_name"]);
	if($check !== false || $_FILES['fImage']['error'] == 0){
		$image = str_replace(' ','_',$_FILES['fImage']['name']);
	}else{
		$err[] = 'Vui lòng chọn hình ảnh!';
	}
	if($_POST['txtDescription'] != ''){
		$description = $_POST['txtDescription'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['txtDetail'] != ''){
		$detail = $_POST['txtDetail'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['txtTitle'] != ''){
		$title = $_POST['txtTitle'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	$featured = $_POST['rdoFeatured'];
	$istintuc = $_POST['rdoTintuc'];
	if($image && $description && $detail && $title){
		$new = new NEWS;
		$new->setImage($image);
		$new->setTitle($title);
		$new->setDetail($detail);
		$new->setDescription($description);
		$new->setIsFeatured($featured);
		$new->setIsTintuc($istintuc);
		if($new->checkImageExist()){
			$new->insert();
			$upload = new UPLOAD($_FILES['fImage']['name'], $_FILES['fImage']['type'], $_FILES['fImage']['tmp_name'], $_FILES['fImage']['size']);
			$upload->process($image,'news');
			header("Location: index.php?controller=tintuc");
			exit();
		}else{
			$err[] = 'Hình ảnh này đã tồn tại.';
		}
	}
}
require "views/tintuc/views_add.php";
?>