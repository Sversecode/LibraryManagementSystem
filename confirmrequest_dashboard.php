<?php
include("data_class.php");
$userid=$_SESSION["userid"];
$confirmrequestid=$_GET['confirmrequestid'];
$issueid=$_GET['issueid'];


$obj=new data();
$obj->setconnection();
$obj->confirmrequest($confirmrequestid,$issueid,$userid);
