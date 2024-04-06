<pre>
<?php
error_reporting(E_ALL);
try{
    $connection=mysqli_connect('localhost','root','','electronics_store');
     //sql to create admin table and table rows
     $sql="CREATE TABLE IF NOT EXISTS admin_data(
        id int not null auto_increment primary key,
        FirstName varchar(200) not null,
        Lastname varchar(200) not null,
        email varchar(200) not null,
        password varchar(200) not null)";
    if(mysqli_query($connection,$sql)){
        echo'Admin added successfully';
    }else{
        echo'Error adding admin';
    }


}
catch(Exception $ex){
    die('Database error:'.$ex->getMessage());
}
?>