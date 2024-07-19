<?php
// Check if user ID is provided in the URL
if(isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user data from the database
    include('../../database/database_connection.php');
    $select = "SELECT * FROM users_data WHERE id = $userId";
    $result = mysqli_query($conn, $select);
    
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
$error=0;
// Check if form is submitted for updating user data
if(isset($_POST['updateUser'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $query1 = "SELECT * FROM users_data WHERE phone = '$phone' AND id != '$userId'";
    $result1 = mysqli_query($conn, $query1);
    if (mysqli_num_rows($result1) > 0) {
        $error++;
        $errphone = "Phone number is already registered";
    }
    $query = "SELECT * FROM users_data WHERE email = '$email' and id != '$userId'";
   $result = mysqli_query($conn, $query);
   if (mysqli_num_rows($result) > 0) {
       $error++;
       $erremail = "Email is already registered";
   }
    // Update user data in the database
    if($error==0){
    $updateQuery = "UPDATE users_data SET name = '$name', email = '$email', password = '$password', phone = '$phone', address = '$address', city = '$city' WHERE id = $userId";
    
    if(mysqli_query($conn, $updateQuery)) {
        echo "User data updated successfully!";
        header('location:admin_dashboard.php');
        // You may choose to redirect back to the admin dashboard after updating
        // header("Location: admin_dashboard.php");
        // exit();
    } else {
        echo "Error updating user data: " . mysqli_error($connection);
    }
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
    .edit--user--body{
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .form-title {
            /* text-align: center; */
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-submit {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .form-submit:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
    if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>

<body class="edit--user--body">
    <form class="form-container" method="POST">
    <h2 class="form-title">Edit User</h2>  
        <label for="name" class="form-label">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $userData['name']; ?>" class="form-input">

        <label for="email" class="form-label">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $userData['email']; ?>" class="form-input">
        <span class="error"><?php echo (isset($erremail)) ? $erremail : ''; ?></span>

        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" id="password" value="<?php echo $userData['password']; ?>"
            class="form-input">

        <label for="phone" class="form-label">Phone:</label>
        <input type="text" name="phone" id="phone" value="<?php echo $userData['phone']; ?>" class="form-input">
        <span class="error"><?php echo (isset($errphone)) ? $errphone : ''; ?></span>

        <label for="address" class="form-label">Address:</label>
        <input type="text" name="address" id="address" value="<?php echo $userData['address']; ?>" class="form-input">

        <label for="city" class="form-label">City:</label>
        <input type="text" name="city" id="city" value="<?php echo $userData['city']; ?>" class="form-input">

        <input type="submit" name="updateUser" value="Update" class="form-submit">
    </form>
</body>

</html>
