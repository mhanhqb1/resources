<?php
$err = '';
$id = $_GET['id'];
$introduction = new INTRODUCTION;
if(isset($_POST['submit'])){
	$content = $active = '';
	if($_POST['content'] != ''){
		$content = $_POST['content'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	$active = $_POST['rdoActived'];
	if($content){
		$introduction->setContent($content);
		$introduction->setIsActived($active);
		$introduction->update($id);
		header("Location: index.php?controller=gioithieu");
		exit();
	}
}
$data = $introduction->listOne($id);
require "views/gioithieu/views_edit.php";
?>