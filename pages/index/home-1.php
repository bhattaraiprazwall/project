<?php
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
</head>

<body id="home--cart">
    <h2 class="top--selling">NEW ARRIVALS</h2>
    <?php
    $product_id = $product_name = $thumb = $price = $user_id = "";
    $select_product = "SELECT *FROM products";
    $q_result = mysqli_query($conn, $select_product);
    if ($q_result) {
        //Fetch the quantity
         $row = mysqli_fetch_assoc($q_result);
            $quantity = $row['quantity'];
            if ($quantity > 0) {
                if (isset($_POST['btnAdd'])) {
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $product_id = $_POST['product_id'];
                        $product_name = $_POST['product_name'];
                        $thumb = $_POST['thumb'];
                        $price = $_POST['price'];

                        $check_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
                $check_result = mysqli_query($conn, $check_query);

                if (mysqli_num_rows($check_result)   > 0) {
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
                        $insert_query = "INSERT INTO cart(user_id,product_id, product_name, thumb, price) 
                         VALUES ('$user_id','$product_id', '$product_name', '$thumb', '$price')";
                        $insert_result = mysqli_query($conn, $insert_query);

                        if ($insert_result) {
                            // Inform the user that the item has been added to the cart
                            echo '<script>alert("Item added successfully to the cart");</script>';
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    }

                    } else {
                        echo '<script>alert("Please Login to Continue");</script>';
                        // header("location:../../pages/customer/user_login.php");
                        $redirect = "../../pages/customer/user_login.php";
                        echo "<script type='text/javascript'>window.location.href='$redirect';</script>";
                        exit();
                    }

                }
                $item_status = "Item is in stock";
            }
            //else block for out of stock condition
            else {
                $item_status = "Item is out of stock";
                // echo "<script>alert('Out of stock');</script>";
            }
        // }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
//adding to wishlist code
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

    if (isset($_GET['searchBox']) && !empty($_GET['searchBox'])) {
        $search = $_GET['searchBox'];
        $sql = "SELECT *FROM products where product_id like '%$search%' or product_name like '%$search%'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $count=mysqli_num_rows( $result );
            echo"<span id='search-context'>
            ".$count." Item(s) found
             for '$search'
            </span>";
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
            $search="";
        } else {
            echo "Product not found for $search";
        }
    } else {
        echo'<script>
        window.location.href="../../pages/index/dashboard.php";
        </script>
        ';
    }
    ?>
    <script>
        function loadCard() {
            window.location.href = "product_detail.php";
        }
    </script>
</body>

</html>