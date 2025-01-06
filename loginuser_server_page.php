
<?php
include("data_class.php");

$login_email = $_GET['login_email'];
$login_pasword = $_GET['login_pasword'];

$mailmsg = "";
$passmsg = "";

// Check if email is empty
if ($login_email == null) {
    $mailmsg = "Email Empty";
}

// Check if password is empty
if ($login_pasword == null) {
    $passmsg = "Password Empty";
}

// If either field is empty, redirect back to the login page with relevant error messages
if ($mailmsg != "" || $passmsg != "") {
    header("Location:index.html?emailmsg=$mailmsg&pasdmsg=$passmsg");
} else {
    // If both fields are filled, proceed to login
    $obj = new data();
    $obj->setconnection();
    $obj->userLogin($login_email, $login_pasword);
}
