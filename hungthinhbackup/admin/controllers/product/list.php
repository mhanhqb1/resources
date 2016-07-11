<?php
$product = new PRODUCT;
$data = $product->listAll();
require "views/product/views_list.php";
?>