<?php
if(isset($_GET['id'])){
	$duan = new DUAN;
	$data = $duan->listOne($_GET['id']);
	$image = $data['image'];
	$duan->delete($_GET['id']);
	unlink("../media/images/duan/" . $image);
}
header("Location: index.php?controller=duan");
exit();
?>