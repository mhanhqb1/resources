<?php
$err = '';
if(isset($_POST['submit'])){
	$email = $pass = $firstname = $lastname = $phone = '';
	if($_POST['txtEmail'] != ''){
		$email = $_POST['txtEmail'];
	}else{
		$err[] = 'Please enter email !';
	}
	if($_POST['txtPass'] != ''){
		$pass = $_POST['txtPass'];
	}else{
		$err[] = 'Please enter password !';
	}

	if($_POST['txtFirstName'] != ''){
		$firstname = $_POST['txtFirstName'];
	}else{
		$err[] = 'Please enter first name !';
	}

	if($_POST['txtLastName'] != ''){
		$lastname = $_POST['txtLastName'];
	}else{
		$err[] = 'Please enter last name !';
	}

	if($_POST['txtPhone'] != ''){
		$phone = $_POST['txtPhone'];
	}else{
		$err[] = 'Please enter phone !';
	}

	$level = $_POST['rdoLevel'];

	if($email && $pass && $firstname && $lastname && $phone){
		$user = new USER;
		$user->setEmail($email);
		$user->setPassword($pass);
		$user->setFirstName($firstname);
		$user->setLastName($lastname);
		$user->setPhone($phone);
		$user->setLevel($level);
		if($user->checkEmailExist()){
			$user->register();
			header("Location: index.php?controller=user&action=list");
			exit();
		}else{
			$err[] = 'Email has been exist';
		}
	}else{

	}
}
require "views/users/views_add.php";
?>