<?php
$err = '';
$id = $_GET['id'];
$slider = new SLIDER;
$check = true;
if(isset($_POST['submit'])){
	$image = $position = $link = '';
	if($_FILES["fNewImage"]["tmp_name"] != ''){
		$check = getimagesize($_FILES["fNewImage"]["tmp_name"]);
		if($check !== false || $_FILES['fNewImage']['error'] == 0){
			$image = str_replace(' ','_',$_FILES['fNewImage']['name']);
		}else{
			$err[] = 'Vui lòng chọn hình ảnh!';
		}
	}
	if($_POST['txtPosition'] != ''){
		$position = $_POST['txtPosition'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['txtLink'] != ''){
		$link = $_POST['txtLink'];
	}else{
		$err[] = 'Vui lòng chọn link!';
	}
	$active = $_POST['rdoActive'];
	if($check && $position && $link){
		$slider->setPosition($position);
		$slider->setIsActived($active);
		$slider->setLink($link);
		if($image){
			$slider->setImage($image);
			if($slider->checkImageExist()){
				$upload = new UPLOAD($_FILES['fNewImage']['name'], $_FILES['fNewImage']['type'], $_FILES['fNewImage']['tmp_name'], $_FILES['fNewImage']['size']);
				$upload->process($image,'sliders');
				$slider->update($id,$image);
				header("Location: index.php?controller=slider");
				exit();
			}else{
				$err[] = 'Hình ảnh đã tồn tại.';
			}
			
		}else{
			$slider->update($id);
			header("Location: index.php?controller=slider");
			exit();
		}
		
		
	}
}
$data = $slider->listOne($id);
require "views/slider/views_edit.php";
?>