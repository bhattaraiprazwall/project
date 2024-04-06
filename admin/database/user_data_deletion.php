<?php
// Create connection
$conn = new mysqli('localhost','root', '', 'electronics_store');
// Step 2: Retrieve form data
$id = $_POST['id'];
// Step 3: Delete the record from the database
$sql = "DELETE FROM users_data WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
// Step 4: Close the connection
$conn->close();

// Step 5: Redirect back to the page displaying the data
header("Location: qsn1.list.php");
?>

