<pre>
<?php
error_reporting(E_ALL);
try{
    $connection=mysqli_connect('localhost','root','','electronics_store');
     //sql to create admin table and table rows
     $sql="CREATE TABLE IF NOT EXISTS users_data(
        id int not null auto_increment primary key,
        name varchar(200) not null,
        email varchar(200) not null,
        password varchar(200) not null,
        phone bigint(200) not null,
        address varchar(200) not null,
        city varchar(200) not null)";
    if(mysqli_query($connection,$sql)){
        echo'Table created successfully';
    }else{
        echo'Table creation failed'.mysqli_error($connection);
    }


}
catch(Exception $ex){
    die('Database error:'.$ex->getMessage());
}
?>;