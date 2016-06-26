<?php
if(isset($_GET['id'])){
	$product = new PRODUCT;
	$data = $product->listOne($_GET['id']);
	$image = $data['image'];
	$product->delete($_GET['id']);
	unlink("../media/images/products/" . $image);
}
header("Location: index.php?controller=product");
exit();
?>