<?php
// session_start();
include("../../includes/topnavbar.php");
include("../../includes/secondarynav.php");

// Check if user ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user data from the database
    include('../../database/database_connection.php');
    $select = "SELECT * FROM users_data WHERE id= $userId";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) == 1) {
        $userData = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit(); // Exit if user not found
    }
} else {
    echo "User ID not provided.";
    exit(); // Exit if user ID not provided
}

// Initialize error count
$error = 0;

// Check if form is submitted for updating user data
if (isset($_POST['updateUser'])) {
    // Retrieve form data
    if (isset($_FILES['thumb']) && $_FILES['thumb']['error'] == 0) {
        if ($_FILES['thumb']['size'] < 2024000) {
            $filetype = ['image/png', 'image/jpeg', 'image/jpg'];
            if (in_array($_FILES['thumb']['type'], $filetype)) {
                $filename = uniqid() . '_' . $_FILES['thumb']['name'];
                if (move_uploaded_file($_FILES['thumb']['tmp_name'], '../../images/uploaded_images/' . $filename)) {
                    $thumb = $filename; // Save the filename after successful upload
                } else {
                    $error++;
                    $errthumb = 'Upload failed';
                }
            } else {
                $error++;
                $errthumb = 'File type must be png/jpeg';
            }
        } else {
            $error++;
            $errthumb = 'File size must be below 2 MB';
        }
    } else {
        $thumb = $userData['thumb']; // Use existing thumb if no new file is uploaded
    }

    if (isset($_POST['name']) && !empty($_POST['name']) && trim($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $name = $userData['name'];
    }

    if (isset($_POST['email']) && !empty($_POST['email']) && trim($_POST['email'])) {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error++;
            $erremail = 'Please enter a valid email address';
        }
    } else {
        $email = $userData['email'];
    }

    if (isset($_POST['phone']) && !empty($_POST['phone']) && trim($_POST['phone'])) {
        $phone = $_POST['phone'];
    } else {
        $phone = $userData['phone'];
    }

    if (isset($_POST['address']) && !empty($_POST['address']) && trim($_POST['address'])) {
        $address = $_POST['address'];
    } else {
        $address = $userData['address'];
    }

    if (isset($_POST['city']) && !empty($_POST['city']) && trim($_POST['city'])) {
        $city = $_POST['city'];
    } else {
        $city = $userData['city'];
    }

    // Check if email already exists
    $query = "SELECT * FROM users_data WHERE email = '$email' AND id != $userId";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $error++;
        $erremail = "Email is already registered";
    }

    // Check if phone number already exists
    $query = "SELECT * FROM users_data WHERE phone = '$phone' AND id != $userId";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $error++;
        $errphone = "Phone number is already registered";
    }

    if ($error === 0) {
        echo '<script>alert("Data updated successfully")</script>';
        $updateQuery = "UPDATE users_data SET name = '$name', email = '$email', phone = '$phone', address = '$address', city = '$city', thumb = '$thumb' WHERE id = $userId";

        if (mysqli_query($conn, $updateQuery)) {
            echo "User data updated successfully!";
            // header('Location: view_profile.php');
            echo'<script>window.location.href="view_profile.php";</script>';
            exit();
        } else {
            echo "Error updating user data: " . mysqli_error($conn);
        }
    } else {
        echo '<script>alert("Form submission failed, check for errors")</script>';
    }
}
?>
<link rel="stylesheet" href="../../css/view_profile.css" />
<body class="body--view">
    <?php
    if (isset($_SESSION["user_id"])) {
        $id = $_SESSION['user_id'];
        $sql = "SELECT * FROM users_data WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo '
            <form action="" method="post" enctype="multipart/form-data">
                <div class="container--full">
                    <h1>User Profile</h1>
                    <img src="../../images/user_profile_image/' . $_SESSION['user_image'] . '" alt="Profile Picture" class="profile-picture">
                    <div class="profile-info">
                        <label for="name">Name</label>
                        <input id="name" name="name" value="' . $row['name'] . '"/>
                    </div>
                    <div class="profile-info">
                        <label for="email">Email:</label>
                        <input id="email" name="email" value="' . $row['email'] . '"/>';
                        ?>
                <span class="error"><?php echo (isset($erremail)) ? $erremail : ''; ?></span>
                <?php echo'
                    </div>
                    <div class="profile-info">
                        <label for="password">Password:</label>
                        <a href="change_pass.php?id='.$id.'" class="edit-pwd-button">Change Password</a>
                    </div>
                    <div class="profile-info">
                        <label for="phone">Phone:</label>
                        <input id="phone" name="phone" value="' . $row['phone'] . '"/>';
                        ?>
                        <span class="error"><?php echo (isset($errphone)) ? $errphone : ''; ?></span>
                        <?php echo '

                    </div>
                    <div class="profile-info">
                        <label for="address">Address:</label>
                        <input id="address" name="address" value="' . $row['address'] . '"/>
                    </div>
                    <div class="profile-info">
                        <label for="city">City:</label>
                        <input id="city" name="city" value="' . $row['city'] . '"/>
                    </div>
                    <div class="profile-info">
                        <label for="thumb">Profile Picture:</label>
                        <input type="file" id="thumb" name="thumb" />
                    </div>
                    <button type="submit" class="edit-profile-button" name="updateUser">Save</button>
                </div>
            </form>';
        }
    } else {
        echo '';
    }
    ?>
    <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</body>
</html>
<?php include('../../includes/footer.php'); ?>
<link rel="stylesheet" href="../../css/footer.css" />
