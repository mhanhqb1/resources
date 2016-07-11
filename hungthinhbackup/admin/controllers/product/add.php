<?php
$err = '';
$product = new PRODUCT;
$cateData = $product->listCate();
if(isset($_POST['submit'])){
	$image = $description = $name = $detail = $price = '';
	$check = getimagesize($_FILES["fImage"]["tmp_name"]);
	if($check !== false || $_FILES['fImage']['error'] == 0){
		$image = str_replace(' ','_',$_FILES['fImage']['name']);
	}else{
		$err[] = 'Vui lòng chọn hình ảnh!';
	}
	if($_POST['txtDescription'] != ''){
		$description = $_POST['txtDescription'];
	}else{
		$err[] = 'Vui lòng nhập giới thiệu sản phẩm!';
	}
	if($_POST['txtName'] != ''){
		$name = $_POST['txtName'];
	}else{
		$err[] = 'Vui lòng nhập tên sản phẩm!';
	}
	if($_POST['txtPrice'] != ''){
		$price = $_POST['txtPrice'];
	}else{
		$err[] = 'Vui lòng nhập giá sản phẩm!';
	}
	if($_POST['txtDetail'] != ''){
		$detail = $_POST['txtDetail'];
	}else{
		$err[] = 'Vui lòng nhập thông tin chi tiết sản phẩm!';
	}
	$active = $_POST['rdoActived'];
	$feature = $_POST['rdoFeatured'];
	$cate = $_POST['cate'];
	if($image && $description && $name && $price && $detail){
		$product->setName($name);
		$product->setPrice($price);
		$product->setImage($image);
		$product->setDetail($detail);
		$product->setDescription($description);
		$product->setIsActived($active);
		$product->setIsFeatured($feature);
		$product->setCateId($cate);
		if($product->checkImageExist()){
			$product->insert();
			$upload = new UPLOAD($_FILES['fImage']['name'], $_FILES['fImage']['type'], $_FILES['fImage']['tmp_name'], $_FILES['fImage']['size']);
			$upload->process($image,'products');
			header("Location: index.php?controller=product");
			exit();
		}else{
			$err[] = 'Hình ảnh này đã tồn tại.';
		}
	}
}
require "views/product/views_add.php";
?>