<pre>
<?php
error_reporting(E_ALL);
try{
    $connection=mysqli_connect('localhost','root','','electronics_store');
    $sql="CREATE TABLE if not exists products(
        product_id int not null auto_increment primary key,
        product_name varchar(200) not null,
        cat_id int not null,
        price varchar(200) not null,
        thumb varchar(200) not null,
        description varchar(200) not null)";
    if(mysqli_query($connection,$sql)){
        echo'Product added successfully';
    }else{
        echo'Failed to add product';
    }
}catch(Exception $ex)
{
    die('Database Error'.$ex->getMessage());
}
?>