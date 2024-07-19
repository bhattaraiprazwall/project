<?php
include ("../../includes/topnavbar.php");
include ("../../includes/secondarynav.php");
require_once ('../../database/database_connection.php');

// Check if user ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    // Fetch user data from the database
    $select = "SELECT * FROM users_data WHERE id = '$userId'";
    $result = mysqli_query($conn, $select);

    if ($result && mysqli_num_rows($result) == 1) {
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
if (isset($_POST['updatePass'])) {
    if (isset($_POST['old_pass']) && !empty($_POST['old_pass'])) {
        $old_pass = $_POST['old_pass'];
        
        // Fetch user data from the database
        $sql = "SELECT *FROM users_data WHERE id = '$userId'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if ($old_pass == $row['password']) {
                if (isset($_POST['new_pass']) && !empty($_POST['new_pass'])) {
                    $new_pass = $_POST['new_pass'];
                    if (isset($_POST['confirm_pass']) && !empty($_POST['confirm_pass'])) {
                        $confirm_pass = $_POST['confirm_pass'];
                        if ($new_pass == $confirm_pass) {
                            $password = $new_pass;
                        } else {
                            $error++;
                            echo '<script>alert("Passwords do not match")</script>';
                        }
                    } else {
                        $error++;
                        echo '<script>alert("Enter confirmation password")</script>';
                    }
                } else {
                    $error++;
                    echo '<script>alert("Enter new password")</script>';
                }
            } else {
                $error++;
                echo '<script>alert("Wrong Password Entered")</script>';
            }
        } else {
            $error++;
            echo '<script>alert("Error fetching user data")</script>';
        }
    } else {
        $error++;
        echo '<script>alert("Enter old password")</script>';
    }
}

if ($error === 0 && isset($password)) {
    $updateQuery = "UPDATE users_data SET password = '$password' WHERE id = '$userId'";
    if (mysqli_query($conn, $updateQuery)) {
        echo '<script>alert("Password changed successfully!");</script>';
        echo'<script>window.location.href="view_profile.php"</script>';
        exit();
    } else {
        echo "Error updating user data: " . mysqli_error($conn);
    }
} elseif ($error > 0) {
    echo '<script>alert("Form submission failed, check for errors")</script>';
}
?>

<link rel="stylesheet" href="../../css/view_profile.css" />
<body class="body--view">
    <?php
    if (isset($_SESSION["user_id"])) {
        $id = $_SESSION['user_id'];
        $sql = "SELECT * FROM users_data WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo '
            <form action="" method="post">
                <div class="container--full">
                    <h1>User Profile</h1>
                    <div class="profile-info">
                        <label for="old_pass">Old Password:</label>
                        <input type="password" name="old_pass" required/>
                        <br />
                        <label for="new_pass">New Password:</label>
                        <input type="password" name="new_pass" required/>
                        <br />
                        <label for="confirm_pass">Confirm Password:</label>
                        <input type="password" name="confirm_pass" required/>
                    </div>
                    <input type="submit" class="edit-profile-button" name="updatePass" value="Save Changes"/>
                </div>
            </form>';
        }
    }
    ?>
    <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</body>
</html>

<?php include ('../../includes/footer.php'); ?>
<link rel="stylesheet" href="../../css/footer.css" />
