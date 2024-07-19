<?php
include('../../includes/topnavbar.php');
require_once('../../database/database_connection.php');
$user_id = $_SESSION['user_id'];


// Add to cart portion from wishlist page button
if (isset($_POST['btnAdd'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['id'];

        // Retrieve product data from the product table
        $query = "SELECT * FROM products WHERE product_id = '$product_id'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            $product_id = $row['product_id'];
            $product_name = $row['product_name'];
            $thumb = $row['thumb'];
            $price = $row['price'];

            // Check if the product is already in the cart, update quantity
            $check_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                // Product is already in the cart, update its quantity
                $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$user_id' AND product_id = '$product_id'";
                $update_result = mysqli_query($conn, $updateQuery);

                if ($update_result) {
                    echo '<script>alert("Item quantity updated in the cart");</script>';
                    $item_count="UPDATE products SET quantity = quantity -1 WHERE product_id = '$product_id'";
                    $count_result = mysqli_query($conn, $item_count);
                } else {
                    echo 'Error: ' . mysqli_error($conn);
                }
            } else {
                // Insert the data retrieved above into the 'cart' table
                $insert_query = "INSERT INTO cart(user_id, product_id, product_name, thumb, price, quantity) 
                                VALUES ('$user_id', '$product_id', '$product_name', '$thumb', '$price', 1)";
                $insert_result = mysqli_query($conn, $insert_query);

                if ($insert_result) {
                    echo '<script>alert("Item added successfully to the cart");</script>';
                    $item_count="UPDATE products SET quantity = quantity -1 WHERE product_id = '$product_id'";
                    $count_result = mysqli_query($conn, $item_count);
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        }
    } else {
        echo '<script>alert("Please Login to Continue");</script>';
        $redirect = "../../pages/customer/user_login.php";
        echo "<script type='text/javascript'>window.location.href='$redirect';</script>";
        exit();
    }
}

// Delete from wishlist
if (isset($_POST['deleteBtn'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['id'];

        $delete_query = "DELETE FROM wishlist WHERE product_id = '$product_id' AND user_id = '$user_id'";
        $delete_result = mysqli_query($conn, $delete_query);
        
        if ($delete_result) {
            echo "<script>alert('Item successfully removed from wishlist');</script>";
        } else {
            echo "<script>alert('Error deleting item from wishlist');</script>";
        }
    }
}

// Displaying wishlist items
$check_query = "SELECT * FROM wishlist INNER JOIN products ON wishlist.product_id = products.product_id WHERE user_id = '$user_id'";
$check_result = mysqli_query($conn, $check_query);
if (mysqli_num_rows($check_result) > 0) {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="../../css/wishlist.css">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>My Wishlist</h1>
        <table class="wishlist-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';

    while ($row = mysqli_fetch_assoc($check_result)) {
        echo '<tr>
            <td class="image-row"><img src="../../images/uploaded_images/' . $row['thumb'] . '" id="wishlist-image" /></td>
            <td>' . $row['product_name'] . '</td>
            <td>' . $row['price'] . '</td>
            <td>';
            if ($row['quantity'] > 0) {
                echo'
                <form action="" method="post">
                    <input type="hidden" name="id" value="' . $row['product_id'] . '" />
                    <button class="add-btn" name="btnAdd">Add To Cart</button>
                    <button class="remove-btn" name="deleteBtn">Remove</button>
                </form>';
    }else{
        echo'<form action="" method="post">
                    <input type="hidden" name="id" value="' . $row['product_id'] . '" />
                    <button class="add-btn" name="btnAdd disabled">Add To Cart</button>
                    <button class="remove-btn" name="deleteBtn">Remove</button>
                </form>';
    }
            
            echo'</td>
        </tr>';
    }

    echo '</tbody>
        </table>
    </div>
</body>
</html>';
} else {
    echo 'Data Not Found';
}
?>
