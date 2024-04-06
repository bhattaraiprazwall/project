<?php
// Check if user ID is provided in the URL
if(isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user data from the database
    $connection = mysqli_connect('localhost', 'root', '', 'electronics_store');
    $select = "SELECT * FROM users_data WHERE id = $userId";
    $result = mysqli_query($connection, $select);
    
    if(mysqli_num_rows($result) == 1) {
        $userData = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit(); // Exit if user not found
    }
} else {
    echo "User ID not provided.";
    exit(); // Exit if user ID not provided
}

// Check if form is submitted for updating user data
if(isset($_POST['updateUser'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];

    // Update user data in the database
    $updateQuery = "UPDATE users_data SET name = '$name', email = '$email', password = '$password', phone = '$phone', address = '$address', city = '$city' WHERE id = $userId";
    
    if(mysqli_query($connection, $updateQuery)) {
        echo "User data updated successfully!";
        header('location:admin_dashboard.php');
        // You may choose to redirect back to the admin dashboard after updating
        // header("Location: admin_dashboard.php");
        // exit();
    } else {
        echo "Error updating user data: " . mysqli_error($connection);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>

<body>
    <h2>Edit User</h2>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $userData['name']; ?>"><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $userData['email']; ?>"><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?php echo $userData['password']; ?>"><br>
        
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="<?php echo $userData['phone']; ?>"><br>
        
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="<?php echo $userData['address']; ?>"><br>
        
        <label for="city">City:</label>
        <input type="text" name="city" id="city" value="<?php echo $userData['city']; ?>"><br>
        
        <input type="submit" name="updateUser" value="Update">
    </form>
</body>

</html>
