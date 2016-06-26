<?php
if(isset($_GET['id'])){
	$contact = new CONTACT;
	$contact->delete($_GET['id']);
}
header("Location: index.php?controller=lienhe");
exit();
?>