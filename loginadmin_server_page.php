<?php
include("data_class.php");
$login_email=$_GET['login_email'];
$login_password=$_GET['login_password'];

if($login_email==null|| $login_password==null){
    $mailmsg="";
 $pasdmsg="";
    if($login_email== null){
        $mailmsg= "Email Empty";
    }
    if($login_password==null){
        $pasdmsg="Password Empty";}

    header("Location:index.html?ademailmsg=$mailmsg&adpasdmsg=$pasdmsg");

}
elseif($login_password!=null&& $login_password!= null){
    $obj=new data();
    $obj->setconnection();
    $obj->adminLogin($login_email,$login_password);  
}
