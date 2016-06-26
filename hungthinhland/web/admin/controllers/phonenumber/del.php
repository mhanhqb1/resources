<?php
if(isset($_GET['id'])){
	$phonenumber = new PHONENUMBER;
	$data = $phonenumber->listOne($_GET['id']);
	$phonenumber->delete($_GET['id']);
}
header("Location: index.php?controller=phonenumber");
exit();
?>