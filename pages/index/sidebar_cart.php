    <!-- Sidebar starts here -->
<link rel="stylesheet"href="../../css/sidebar_cart.css"/>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</head>
<div id="sidebar" class="sidebar">
    <!-- Close button -->
    <button class="close-button" onclick="closeSidebar()">Close</button>
    <!-- Sidebar content (cart items, checkout button, etc.) -->
    <div class="cart--lists--cart">
        <?php
        include('../../database/database_connection.php');

        if (isset($_POST['btnDelete'])) {
            $item_id = $_POST['id'];
        
            // Retrieve the product_id from the cart item before deletion
            $product_query = "SELECT product_id FROM cart WHERE id = '$item_id'";
            $product_result = mysqli_query($conn, $product_query);
            if ($product_result && mysqli_num_rows($product_result) > 0) {
                $product_row = mysqli_fetch_assoc($product_result);
                $product_id = $product_row['product_id'];
        
                // Delete the item from the cart
                $delete_query = "DELETE FROM cart WHERE id = '$item_id'";
                if (mysqli_query($conn, $delete_query)) {
                    // Data deleted successfully
                    echo "<script>alert('Item deleted successfully!');</script>";
        
                    // Update the product quantity in the products table
                    $update_quantity_query = "UPDATE products SET quantity = quantity + 1 WHERE product_id = '$product_id'";
                    $update_result = mysqli_query($conn, $update_quantity_query);
        
                    if ($update_result) {
                        echo "<script>alert('Product quantity updated successfully!');</script>";
                    } else {
                        echo "Error updating product quantity: " . mysqli_error($conn);
                    }
        
                    // You may choose to redirect or refresh the page after deletion
                    // header("Location: admin_dashboard.php");
                    // exit();
                } else {
                    echo "Error deleting cart item: " . mysqli_error($conn);
                }
            } else {
                echo "Error retrieving product ID: " . mysqli_error($conn);
            }
        }
        if(isset($_SESSION["user_id"])) {
        $sess_user_id=$_SESSION['user_id'];
        } else {
            $sess_user_id = 0;
        }
        $select_product = "SELECT *FROM cart where user_id='$sess_user_id'";
        $result = mysqli_query($conn, $select_product);
        $sum_query = "SELECT SUM(price * quantity) AS total_price FROM cart";
        $sum_result = mysqli_query($conn, $sum_query);
        $sum_row = mysqli_fetch_assoc($sum_result);
        $total_price = $sum_row['total_price'];
        try {
            if (mysqli_num_rows($result) > 0) {
                while ($row = $result->fetch_assoc()) {
                    $truncated_name = strlen($row['product_name']) > 20 ? substr($row['product_name'], 0, 15) . '...' : $row['product_name'];
                    echo '
            <div class="cart--lists--cart-item">
              <img src="../../images/uploaded_images/' . $row['thumb'] . '" class="cart--inside--image" />
              <div class="cart--details">
                <p class="left--aligned">'.$truncated_name.'</p>
                <p>'.$row['quantity'].' x '.'Rs '.$row['price'] . '</p>
                <form action="" method="POST">
                  <input type="hidden" name="id" value="' . $row['id'] . '" />
                  <input type="submit" name="btnDelete" value="Remove" class="delete--cart--item" onclick="return confirm(\'are you sure to remove the item?\')";/>
                </form>
              </div>
            </div>';
                }
                echo '<div class="sub_total">Subtotal: Rs ' . $total_price . '</div>';
            } else {
                echo 'Cart is Empty';
            }
        } catch (Exception $ex) {
            die('Database Error:' . $ex->getMessage());
        }
        ?>
    </div>
        <!-- //just a try code  -->
    <div class="check--view">
        <div class="check">
            <a href="../../pages/index/checkout.php" class="checkout-button">Checkout</a>
        </div>
        <span class="view">
                <a href="../../pages/index/edit_cart.php"  class="view-button">View Cart</a>
        </span>
    </div>
        </div>
        <!-- Sidebar ends here -->