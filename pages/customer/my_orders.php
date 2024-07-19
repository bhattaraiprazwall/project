<?php
// session_start();
include ("../../includes/topnavbar.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="../../css/my_orders.css">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <div class="container-1">
        <h1 class="my--orders">My Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once ("../../database/database_connection.php");
                $id = $_SESSION['user_id'];
                $sql = "SELECT orders.quantity AS order_quantity, orders.*, products.*
                        FROM orders 
                        INNER JOIN products ON orders.product_id = products.product_id 
                        WHERE user_id = '$id'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_array($result)) {
                        if ($row['status'] == 0) {
                            $status = "<span style='color: red;'>Order Pending</span>";
                        } else if ($row["status"] == 1) {
                            $status = "<span style='color: green;'>Order Verified</span>";
                        } else if ($row["status"] == 2) {
                            $status = "<span style='color: #343aeb;'>Delivered</span>";
                        } else if ($row["status"] == 3) {
                            $status = "<span style='color: red;'>Order Cancelled</span>";
                        }

                        echo '
        <tr>
            <td>' . $row['order_id'] . '</td>
            <td>' . $row['order_date'] . '</td>
            <td>' . $row['product_name'] . '</td>
            <td>' . $row['order_quantity'] . '</td> <!-- Using the aliased column -->
            <td>' . $row['total'] . '</td>
            <td>' . $status . '</td>';
            if($row["status"] == 1){
            echo'<th><a href="javascript:void(0)" class="disabled_a">Cancel</a></th>';
            }else{
                echo'<th><a href="cancel_page.php?quantity=' . $row['order_quantity'] . '&product_id=' . $row['product_id'] . '" onclick="return confirm(\'are you sure to cancel the order?\')";>Cancel</a></th>';
                // echo '<th><a href="cancel_page.php?quantity=' . $row['order_quantity'] . '&product_id=' . $row['product_id'] . '" onclick="return confirm(\'Are you sure to cancel the order?\');">Cancel</a></th>';

            }
        echo'</tr>';
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
</body>

</html>