<?php
$company = new COMPANY;
$data = $company->listAll();
require "views/company/views_list.php";
?>