<?php
session_start();
$user_id = $_SESSION['user_id'];
include ("../../database/database_connection.php");

if (isset($_POST['place_order'])) {
    // Validate if delivery method is selected
    if (!isset($_POST['radio_button'])) {
        echo "<script>alert('Please select a delivery method');</script>";
    }
    // Validate if terms and conditions are agreed
    elseif (!isset($_POST['terms'])) {
        echo "<script>alert('Please agree to the terms and conditions');</script>";
    } else {
        $delivery_method = $_POST['radio_button'];
        $order_date = date("Y-m-d H:i:s");

        // Retrieve cart items for the user
        $select_cart = "SELECT * FROM cart WHERE user_id='$user_id'";
        $cart_result = mysqli_query($conn, $select_cart);

        // Check if cart is not empty
        if (mysqli_num_rows($cart_result) > 0) {
            while ($cart_item = mysqli_fetch_assoc($cart_result)) {
                $product_id = $cart_item['product_id'];
                $quantity = $cart_item['quantity'];
                $price = $cart_item['price'];
                $total_price = $price * $quantity;

                // Insert each product as an individual order
                $sql = "INSERT INTO orders (user_id, product_id, quantity, delivery_method, order_date, total) VALUES ('$user_id', '$product_id', '$quantity', '$delivery_method', '$order_date', '$total_price')";

                if (mysqli_query($conn, $sql)) {
                    // Order inserted successfully
                    $order_id = mysqli_insert_id($conn); // Get the ID of the newly inserted order
                    echo "<script>alert('Order placed successfully');</script>" . $order_id;

                    // Optionally, you can clear the cart table after placing the order
                    $delete_cart_items_sql = "DELETE FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
                    mysqli_query($conn, $delete_cart_items_sql);
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
            // header('location: ../../pages/index/dashboard.php');
            echo'<script>window.location.href="../../pages/index/dashboard.php";</script>';
        } else {
            echo "<script>alert('Your cart is empty');</script>";
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
    $select_product = "SELECT * FROM cart WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $select_product);
    $sum_query = "SELECT SUM(price * quantity) AS total_price FROM cart WHERE user_id='$user_id'";
    $sum_result = mysqli_query($conn, $sum_query);
    $row = mysqli_fetch_assoc($sum_result);
    $total_price = $row['total_price'];

    try {
        if (mysqli_num_rows($result) > 0) {
            echo '
            <section class="checkout--wrapper">
                <h1 class="checkout--heading">Checkout </h1>
                <div class="checkout-1">
                <table>
                    <tr>
                        <th class="heading-tr">Product</th>
                        <th class="heading-tr">Quantity</th>
                        <th class="heading-tr">Rate</th>
                        <th class="heading-tr">Total</th>
                    </tr>
                </div>';
            while ($cart_item = mysqli_fetch_assoc($result)) {
                echo '
                    <tr>
                        <td>' . $cart_item['product_name'] . '</td>
                        <td>' . $cart_item['quantity'] . '</td>
                        <td>' . $cart_item['price'] . '</td>
                        <td>' . ($cart_item['price'] * $cart_item['quantity']) . '</td>
                    </tr> ';
            }
            echo '</table>';
            echo '<div class="sub_total">Subtotal: Rs ' . $total_price . '</div>';
        } else {
            echo 'No products found';
            exit();
        }
    } catch (Exception $ex) {
        die('Database Error:' . $ex->getMessage());
    }
    ?>
    <h1>Shipping</h1>
    <p class="shipping--cost">Free Shipping</p>
    <form action="" method="post">
        <?php echo '<h1 class="subtotal-price">Total: Rs ' . $total_price . '</h1>'; ?>
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>" />

        <h1>Payment Method</h1>
        <input type="radio" name="radio_button" value="Cash On Delivery">Cash On Delivery
        <p>Your personal data will be used to process your order, support your experience<br /> throughout this website and for other purposes described in our privacy policy.<br /><br />
        <input type="checkbox" name="terms">I have read and agreed to the website terms and conditions*
        <br /><br />
        <input type="submit" name="place_order" value="Place Order" class="place--order" />
    </form>
</body>

</html>