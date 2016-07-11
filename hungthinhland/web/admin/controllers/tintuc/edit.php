<?php
$err = '';
$id = $_GET['id'];
$new = new NEWS;
$check = true;
if(isset($_POST['submit'])){
	$image = $description = $detail = $title = '';
	if($_FILES["fNewImage"]["tmp_name"] != ''){
		$check = getimagesize($_FILES["fNewImage"]["tmp_name"]);
		if($check !== false || $_FILES['fNewImage']['error'] == 0){
			$image = str_replace(' ','_',$_FILES['fNewImage']['name']);
		}else{
			$err[] = 'Vui lòng chọn hình ảnh!';
		}
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
	if($check && $description && $detail && $title){
		$new->setTitle($title);
		$new->setDetail($detail);
		$new->setDescription($description);
		$new->setIsFeatured($featured);
		$new->setIsTintuc($istintuc);
		if($image){
			$new->setImage($image);
			if($new->checkImageExist()){
				$upload = new UPLOAD($_FILES['fNewImage']['name'], $_FILES['fNewImage']['type'], $_FILES['fNewImage']['tmp_name'], $_FILES['fNewImage']['size']);
				$upload->process($image,'news');
				$new->update($id,$image);
				header("Location: index.php?controller=tintuc");
				exit();
			}else{
				$err[] = 'Hình ảnh đã tồn tại.';
			}
			
		}else{
			$new->update($id);
			header("Location: index.php?controller=tintuc");
			exit();
		}
		
		
	}
}
$data = $new->listOne($id);
require "views/tintuc/views_edit.php";
?>