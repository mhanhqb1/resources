<?php
$user = new CONTACT;
$data = $user->listAll();
require "views/lienhe/views_list.php";
?>