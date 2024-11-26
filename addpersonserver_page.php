<?php
echo "ddwjicvwdv";
include("data_class.php");
$addname=$_POST['addname'];
$addemail=$_POST['addemail'];  
$addpass=$_POST['addpass'];
$type=$_POST['type'];

$obj=new data();
$obj->setconnection();
$obj->addnewuser($addname,$addemail,$addpass,$type);