<?php
include("data_class.php");

$unacceptrequestid=$_GET['unacceptrequestid'];


$obj=new data();
$obj->setconnection();
$obj->unacceptrequest($unacceptrequestid);