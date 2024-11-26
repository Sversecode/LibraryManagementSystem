<?php

include("data_class.php");
$name=$_POST['name'];
$email=$_POST['email'];  
$bookname=$_POST['bookname'];
$bookauthor=$_POST['bookauthor'];
$bookpub=$_POST['bookpub'];
$issuedate=$_POST['issuedate'];

$obj=new data();
$obj->setconnection();
$obj->issuenewbook($name,$email,$bookname,$bookauthor,$bookpub,$issuedate);