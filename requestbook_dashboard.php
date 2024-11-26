<?php
include("data_class.php");

$requestbookid=$_GET['requestbookid'];
$userid=$_SESSION["userid"];


$obj=new data();
$obj->setconnection();
$obj->requestbook($requestbookid,$userid);