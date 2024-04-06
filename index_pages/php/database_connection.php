<?php
error_reporting(E_ALL);
try {
    // creating connection to the database
    $conn = mysqli_connect('localhost', 'root', '', 'electronics_store');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      echo "";

    }
//code to check condition and select * query
catch (Exception $ex) {
        die ('Database Error:' . $ex->getMessage());
    
    }
    //closing the database connection
    // $conn->close();
    
    ?>