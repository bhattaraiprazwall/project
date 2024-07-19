<?php
error_reporting(E_ALL);
try{
    //connection to database
    $connection=mysqli_connect('localhost','root','');  
    $sql="create database if not exists electronics_store";
    if(mysqli_query($connection,$sql)){
        echo'Database creation success';
    }
    else{
        echo'Failed to create database';
    }
    mysqli_select_db($connection,'electronics_store');
}
catch(Exception $ex)
{
    die('Database Error'.$ex->getMessage());
}
?>;