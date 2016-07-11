<?php
if(isset($_GET['id'])){
	$user = new USER;
	$user->delete($_GET['id']);
}
header("Location: index.php?controller=user&action=list");
exit();
?>