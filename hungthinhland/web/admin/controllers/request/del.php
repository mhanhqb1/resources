<?php
if(isset($_GET['id'])){
	$company = new COMPANY;
	$data = $company->listOne($_GET['id']);
	$image = $data['image'];
	$company->delete($_GET['id']);
	unlink("../media/images/company/" . $image);
}
header("Location: index.php?controller=company");
exit();
?>