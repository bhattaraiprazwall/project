<?php
session_start();
$user_id=$_SESSION['user_id'];
include ("../../database/database_connection.php");
if (isset($_POST['place_order'])) {
    // Validate if delivery method is selected
    if (!isset($_POST['radio_button'])) {
        echo 'Please select a delivery method';
    }
    // Validate if terms and conditions are agreed
    elseif (!isset($_POST['terms'])) {
        echo 'Please agree to the terms and conditions';
    } else {
        // Insert order into the database
        $user_id = $_SESSION['user_id']; // Assuming you have a logged-in user
        $delivery_method = $_POST['radio_button']; // Assuming radio_button is the name of your delivery method input
        $total_price = $_POST['total_price']; // Assuming you have calculated total price earlier
        $order_date = date("Y-m-d H:i:s"); // Current date and time
        $product_id=$_GET['id'];        
        // Prepare and execute the SQL statement to insert the order
        $sql = "INSERT INTO orders (user_id, product_id, quantity, delivery_method, order_date, total) VALUES ('$user_id', '$product_id',1, '$delivery_method', '$order_date', '$total_price')";

        if (mysqli_query($conn, $sql)) {
            // Order inserted successfully
            $order_id = mysqli_insert_id($conn); // Get the ID of the newly inserted order
            echo '<script>alert("Order placed successfully");</script> ' . $order_id;

            // Optionally, you can clear the cart table after placing the order
            $delete_cart_items_sql = "DELETE FROM cart WHERE user_id = '$user_id'";
            mysqli_query($conn, $delete_cart_items_sql);
            header('location: ../../pages/index/dashboard.php');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../../css/checkout.css" />
    <script>
    if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>

<body class="checkout--body">
    <?php
    $id = $_GET['id'];
    $direct_product = "SELECT *FROM products where product_id=$id";
    $result1 = mysqli_query($conn, $direct_product);
    $result2 = mysqli_query($conn, $direct_product);
    $row=mysqli_fetch_array($result2);
    // $sum_query1 = "SELECT SUM(price) AS total_price1 FROM products";
    // $sum_result1 = mysqli_query($conn, $sum_query1);
    // $row = mysqli_fetch_assoc($sum_result1);
    // $total_price1 = $row['total_price1'];
    echo '
        <section class="checkout--wrapper">
            <h1 class="checkout--heading">Checkout </h1>
            <div class="checkout-1">
            <table>
                <tr ">
                    <th class="heading-tr">Product</th>
                    <th class="heading-tr">Subtotal</th>
                </tr>
            </div>';
    while ($row1 = $result1->fetch_array()) {
        echo '
                <tr>
                    <td>' . $row1['product_name'] . '</td>
                    <td>' . $row1['price'] . '</td>
                </tr> ';
    }
    echo '</table>';
    echo '<div class="sub_total">Subtotal: Rs ' .$row['price'] . '</div>';
    ?>
    <h1>Shipping</h1>
    <p class="shipping--cost">Free Shipping</p>
    
    <h1>Payment Method</h1>
    <form action="" method="post">
    <?php echo '<h1 class="subtotal-price">Total: Rs ' .$row['price'] . '</h1>'; ?>
    <input type="hidden" name="total_price" value="<?php echo $row['price']; ?>" />

        <input type="radio" name="radio_button" value="Cash On Delivery">Cash On Delivery
        <p>Your personal data will be used to process your order, support your experience<br /> throughout this website
            and for other purposes described in our privacy policy.<br /><br />
            <input type="checkbox" name="terms">I have read and agreed to the website terms and conditions*
            <br /><br />
            <input type="submit" name="place_order" value="Place Order" class="place--order" />
            </section>
    </form>
</body>

</html>