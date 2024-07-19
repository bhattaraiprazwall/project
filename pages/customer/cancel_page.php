<?php
session_start();
$user_id=$_SESSION['user_id'];
$product_id=$_GET['product_id'];
$quantity=$_GET['quantity'];
require_once('../../database/database_connection.php');
$sql="DELETE FROM orders where user_id='$user_id' AND product_id='$product_id'";
$result=mysqli_query($conn,$sql);
if($result){
    echo'<script>alert("Order Cancelled Successfully");</script>';
    $item_count="UPDATE products SET quantity = quantity + 1 WHERE product_id = '$product_id'";
    $count_result = mysqli_query($conn, $item_count);
}else{
    echo'<script>alert("Order Cancellation Failed");</script>';
}
header('location:my_orders.php');
?>