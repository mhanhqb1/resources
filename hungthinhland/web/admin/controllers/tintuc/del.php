<?php
if(isset($_GET['id'])){
	$tintuc = new NEWS;
	$data = $tintuc->listOne($_GET['id']);
	$image = $data['image'];
	$tintuc->delete($_GET['id']);
	unlink("../media/images/news/" . $image);
}
header("Location: index.php?controller=tintuc");
exit();
?>