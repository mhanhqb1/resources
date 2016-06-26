<?php
$err = '';
if(isset($_POST['submit'])){
	$content = '';
	if($_POST['content'] != ''){
		$content = $_POST['content'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	$active = $_POST['rdoActived'];
	if($content){
		$introduction = new INTRODUCTION;
		$introduction->setContent($content);
		$introduction->setIsActived($active);
		$introduction->insert();
		header("Location: index.php?controller=gioithieu");
		exit();
	}
}
require "views/gioithieu/views_add.php";
?>