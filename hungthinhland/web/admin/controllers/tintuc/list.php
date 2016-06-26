<?php
$user = new NEWS;
$data = $user->listAll();
require "views/tintuc/views_list.php";
?>