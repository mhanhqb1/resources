<?php
$err = '';
$id = $_GET['id'];
$user = new USER;
if(isset($_POST['submit'])){
	$email = $firstname = $lastname = $phone = '';
	if($_POST['txtEmail'] != ''){
		$email = $_POST['txtEmail'];
	}else{
		$err[] = 'Please enter email !';
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

	if($email && $firstname && $lastname && $phone){
		$user->setEmail($email);
		$user->setFirstName($firstname);
		$user->setLastName($lastname);
		$user->setPhone($phone);
		$user->setLevel($level);
		if($user->checkEmailExist($id)){
			$user->update($id);
			header("Location: index.php?controller=user&action=list");
			exit();
		}else{
			$err[] = 'Email has been exist';
		}
	}else{

	}
}
$data = $user->listOne($id);
require "views/users/views_edit.php";
?>