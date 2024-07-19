<?php
//error_reporting(E_ALL);
try {
    $connection = mysqli_connect('localhost', 'root', '', 'electronics_store');
    // Insert data into the table
    $query = "INSERT INTO users_data (thumb,name,email,password,phone,address,city) VALUES ('$thumb','$name', '$email', '$password', '$phone', '$address', '$city')";

    if (!mysqli_query($connection, $query)) {
        throw new Exception("Error inserting data: " . mysqli_error($connection));
    }

} catch (Exception $ex) {
    die ('Database Error' . $ex->getMessage());
}
// Close connection
$connection->close();
?>;
