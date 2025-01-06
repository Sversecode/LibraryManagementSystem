<?php
include("data_class.php");

$returnbookid=$_GET['returnbookid'];


$obj=new data();
$obj->setconnection();
$obj->returnbook($returnbookid);