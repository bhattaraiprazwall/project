<?php
include ('../../includes/topnavbar.php');
include ("../../includes/secondarynav.php");
include ('../../database/database_connection.php');
// if(isset($_POST['update-btn'])){
//     $user_id = $_SESSION['user_id'];
//     $quantities = $_POST['quantities'];
//     foreach($quantities as $product_id => $quantity) {
//         $updateQuery = "UPDATE cart SET quantity = '$quantity' WHERE user_id = '$user_id' AND product_id = '$product_id'";
//         $result = mysqli_query($conn, $updateQuery);
//         if($result){
//             echo '<script>alert("quantity modified")</script>';
//             if()
            
//         $item_count="UPDATE products SET quantity = quantity -1 WHERE product_id = '$product_id'";
//         $count_result = mysqli_query($conn, $item_count);

           
//         }else{
//             echo "failed to modify quantity for product ID $product_id";
//         }
//     }
if (isset($_POST['update-btn'])) {
    $user_id = $_SESSION['user_id'];
    $quantities = $_POST['quantities'];

    foreach ($quantities as $product_id => $new_quantity) {
        // Fetch the current quantity of the product in the cart
        $currentQuantityQuery = "SELECT quantity FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $currentQuantityResult = mysqli_query($conn, $currentQuantityQuery);
        if ($currentQuantityResult && mysqli_num_rows($currentQuantityResult) > 0) {
            $currentQuantityRow = mysqli_fetch_assoc($currentQuantityResult);
            $current_quantity = $currentQuantityRow['quantity'];

            // Update the quantity in the cart
            $updateCartQuery = "UPDATE cart SET quantity = '$new_quantity' WHERE user_id = '$user_id' AND product_id = '$product_id'";
            $updateCartResult = mysqli_query($conn, $updateCartQuery);

            if ($updateCartResult) {
                echo '<script>alert("Quantity modified")</script>';

                // Adjust the quantity in the products table
                if ($new_quantity > $current_quantity) {
                    // If new quantity is greater, reduce the stock in the products table
                    $difference = $new_quantity - $current_quantity;
                    $updateProductQuery = "UPDATE products SET quantity = quantity - $difference WHERE product_id = '$product_id'";
                } else {
                    // If new quantity is less, increase the stock in the products table
                    $difference = $current_quantity - $new_quantity;
                    $updateProductQuery = "UPDATE products SET quantity = quantity + $difference WHERE product_id = '$product_id'";
                }
                $updateProductResult = mysqli_query($conn, $updateProductQuery);

                if (!$updateProductResult) {
                    echo "Failed to update product quantity for product ID $product_id: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to modify quantity for product ID $product_id: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to retrieve current quantity for product ID $product_id: " . mysqli_error($conn);
        }
    }
}
    if(isset($_POST['clear-btn'])){
        $user_id = $_SESSION['user_id'];
        $deleteQuery = "DELETE FROM cart WHERE user_id = '$user_id'";
            $del_result = mysqli_query($conn, $deleteQuery);
            if(!$del_result){
                echo "Failed to clear the cart";
            }
        }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Cart</title>
    <link rel="stylesheet" href="../../css/edit_cart.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="edit--cart--body">
    <?php
    echo '<h4 style="color:white;font-size:20px;">My Cart</h4>';
    if (!isset($_SESSION['user_id'])) {
        echo 'Please Login';
        exit();
    } else {
        $id = $_SESSION['user_id'];
        $sql = "SELECT * FROM cart WHERE user_id='$id'";
        $data = "SELECT * FROM users_data";
        $user_data = mysqli_query($conn, $data);
        $final_data = $user_data->fetch_assoc();
        $result = mysqli_query($conn, $sql);
        
        $sum_query = "SELECT SUM(price * quantity) AS total_price FROM cart WHERE user_id='$id'";
        $sum_result = mysqli_query($conn, $sum_query);
        $row = mysqli_fetch_assoc($sum_result);
        $total_price = $row['total_price'];
        try {
            if (mysqli_num_rows($result) > 0) {
                echo '
    <section class="both--container">
        <div class="details--section">
                <form id="cart-form" method="post">
                <table class="table">
                    <tr>
                        <th></th>
                        <th class="pro--name">Product Name</th>
                        <th class="price">Price</th>
                        <th class="quantity">Quantity</th>
                        <th class="sub--total">Subtotal</th>
                    </tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <tr class="cart-item">
                        <td><img src="../../images/uploaded_images/' . $row['thumb'] . '" class="cart--inside--image" /></td>
                        <td class="pro--name">' . $row['product_name'] . '</td>
                        <td class="price">' . $row['price'] . '</td>
                        <td class="modify-quantity">
                            <button type="button" class="mod-btn btn-minus"><i class="fa fa-minus"></i></button>
                            <input type="number" name="quantities[' . $row['product_id'] . ']" class="quantity-input" value="' . $row['quantity'] . '" />
                            <button type="button" class="mod-btn btn-add"><i class="fa fa-plus"></i></button>
                        </td>
                        <td class="item-subtotal">' . ($row['price'] * $row['quantity']) . '</td>
                    </tr>';
                }
                echo '</table>';
                echo '<div id="button--div">
            <a href="../../pages/index/dashboard.php" id="btnshop">Continue Shopping</a>
            <div class="button-2">
            <button type="submit" name="update-btn" id="btn-update">Update Cart</button>
            <button type="submit" name="clear-btn" id="btn-update">Clear All</button>
            </div>
            </div>';
                echo '</form></div>';

            } else {
                echo 'Cart Is Empty';
                echo '<div id="button--div">
                <a href="../../pages/index/dashboard.php" id="btnshop">Continue Shopping</a>
                </div>';
                exit();
            }
        } catch (Exception $ex) {
            die('Database Error' . $ex->getMessage());
        }
    }
    ?>
    <div class="price--details">
        <h1>PRICE DETAILS</h1>
        <div class="cart--subtotal--head">
            <h2>Subtotal:</h2>
            <h3><?php echo $total_price ?></h3>
        </div>
        <h3>Shipping:</h3>
        <div class="shipping--head">Free Shipping</div>
        <p>Shipping To <?php echo $final_data['address'] ?></p>
        <div class="total--head">
            <h2>Total </h2>
            <h3><?php echo $total_price ?></h3>
        </div>
        <div id="proceed--btn">
            <a href="checkout.php" id="a--btn">PROCEED TO CHECKOUT</a>
        </div>
    </div>
    </section>
    <script>
        var cartItems = document.querySelectorAll('.cart-item');
        
        for (var i = 0; i < cartItems.length; i++) {
            (function(index) {
                var item = cartItems[index];
                var increaseButton = item.querySelector('.btn-add');
                var decreaseButton = item.querySelector('.btn-minus');
                var quantityInput = item.querySelector('.quantity-input');
                var itemSubtotal = item.querySelector('.item-subtotal');
                var price = parseFloat(item.querySelector('.price').innerText);

                increaseButton.addEventListener('click', function() {
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                    itemSubtotal.innerText = (price * parseInt(quantityInput.value)).toFixed(2);
                    updateTotalPrice();
                });

                decreaseButton.addEventListener('click', function() {
                    if (parseInt(quantityInput.value) > 0) {
                        quantityInput.value = parseInt(quantityInput.value) - 1;
                        itemSubtotal.innerText = (price * parseInt(quantityInput.value)).toFixed(2);
                        updateTotalPrice();
                    }
                });
            })(i);
        }

        function updateTotalPrice() {
            var total = 0;
            document.querySelectorAll('.item-subtotal').forEach(function(subtotal) {
                total += parseFloat(subtotal.innerText);
            });
            document.querySelector('.cart--subtotal--head h3').innerText = total.toFixed(2);
            document.querySelector('.total--head h3').innerText = total.toFixed(2);
        }
    </script>
</body>

</html>
<?php include ('../../includes/footer.php'); ?>
