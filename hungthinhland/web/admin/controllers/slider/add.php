<?php
$err = '';
if(isset($_POST['submit'])){
	$image = $position = $link = '';
	$check = getimagesize($_FILES["fImage"]["tmp_name"]);
	if($check !== false || $_FILES['fImage']['error'] == 0){
		$image = str_replace(' ','_',$_FILES['fImage']['name']);
	}else{
		$err[] = 'Vui lòng chọn hình ảnh!';
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
	if($image && $position && $link){
		$slider = new SLIDER;
		$slider->setImage($image);
		$slider->setPosition($position);
		$slider->setIsActived($active);
		$slider->setLink($link);
		if($slider->checkImageExist()){
			$slider->register();
			$upload = new UPLOAD($_FILES['fImage']['name'], $_FILES['fImage']['type'], $_FILES['fImage']['tmp_name'], $_FILES['fImage']['size']);
			$upload->process($image,'sliders');
			header("Location: index.php?controller=slider");
			exit();
		}else{
			$err[] = 'Hình ảnh này đã tồn tại.';
		}
	}
}
require "views/slider/views_add.php";
?>