<?php
if(isset($_GET['id'])){
	$slider = new SLIDER;
	$data = $slider->listOne($_GET['id']);
	$image = $data['image'];
	$slider->delete($_GET['id']);
	unlink("../media/images/sliders" . $image);
}
header("Location: index.php?controller=slider");
exit();
?>