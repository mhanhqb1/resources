<?php
$cate = new CATE;
$data = $cate->listAll();
require "views/cate/views_list.php";
?>