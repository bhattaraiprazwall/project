<?php
// ob_start();
// session_start();
include ('../../database/database_connection.php');
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Cart Page</title>
    <link rel='stylesheet' type='text/css' href='../../css/home_cart.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</head>

<body id="home--cart">
    <h2 class="top--selling">NEW ARRIVALS</h2>
    <?php
    $select_product = 'SELECT * FROM products ORDER BY product_id DESC LIMIT 12';
    $result = mysqli_query($conn, $select_product);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $item_status = $row['quantity'] > 0 ? "In stock" : "OUT OF STOCK";

            // Truncate the product name if it exceeds 20 characters
            $truncated_name = strlen($row['product_name']) > 20 ? substr($row['product_name'], 0, 15) . '...' : $row['product_name'];

            echo "
            <section class='card--wrapper'>
                <div class='card' onclick='loadCard()'>
                <a href='product_detail.php?id={$row['product_id']}' id='pro--id--button'>
                    <div class='card--items'>
                        <div class='image--section'>
                            " . ($item_status === "OUT OF STOCK" ? "<div class='sold-out'>OUT OF STOCK</div>" : "") . "
                            <img class='card--img " . ($item_status === "OUT OF STOCK" ? "sold-out-image" : "") . "' src='../../images/uploaded_images/{$row['thumb']}' alt='Product Image'>
                        </div>
                        <p class='pro--name'>$truncated_name</p>
                        <p class='price'><span>Rs {$row['price']}</span></p>
                        <form action='' method='post'> <!-- Changed the action to current page -->
                            <input type='hidden' name='product_id' value='{$row['product_id']}'>
                            <input type='hidden' name='product_name' value='{$row['product_name']}'>
                            <input type='hidden' name='thumb' value='{$row['thumb']}'>
                            <input type='hidden' name='price' value='{$row['price']}'>
                            <button type='submit' class='btn--cart' id='btn--heart' name='wishlist'>
                            <i class='fa fa-heart-o'></i>
                            </button>";

            if ($row['quantity'] > 0) {
                echo "
                            <button type='submit' class='btn--cart' id='btn--bag' name='btnAdd'>
                            <i class='fa fa-shopping-bag'></i>
                            </button>";
            } else {
                echo "
                            <button type='button' class='btn--cart' id='btn--bag' disabled>
                            <i class='fa fa-shopping-bag'></i>
                            </button>";
            }

            echo "
                        </form>
                    </div>
                    </a>
                </div>
            </section>";
        }
        if (isset($_POST['btnAdd'])) {
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $product_id = $_POST['product_id'];
                $product_name = $_POST['product_name'];
                $thumb = $_POST['thumb'];
                $price = $_POST['price'];
                // Check if the product is already in the cart, update quantity
                $check_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
                $check_result = mysqli_query($conn, $check_query);

                if (mysqli_num_rows($check_result) > 0) {
                    // Product is already in the cart, update its quantity
                    $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$user_id' AND product_id = '$product_id'";
                    $update_result = mysqli_query($conn, $updateQuery);

                    //to reduce quantity from products table after added to cart
                    $item_count="UPDATE products SET quantity = quantity -1 WHERE product_id = '$product_id'";
                    $count_result = mysqli_query($conn, $item_count);

                    if ($update_result) {
                        echo '
                        <script>
                            alert("Item quantity updated in the cart");
                        </script>
                        ';
                    } else {
                        echo 'Error:' . mysqli_error($conn);
                    }
                } else {
                    // Inserting the data retrieved above into the 'cart' table
                    $insert_query = "INSERT INTO cart(user_id, product_id, product_name, thumb, price,quantity) 
                                VALUES ('$user_id', '$product_id', '$product_name', '$thumb', '$price',1)";
                    $insert_result = mysqli_query($conn, $insert_query);

                    if ($insert_result) {
                        // Inform the user that the item has been added to the cart
                        echo '<script>alert("Item added successfully to the cart");</script>';
                        $item_count="UPDATE products SET quantity = quantity -1 WHERE product_id = '$product_id'";
                        $count_result = mysqli_query($conn, $item_count);
                        // if ($count_result) {
                        //     echo '
                        //     <script>
                        //         alert("Item quantity deducted in the product table");
                        //     </script>
                        //     ';
                        // } else {
                        //     echo 'Error:' . mysqli_error($conn);
                        // }


                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                }

            } else {
                echo '<script>alert("Please Login to Continue");</script>';
                $redirect = "../../pages/customer/user_login.php";
                echo "<script type='text/javascript'>window.location.href='$redirect';</script>";
                exit();
            }
        }
    } else {
        echo 'Data not found';
    }
    // adding clicked product to the wishlist table
    if(isset($_POST['wishlist'])){
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $thumb = $_POST['thumb'];
            $price = $_POST['price'];

            // Check if the product is already in the wishlist
            $check_query = "SELECT *FROM wishlist WHERE user_id = '$user_id' AND product_id = '$product_id'";
            $check_result = mysqli_query($conn, $check_query);
            if (mysqli_num_rows($check_result) > 0) {
                // Product is already in the wishlist, display a message
                echo'<script>alert("Product already in the wishlist");</script>';
            } else {
                // Inserting the data retrieved above into the 'wishlist' table
                $insert_query = "INSERT INTO wishlist(product_name,price,product_id,user_id) 
                            VALUES('$product_name','$price','$product_id','$user_id')";
                $insert_result = mysqli_query($conn, $insert_query);

                if ($insert_result) {
                    // Inform the user that the item has been added to the cart
                    echo '<script>alert("Item added successfully to the wishlist");</script>';
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }

        } else {
            echo '<script>alert("Please Login to Continue");</script>';
            $redirect = "../../pages/customer/user_login.php";
            echo "<script type='text/javascript'>window.location.href='$redirect';</script>";
            // exit();
        }
    }
    //wish list code upto here
    ?>
    <script>
        function loadCard() {
            window.location.href = "product_detail.php";
        }
    </script>
</body>

</html>