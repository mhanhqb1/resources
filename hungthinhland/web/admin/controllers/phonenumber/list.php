<?php
$phonenumber = new PHONENUMBER;
$data = $phonenumber->listAll();
require "views/phonenumber/views_list.php";
?>