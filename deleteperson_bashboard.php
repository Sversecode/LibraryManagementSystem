<?php
include("data_class.php");

$deletepersonid=$_GET['deletepersonid'];


$obj=new data();
$obj->setconnection();
$obj->deleteperson($deletepersonid);