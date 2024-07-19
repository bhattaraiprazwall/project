<?php
error_reporting(E_ALL);
try {
    $connection = mysqli_connect('localhost', 'root', '', 'electronics_store');
    // Insert data into the table
    $query = "INSERT INTO category(cat_name) VALUES ('$cat_name')";

    if (!mysqli_query($connection, $query)) {
        throw new Exception("Error inserting data: " . mysqli_error($connection));
    }

} catch (Exception $ex) {
    die ('Database Error' . $ex->getMessage());
}
// Close connection
$connection->close();
?>