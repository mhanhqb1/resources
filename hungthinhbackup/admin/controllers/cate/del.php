<?php
if(isset($_GET['id'])){
	$cate = new CATE;
	$cate->delete($_GET['id']);
}
header("Location: index.php?controller=cate");
exit();
?>