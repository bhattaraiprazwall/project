<?php
session_start();
include ('../../includes/admin_sidebar.php');
require_once('../../database/database_connection.php');
if(isset($_POST['confirm'])){
    $user_id=$_POST['user_id'];
    $order_id=$_POST['order_id'];
    $sql="UPDATE orders SET status=1 WHERE user_id='$user_id' and order_id='$order_id'";
    $result=mysqli_query($conn,$sql);
}
if(isset($_POST['reject'])){
    $user_id=$_POST['user_id'];
    $order_id=$_POST['order_id'];
    $sql="UPDATE orders SET status=3 WHERE user_id='$user_id' and order_id='$order_id'";
    $result=mysqli_query($conn,$sql);
}
if(isset($_POST['delivered'])){
    $user_id=$_POST['user_id'];
    $order_id=$_POST['order_id'];
    $sql="UPDATE orders SET status=2 WHERE user_id='$user_id' and order_id='$order_id'";
    $result=mysqli_query($conn,$sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="../../css/orders_page.css" />
    <script>
    if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>

<body>
    <h1 class="orders--heading">Received Orders</h1>
    <table id="orders--tbl">
        <tr class="orders--head">
            
            <th>Order_ID</th>
            <th>Item</th>
            <th>User_ID</th>
            <th>User_Name</th>
            <th>Delivery Method</th>
            <th>Total_price</th>
            <th>Order_Date</th>
            <th>Action</th>
        </tr>
        <?php include ('../../database/database_connection.php');
        $select_orders = "SELECT *FROM orders INNER JOIN users_data ON orders.user_id=users_data.id inner join products on orders.product_id=products.product_id";
        $result = mysqli_query($conn, $select_orders);
        try {
            if (mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo ' 
                    <tr>
                            <td>'.$row['order_id'].'</td>
                            <td>'.$row['product_name'].'</td>
                            <td>'.$row['user_id'].'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['delivery_method'].'</td>
                            <td>'.$row['total'].'</td>
                            <td>'.$row['order_date'].'</td>
                            <td>
                            <form action="" method="post">
                                <input type="hidden" name="user_id" value="' . $row['user_id'] . '" />
                                <input type="hidden" name="order_id" value="' . $row['order_id'] . '" />
                                <input type="submit" name="confirm" value="Confirm" id="confirm"/>
                                <input type="submit" name="reject" value="Reject" id="reject"/>
                                <input type="submit" name="delivered" value="Delivered" id="delivered"/>
                            </form>
                            </td>
                    </tr>';
                }
            } else {
                echo 'Cart is Empty';
            }
        } catch (Exception $ex) {
            die('Database Error:' . $ex->getMessage());
        }
        ?>
    </table>
</body>

</html>