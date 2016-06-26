<?php
$err = '';
$id = $_GET['id'];
$product = new PRODUCT;
$cateData = $product->listCate();
$check = true;
if(isset($_POST['submit'])){
	$image = $description = $name = $detail = $price = '';
	if($_FILES["fNewImage"]["tmp_name"] != ''){
		$check = getimagesize($_FILES["fNewImage"]["tmp_name"]);
		if($check !== false || $_FILES['fNewImage']['error'] == 0){
			$image = str_replace(' ','_',$_FILES['fNewImage']['name']);
		}else{
			$err[] = 'Vui lòng chọn hình ảnh!';
			$check = false;
		}
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
	if($check && $description && $name && $price && $detail){
		$product->setName($name);
		$product->setPrice($price);
		$product->setDetail($detail);
		$product->setDescription($description);
		$product->setIsActived($active);
		$product->setIsFeatured($feature);
		$product->setCateId($cate);
		if($image){
			$product->setImage($image);
			if($product->checkImageExist()){
				$upload = new UPLOAD($_FILES['fNewImage']['name'], $_FILES['fNewImage']['type'], $_FILES['fNewImage']['tmp_name'], $_FILES['fNewImage']['size']);
				$upload->process($image,'products');
				$product->update($id,$image);
				header("Location: index.php?controller=product");
				exit();
			}else{
				$err[] = 'Hình ảnh đã tồn tại.';
			}
			
		}else{
			$product->update($id);
			header("Location: index.php?controller=product");
			exit();
		}
		
		
	}
}
$data = $product->listOne($id);
require "views/product/views_edit.php";
?>