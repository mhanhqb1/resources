<?php
if(isset($_GET['id'])){
	$introduction = new INTRODUCTION;
	$introduction->delete($_GET['id']);
}
header("Location: index.php?controller=gioithieu");
exit();
?>