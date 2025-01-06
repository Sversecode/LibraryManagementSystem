<?php
include("data_class.php");


$adminid= $_SESSION["adminid"];
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
        <style>
            
           
            

        </style>

    </head>

    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">
        
        <div class="innerdivi">
        <div class="row"></div><img class="logoimg" src="images/logo.PNG"/></div>   
                
            <div class="leftdivi">
                <Button class="btn" >Admin</Button>
                <Button class="btn" onclick="openpart('addbook')"> ADD BOOK</Button>
                <Button class="btn" onclick="openpart('bookreport')"> BOOK REPORT</Button>
                
                <Button class="btn" onclick="openpart('addstudent')"> ADD PERSON</Button>
                <Button class="btn" onclick="openpart('personreport')"> PERSON REPORT</Button>
                <Button class="btn" onclick="openpart('issuebook')"> ISSUE BOOK</Button>
                <Button class="btn" onclick="openpart('issuebookreport')"> ISSUE REPORT</Button>
                <a href="index.html"><button class="btn">LOGOUT</button></a>

            </div>
            <div class="rightinnerdiv">
                <div id="addstudent" class="rightinnerdivportion" style="display:none" >
                    <Button class="btn">ADD PERSON</Button>
                    <form action="addpersonserver_page.php" method="post">
        <label f>Name: <input type="text"  name="addname" ></label><br>
       

        <label >Email:<input type="email"  name="addemail" ><br></label><br>
        

        <label >Password:<input type="password"  name="addpass" ><br></label><br>
        

        <label >Choose Type:::<select  name="type" >
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
        </select><br></label><br>
        

        <input type="submit" value="Submit">
    </form>
               </div>
            </div>
            <div class="rightinnerdiv">   
            <div id="addbook" class="rightinnerdivportion" style="display:none">
            <Button class="btn" >ADD NEW BOOK</Button>
            <br>
            <form action="addbookserver_page.php" method="post" enctype="multipart/form-data">
            <label>Book Name:</label><input type="text" name="bookname"/>
            <br>
            <label>Detail:</label><input  type="text" name="bookdetail"/><br>
            <label>Autor:</label><input type="text" name="bookauthor"/><br>
            <label>Publication</label><input type="text" name="bookpub"/><br>
            <label>Branch:</label><input type="radio" name="branch" value="other"/>Other<input type="radio" name="branch" value="ECE" style="margin-left:80px"/>ECE<div><input type="radio" name="branch" value="CSE"/>CSE<input type="radio" name="branch" value="MECH" style="margin-left:80px"/>MECH</div>
               
            <label>Price:</label><input  type="number" name="bookprice"/><br>
            <label>Quantity:</label><input type="number" name="bookquantity"/><br>
            <label>Book Photo:</label><input  type="file" name="bookphoto"/><br>
            <br>
   
            <input type="submit" value="SUBMIT"/>
            <br>
            <br>

            </form>
            </div>
            </div>

            <div class="rightinnerdiv">   
            <div id="bookreport" class="rightinnerdivportion" style="display:none">
            <Button class="btn" >BOOK RECORD</Button>
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
                $table.="<td><a href='admin_service_dashboard.php?viewid=$row[0]'><button type='button' class='btnprimary'>View BOOK</button></a></td>";
                $table.="<td><a href='deletebook_dashboard.php?deletebookid=$row[0]'>Delete</a></td>";
                $table.="</tr>";
                
            }
            $table.="</table>";

            echo $table;
            ?>

            </div>
        </div>
        <div class="rightinnerdiv">
        <div id="personreport" class="rightinnerdivportion" style="display:none">
        <Button class="btn">PERSON REPORT</Button>
        <?php
        $w = new data;
        $w->setconnection();
        $recordset = $w->getperson();  // Get the person data

        $table = "<table style='font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;'>
                    <tr>
                        <th style='padding: 8px;'>Person Name</th>
                        <th>Email</th>
                        <th>Type</th>
                    </tr>";
        foreach ($recordset as $row) {
            $table .= "<tr>";
            $table .= "<td>$row[1]</td>";  // Assuming the first column is person name
            $table .= "<td>$row[2]</td>";  // Assuming the second column is email
            $table .= "<td>$row[4]</td>";  // Assuming the third column is type (student/admin)
            $table .= "<td><a href='deleteperson_bashboard.php?deletepersonid=$row[0]'>Delete</a></td>";
            $table .= "</tr>";
        }
        $table .= "</table>";

        echo $table;
        ?>
    </div>
</div>
             
    <div class="rightinnerdiv">   
            <div id="issuebook" class="rightinnerdivportion" style="display:none">
            <Button class="btn" >ISSUE BOOK</Button>
            <br>
            <form action="issuebookserver_page.php" method="post" enctype="multipart/form-data">
            <label>Name:</label><input type="text" name="name" /><br>
            <label>Email</label><input  type="email" name="email"/><br>
            <label>Book Name:</label><input type="text" name="bookname"/><br>
            <label>Autor:</label><input type="text" name="bookauthor"/><br>
            <label>Publication</label><input type="text" name="bookpub"/><br>
            <label>Date:</label><input type="date" name="issuedate"/><br>
            <br>
   
            <input type="submit" value="ISSUE"/>
            <br>
            <br>

            </form>
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
            $table .= "<tr>";
            $table .= "<td>$row[1]</td>";  // Assuming the first column is person name
            $table .= "<td>$row[2]</td>";  // Assuming the second column is email
            $table .= "<td>$row[3]</td>";
            $table .= "<td>$row[4]</td>";
            $table .= "<td>$row[5]</td>";
            $table .= "<td>$row[6]</td>";
            $table .= "<td><a href='returnbook_bashboard.php?returnbookid=$row[0]'>Return</a></td>";
            $table .= "</tr>";
        }
        $table .= "</table>";

        echo $table;
        ?>
    </div>
</div>
         
    </div>
        </s>
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