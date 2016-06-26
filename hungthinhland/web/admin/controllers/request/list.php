<?php
$request = new REQUEST;
$data = $request->listAll();
require "views/request/views_list.php";
?>