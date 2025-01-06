<?php
include("data_class.php");

$acceptrequestid=$_GET['acceptrequestid'];


$obj=new data();
$obj->setconnection();
$obj->acceptrequest($acceptrequestid);