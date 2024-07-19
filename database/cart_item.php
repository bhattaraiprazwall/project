<?php
// Include your database connection file
include 'database_connection.php';
// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent from the form
    $product_id = $_POST['product_id'];
    $product_name = ($_POST['product_name']);
    $thumb = ($_POST['thumb']);
    $price = $_POST['price'];
    // $quantity = $_POST['quantity'];
    // $user_id = $_POST['user_id']; // You may adjust this if you have user authentication

    // Prepare the SQL query to insert data into the 'cart' table
    $query = "INSERT INTO cart(product_id, product_name, thumb, price) 
              VALUES ('$product_id', '$product_name', '$thumb', '$price')";

    // Execute the SQL query
    $result = mysqli_query($conn, $query);

    // Check if the insertion was successful
    if ($result) {
        echo "<script>alert('Item added to cart successfully.')</script>";
        header("Location:../../index_pages/php/dashboard.php");
    } else {
        echo "Failed to add item to cart: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect the user to the home page or display an error message
    header("Location:../../index_pages/php/dashboard.php");
    exit;
}
?>
