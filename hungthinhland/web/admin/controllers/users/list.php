<?php
$user = new USER;
$data = $user->listAll();
require "views/users/views_list.php";
?>