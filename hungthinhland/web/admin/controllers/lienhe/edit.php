<?php
$err = '';
$id = $_GET['id'];
$contact = new CONTACT;
if(isset($_POST['submit'])){
	$email = $phone = $address = $name = $facebook = $twitter = $intagram = '';
	if($_POST['email'] != ''){
		$email = $_POST['email'];
	}else{
		$err[] = 'Vui lòng chọn email!';
	}
	if($_POST['phone'] != ''){
		$phone = $_POST['phone'];
	}else{
		$err[] = 'Vui lòng chọn phone!';
	}
	if($_POST['address'] != ''){
		$address = $_POST['address'];
	}else{
		$err[] = 'Vui lòng chọn address!';
	}
	if($_POST['facebook'] != ''){
		$facebook = $_POST['facebook'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['twitter'] != ''){
		$twitter = $_POST['twitter'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['name'] != ''){
		$name = $_POST['name'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['intagram'] != ''){
		$intagram = $_POST['intagram'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['yahoo'] != ''){
		$yahoo = $_POST['yahoo'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['skype'] != ''){
		$skype = $_POST['skype'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	if($_POST['tongdailienhe'] != ''){
		$tongdailienhe = $_POST['tongdailienhe'];
	}else{
		$err[] = 'Vui lòng chọn vị trí!';
	}
	$active = $_POST['rdoActived'];
	if($email && $phone && $address && $name && $facebook && $twitter && $intagram && $yahoo && $skype && $tongdailienhe){
		$contact->setEmail($email);
		$contact->setPhone($phone);
		$contact->setAddress($address);
		$contact->setIsActived($active);
		$contact->setName($name);
		$contact->setFacebook($facebook);
		$contact->setTwitter($twitter);
		$contact->setIntagram($intagram);
		$contact->setSkype($skype);
		$contact->setYahoo($yahoo);
		$contact->setTongdailienhe($tongdailienhe);
		$contact->update($id);
		header("Location: index.php?controller=lienhe");
		exit();
	}
}
$data = $contact->listOne($id);
require "views/lienhe/views_edit.php";
?>