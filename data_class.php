<?php

include("db.php");
session_start();
class data extends db{

    private $bookpic;
    private $bookname;
    private $bookdetail;
    private $bookaudor;
    private $bookpub;
    private $branch;
    private $bookprice;
    private $bookquantity;
    private $type;

    private $book;
    private $userselect;
    private $days;
    private $getdate;
    private $returnDate;
    function __construct() {
        // Initialize the connection here (assuming you have a connection setup method)
        // Example: $this->connection = new PDO(...);
    }

    // Admin Login with prepared statement and hashed password verification
     function adminLogin($t1,$t2){
        $q="SELECT * FROM admin where email='$t1' and Pass='$t2'";
        $recordSet=$this->connection->query($q);
        $result=$recordSet->rowCount();

        if($result> 0){
            foreach($recordSet->fetchAll() as $row){
                $logid=$row['id'];
                $_SESSION["adminid"]= $logid;
            
            header("Location:admin_service_dashboard.php");}
        }
        else{
            header("Location:index.html?msg=Invalid Credentials");
        }
    }

    function userLogin($t3, $t4) {
        // Prepare the SQL query to prevent SQL injection
        $q = "SELECT * FROM userdata WHERE email = :email";
        $stmt = $this->connection->prepare($q);
        $stmt->bindParam(':email', $t3);
        $stmt->execute();
        
        // Check if the user exists
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Verify the entered password with the hashed password in the database
            if (password_verify($t4, $user['pass'])) {
                // Password matches, login successful
                $_SESSION["userid"] = $user['id'];
                $_SESSION["email"] = $user['email'];
                
                // Debugging session storage
                //print_r($_SESSION);  // Check if the email is being stored
    
                header("Location:user_service_dashboard.php");
            } else {
                // Invalid password
                header("Location:index.html?msg=Invalid Credentials");
            }
        } else {
            // User not found
            header("Location:index.html?msg=Invalid Credentials");
        }
    }
    

    // Add new user with hashed password
    function addnewuser($name, $email, $password, $type) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Hash the password
            $q = "INSERT INTO userdata (name, email, pass, type) VALUES (:name, :email, :password, :type)";
            $stmt = $this->connection->prepare($q);

            // Bind the parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);  // Save the hashed password
            $stmt->bindParam(':type', $type);

            if ($stmt->execute()) {
                header("Location: admin_service_dashboard.php?msg=New add done");
            } else {
                header("Location: admin_service_dashboard.php?msg=New addition failed");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Add a new book
    function addbook($bookpic, $bookname, $bookdetail, $bookauthor, $bookpub, $branch, $bookprice, $bookquantity) {
        try {
            $q = "INSERT INTO bookdata (bookname, bookauthor, bookpub, bookdetails, branch, quantity, price, bookpic) 
                  VALUES (:bookname, :bookauthor, :bookpub, :bookdetails, :branch, :quantity, :price, :bookpic)";
            $stmt = $this->connection->prepare($q);

            // Bind the parameters
            $stmt->bindParam(':bookname', $bookname);
            $stmt->bindParam(':bookauthor', $bookauthor);
            $stmt->bindParam(':bookpub', $bookpub);
            $stmt->bindParam(':bookdetails', $bookdetail);
            $stmt->bindParam(':branch', $branch);
            $stmt->bindParam(':quantity', $bookquantity);
            $stmt->bindParam(':price', $bookprice);
            $stmt->bindParam(':bookpic', $bookpic);

            if ($stmt->execute()) {
                header("Location: admin_service_dashboard.php?msg=New add done");
            } else {
                header("Location: admin_service_dashboard.php?msg=New addition failed");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Fetch all books
    function getbook() {
        try {
            $q = "SELECT * FROM bookdata";
            $data = $this->connection->query($q);
            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function getbooksyouhave($t6) {
        try {
            $query = $this->connection->prepare("SELECT * FROM issuedbook WHERE email = :email");
            $query->bindParam(':email', $t6);
            $query->execute();  // You need to execute the query
            return $query->fetchAll(PDO::FETCH_ASSOC);  // Fetch all the results
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    

    // Fetch all persons
    function getperson() {
        try {
            $q = "SELECT * FROM userdata";
            $data = $this->connection->query($q);
            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Delete a book by ID
    function deletebook($deletebookid) {
        try {
            // Prepare the SQL statement to delete the book
            $query = $this->connection->prepare("DELETE FROM bookdata WHERE id = :id");
            $query->bindParam(':id', $deletebookid);

            if ($query->execute()) {
                header("Location: admin_service_dashboard.php?msg=Book deleted");
                exit();
            } else {
                echo "<script>
                        alert('Failed to delete book');
                        window.location.href = 'admin_service_dashboard.php';
                      </script>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function deleteperson($deletepersonid) {
        try {
            // Prepare the SQL statement to delete the book
            $query = $this->connection->prepare("DELETE FROM userdata WHERE id = :id");
            $query->bindParam(':id', $deletepersonid);

            if ($query->execute()) {
                header("Location: admin_service_dashboard.php?msg=Person removed");
                exit();
            } else {
                echo "<script>
                        alert('Failed to remove person');
                        window.location.href = 'admin_service_dashboard.php';
                      </script>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function issuenewbook($name,$email,$bookname,$bookauthor,$bookpub,$issuedate) {
        try {
            
            $q = "INSERT INTO issuedbook (name, email, bookname, bookauthor,bookpub,date) VALUES (:name, :email,:bookname, :bookauthor,:bookpub,:date)";
            $stmt = $this->connection->prepare($q);

            // Bind the parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':bookname', $bookname);  // Save the hashed password
            $stmt->bindParam(':bookauthor',$bookauthor);
            $stmt->bindParam(':bookpub',$bookpub);
            $stmt->bindParam(':date',$issuedate);

            if ($stmt->execute()) {
                header("Location: admin_service_dashboard.php?msg=Issue done");
            } else {
                header("Location: admin_service_dashboard.php?msg=issue failed");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function getissuebook(){
        try {
            $q = "SELECT * FROM issuedbook";
            $data = $this->connection->query($q);
            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function returnbook($returnbookid) {
        try {
            // Prepare the SQL statement to delete the book
            $query = $this->connection->prepare("DELETE FROM issuedbook WHERE id = :id");
            $query->bindParam(':id', $returnbookid);

            if ($query->execute()) {
                header("Location: admin_service_dashboard.php");
                exit();
            } else {
                echo "<script>
                        alert('Failed to return book');
                        window.location.href = 'admin_service_dashboard.php';
                      </script>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    function getUserById($id) {
        try {
            // Prepare the query
            $query = $this->connection->prepare("SELECT * FROM userdata WHERE id = :id");
            
            // Bind the ID to the query
            $query->bindParam(':id', $id);
            
            // Execute the query
            $query->execute();
            
            // Fetch the result
            return $query->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function getissueById($id) {
        try {
            // Prepare the query
            $query = $this->connection->prepare("SELECT * FROM issuedbook WHERE id = :id");
            
            // Bind the ID to the query
            $query->bindParam(':id', $id);
            
            // Execute the query
            $query->execute();
            
            // Fetch the result
            return $query->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function requestbook($requestbookid,$userid){
        
        try {
            $u = new data();
        $u->setconnection();

            $w=new data();
            $w->setconnection();
        $userInfo = $u->getUserById($userid);

        $issueinfo=$w->getissueById($requestbookid);
            
            $q = "INSERT INTO request (fromemail,fromname,toemail,toname,book,bookauthor,bookpub,date,issueid) VALUES (:fromemail,:fromname,:toemail,:toname,:book,:bookauthor,:bookpub,:date,:issueid)";
            $stmt = $this->connection->prepare($q);

            // Bind the parameters
            $stmt->bindParam(':fromemail', $userInfo['email']);
            $stmt->bindParam(':fromname', $userInfo['name']);
            $stmt->bindParam(':toemail', $issueinfo['email']); 
            $stmt->bindParam(':toname', $issueinfo['name']);
            $stmt->bindParam(':book',$issueinfo['bookname']);
            $stmt->bindParam(':bookauthor',$issueinfo['bookauthor']);
            $stmt->bindParam(':bookpub',$issueinfo['bookpub']);
            $stmt->bindParam(':date',$issueinfo['date']);
            $stmt->bindParam(':issueid',$requestbookid);

            if ($stmt->execute()) {
                header("Location: user_service_dashboard.php?msg=Request done");
            } else {
                header("Location: user_service_dashboard.php?msg=Request failed");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }
    function getrequestbookstatus($t9){
        try{
        $u = new data();
        $u->setconnection();
        $userInfo = $u->getUserById($t9);
        $q="SELECT * FROM request WHERE fromemail=:fromemail";
        $stmt = $this->connection->prepare($q);
        $stmt->bindParam(':fromemail', $userInfo['email']);
        $stmt->execute();
            
        // Fetch the result
        return $stmt; 
    }catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
    function getrequestforyou($t9){
        try{
            $u = new data();
            $u->setconnection();
            $userInfo = $u->getUserById($t9);
            $q="SELECT * FROM request WHERE toemail=:toemail";
            $stmt = $this->connection->prepare($q);
            $stmt->bindParam(':toemail', $userInfo['email']);
            $stmt->execute();
            return $stmt;
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function acceptrequest($acceptrequestid){
        try{
            $q="UPDATE request SET status='Accepted' WHERE id=$acceptrequestid";
            $stmt = $this->connection->prepare($q);
            if ($stmt->execute()) {
                header("Location: user_service_dashboard.php?msg=Request Accepted");
            } else {
                header("Location: user_service_dashboard.php?msg=Request failed");
            }
           


        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function unacceptrequest($unacceptrequestid){
        try{
            $q="DELETE FROM request WHERE id=$unacceptrequestid";
            $stmt = $this->connection->prepare($q);
            if ($stmt->execute()) {
                header("Location: user_service_dashboard.php?msg=Request Unaccepted");
            } else {
                header("Location: user_service_dashboard.php?msg=Request failed");
            }
           


        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function confirmrequest($confirmrequestid, $issueid, $userid){
        $u = new data();
        $u->setconnection();
        $userInfo = $u->getUserById($userid);
        
        // Update issuedbook table
        $query = "UPDATE issuedbook SET name = :name, email = :email, date = NOW() WHERE id = :issueid";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', $userInfo['name']);
        $stmt->bindParam(':email', $userInfo['email']);
        $stmt->bindParam(':issueid', $issueid);
        $stmt->execute();
    
        // Delete request from request table
        $q = "DELETE FROM request WHERE id = :confirmrequestid";
        $stmt = $this->connection->prepare($q);
        $stmt->bindParam(':confirmrequestid', $confirmrequestid);
        if ($stmt->execute()) {
            header("Location: user_service_dashboard.php?msg=Request confirm");
        } else {
            header("Location: user_service_dashboard.php?msg=Request failed");
        }
    }
    

}