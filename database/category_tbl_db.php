<pre>
<?php
error_reporting(E_ALL);
try{
    $connection=mysqli_connect('localhost','root','','electronics_store');
    $sql="CREATE TABLE if not exists category(
        cat_id int not null auto_increment primary key,
        cat_name varchar(200) not null)";
    if(mysqli_query($connection,$sql)){
        echo'Category added successfully';
    }else{
        echo'Failed to add category';
    }
}catch(Exception $ex)
{
    die('Database Error'.$ex->getMessage());
}
?>