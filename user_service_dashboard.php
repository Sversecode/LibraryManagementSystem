<?php

include("data_class.php");

// Start the session


// Check if the session variables are set
if (isset($_SESSION["userid"]) && isset($_SESSION["email"])) {
    $userid = $_SESSION["userid"];
    $email = $_SESSION["email"];
} else {
    // Redirect to login page if the session variables are not set
    header("Location:index.html?msg=Please login first.");
    exit();
}
?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="dashboardStyle.css">
       
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="container">
        
        <div class="innerdivi">
        <div class="row"></div><img class="logoimg" src="images/logo.PNG"/></div>   
                
            <div class="leftdivi">
                <Button class="btn">USER</Button>
                <Button class="btn" onclick="openpart('bookreport')"> BOOK REPORT</Button>
                <Button class="btn" onclick="openpart('booksyouhave')">BOOKS YOU HAVE</Button>
                <Button class="btn" onclick="openpart('issuebookreport')"> ISSUE REPORT</Button>
                <Button class="btn" onclick="openpart('requeststatus')"> REQUEST STATUS</Button>
                <Button class="btn" onclick="openpart('requestforyou')"> REQUEST FOR YOU </Button>
                <a href="index.html"><button class="btn">LOGOUT</button></a>

            </div>

            <div class="rightinnerdiv">   
            <div id="bookreport" class="rightinnerdivportion" style="display:none">
            <Button class="btn" > RECORD</Button>
            <?php
            $u=new data;
            $u->setconnection();
            
            $recordset=$u->getbook();

            $table="<table style='font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;'>
                 <tr>
                        <th style='padding: 8px;'>Book Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>View</th>
                    </tr>";
            foreach($recordset as $row){
                $table.="<tr>";
               "<td>$row[0]</td>";
                $table.="<td>$row[1]</td>";
                $table.="<td>$row[7]</td>";
                $table.="<td>$row[6]</td>";
                $table .= "<td><img src='uploads/{$row[8]}' alt='Book Image' style='width:100px;height:100px;'/></td>"; // Assuming column 4 is Image filename
                $table.="<td><a href='user_service_dashboard.php?viewid=$row[0]'><button type='button' class='btnprimary'>View BOOK</button></a></td>";
                
                $table.="</tr>";
                
            }
            $table.="</table>";

            echo $table;
            ?>

            </div>
        </div>

        <div class="rightinnerdiv">   
    <div id="booksyouhave" class="rightinnerdivportion" style="display:none">
        <Button class="btn">BOOKS YOU HAVE</Button>
        <?php
        $u = new data();
        $u->setconnection();

        $recordset = $u->getbooksyouhave($email);  // Fetch books for the user

        if (!empty($recordset)) {  // Check if the result set is not empty
            $table = "<table style='font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;'>
                        <tr>
                            <th style='padding: 8px;'>Name</th>
                            <th>Book</th>
                            <th>Author</th>
                            <th>Publication</th>
                            <th>Date</th>
                        </tr>";

            foreach ($recordset as $row) {
                $table .= "<tr>";
                $table .= "<td>{$row['name']}</td>";    // Adjust column names as per your DB schema
                $table .= "<td>{$row['bookname']}</td>";
                $table .= "<td>{$row['bookauthor']}</td>";
                $table .= "<td>{$row['bookpub']}</td>";
                $table .= "<td>{$row['date']}</td>";
                $table .= "</tr>";
            }
            $table .= "</table>";

            echo $table;
        } else {
            echo "<p>No books found for this user.</p>";
        }
        ?>
    </div>
</div>

<div class="rightinnerdiv">
        <div id="issuebookreport" class="rightinnerdivportion" style="display:none">
        <Button class="btn">ISSUE REPORT</Button>
        <?php
        $w = new data;
        $w->setconnection();
        $recordset = $w->getissuebook(); 

        $table = "<table style='font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                        <th style='padding: 8px;'>Name</th>
                        <th>Email</th>
                        <th>Book</th>
                        <th>Author</th>
                        <th>Publication</th>
                        <th>Date</th>
                    </tr>";
        foreach ($recordset as $row) {
            if($row[2]!=$email){
            $table .= "<tr>";
            $table .= "<td>$row[1]</td>";  // Assuming the first column is person name
            $table .= "<td>$row[2]</td>";  // Assuming the second column is email
            $table .= "<td>$row[3]</td>";
            $table .= "<td>$row[4]</td>";
            $table .= "<td>$row[5]</td>";
            $table .= "<td>$row[6]</td>";
            $table .= "<td><a href='requestbook_dashboard.php?requestbookid=$row[0]'>Request</a></td>";
            $table .= "</tr>";}
        }
        $table .= "</table>";

        echo $table;
        ?>
    </div>
</div>

<div class="rightinnerdiv">
        <div id="requeststatus" class="rightinnerdivportion" style="display:none">
        <Button class="btn">REQUEST STATUS</Button>
        <?php
        $w = new data;
        $w->setconnection();
        $recordset = $w->getrequestbookstatus($userid); 

        $table = "<table style='font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                        <th style='padding: 8px;'>ID</th>
                        <th>To:Name</th>
                        <th>Email</th>
                        <th>Book</th>
                        <th>Author</th>
                        <th>Publication</th>
                        <th>Status</th>
                        
                    </tr>";
        foreach ($recordset as $row) {
            $table .= "<tr>";
            $table .= "<td>$row[0]</td>";
            $table .= "<td>$row[4]</td>";  // Assuming the first column is person name
            $table .= "<td>$row[3]</td>";  // Assuming the second column is email
            $table .= "<td>$row[5]</td>";
            $table .= "<td>$row[6]</td>";
            $table .= "<td>$row[7]</td>";
            $table .= "<td>$row[9]</td>";
            if($row[9]=='Accepted'){
                $table .= "<td><a href='confirmrequest_dashboard.php?confirmrequestid={$row[0]}&issueid={$row[10]}'>Confirm</a></td>";
            }
           
            $table .= "</tr>";
        }
        $table .= "</table>";

        echo $table;
        ?>
    </div>
</div>

<div class="rightinnerdiv">
        <div id="requestforyou" class="rightinnerdivportion" style="display:none">
        <Button class="btn">REQUEST FOR YOU</Button>
        <?php
        $w = new data;
        $w->setconnection();
        $recordset = $w->getrequestforyou($userid); 

        $table = "<table style='font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                        <th style='padding: 8px;'>ID</th>
                        <th>From:Name</th>
                        <th>Email</th>
                        <th>Book</th>
                        <th>Author</th>
                        <th>Publication</th>
                        <th>Status</th>
                        
                    </tr>";
        foreach ($recordset as $row) {
            $table .= "<tr>";
            $table .= "<td>$row[0]</td>";
            $table .= "<td>$row[2]</td>";  // Assuming the first column is person name
            $table .= "<td>$row[1]</td>";  // Assuming the second column is email
            $table .= "<td>$row[5]</td>";
            $table .= "<td>$row[6]</td>";
            $table .= "<td>$row[7]</td>";
            $table .= "<td>$row[9]</td>";
            $table .= "<td><a href='acceptrequest_dashboard.php?acceptrequestid=$row[0]'>Accept</a></td>";
            $table .= "<td><a href='unacceptrequest_dashboard.php?unacceptrequestid=$row[0]'>Unaccept</a></td>";
            
            //$table .= "<td><a href='requestbook_dashboard.php?requestbookid=$row[0]'>Request</a></td>";
            $table .= "</tr>";
        }
        $table .= "</table>";

        echo $table;
        ?>
    </div>
</div>
        
        <script >
            function openpart(portion){
                var i;
                var x=document.getElementsByClassName("rightinnerdivportion");
                for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";  
        }
        document.getElementById(portion).style.display = "block";
            }
        </script>
    </body>
</html>