<?php
error_reporting(E_ALL);
try {
    $connection = mysqli_connect('localhost', 'root', '', 'electronics_store');
    // Insert data into the table
    $query = "INSERT INTO products(product_name, brand, thumb, description, price, quantity, cat_id) VALUES ('$pname','$brand','$thumb','$description','$price','$quantity','$cat_id')";

    if (!mysqli_query($connection, $query)) {
        throw new Exception("Error inserting data: " . mysqli_error($connection));
    }

} catch (Exception $ex) {
    die ('Database Error' . $ex->getMessage());
}
// Close connection
$connection->close();
?>