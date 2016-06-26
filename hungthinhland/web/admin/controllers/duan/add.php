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
	if($_POST['txtPrice'] != ''){
		$price = $_POST['txtPrice'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['txtThongtin'] != ''){
		$thongtin = $_POST['txtThongtin'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['txtVitri'] != ''){
		$vitri = $_POST['txtVitri'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['txtTienich'] != ''){
		$tienich = $_POST['txtTienich'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['txtMatbang'] != ''){
		$matbang = $_POST['txtMatbang'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['txtTintuc'] != ''){
		$tintuc = $_POST['txtTintuc'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['txtHinhanh'] != ''){
		$hinhanh = $_POST['txtHinhanh'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['txtVitrihienthi'] != ''){
		$vitrihienthi = $_POST['txtVitrihienthi'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	$featured = $_POST['rdoFeatured'];
	$dautu = $_POST['rdoDautu'];
	$giatot = $_POST['rdoGiatot'];
	$moi = $_POST['rdoMoi'];
	if($image && $description && $detail && $title && $thongtin && $price && $tintuc && $vitrihienthi){
		$new = new DUAN;
		$new->setImage($image);
		$new->setTitle($title);
		$new->setDetail($detail);
		$new->setDescription($description);
		$new->setIsFeatured($featured);
		$new->setIsDautu($dautu);
		$new->setIsGiatot($giatot);
		$new->setIsMoi($moi);
		$new->setPrice($price);
		$new->setVitrihienthi($vitrihienthi);
		$new->setThongtin($thongtin);
		$new->setVitri($vitri);
		$new->setTienich($tienich);
		$new->setMatbang($matbang);
		$new->setTintuc($tintuc);
		$new->setHinhanh($hinhanh);
		if($new->checkImageExist()){
			$new->insert();
			$upload = new UPLOAD($_FILES['fImage']['name'], $_FILES['fImage']['type'], $_FILES['fImage']['tmp_name'], $_FILES['fImage']['size']);
			$upload->process($image,'duan');
			header("Location: index.php?controller=duan");
			exit();
		}else{
			$err[] = 'Hình ảnh này đã tồn tại.';
		}
	}
}
require "views/duan/views_add.php";
?>