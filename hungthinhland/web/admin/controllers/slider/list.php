<?php
$user = new SLIDER;
$data = $user->listAll();
require "views/slider/views_list.php";
?>