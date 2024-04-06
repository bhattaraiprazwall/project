<?php
$error = 0;
if (isset($_POST['btnlogin'])) {
    if (isset($_POST['email']) && !empty($_POST['email']) && trim($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $error++;
        $erremail = 'Please enter your login email';

    }
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $error++;
        $errpassword = 'Please enter your password';

    }
    if ($error === 0) {
        include ('../admin/database_connection.php');
        try {
            $sql = "SELECT * FROM users_data WHERE email='$email' AND password='$password'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $_SESSION['admin_id'] = $user_data['id']; // You can store any relevant data here
                $_SESSION['email'] = $user_data['email'];
                echo "Login Successfull";
                header("Location: user_dash.php");
            } else {
                echo "Invalid credentials";
            }
        } catch (Exception $ex) {
            die('Database Error:' . $ex->getMessage());


        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/mail.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../css/user_login.css" />
</head>

<body>
    <form action="" method="post">
        <div class="user--login">
            <h1>Login</h1>
            <!-- <div>
            <img src="user_login.jpg" class="user--login--img" alt="userLogin" />
        </div> -->
            <div>
                <!-- <label for="email" class="lblemail">Email ID</label> -->
                <input type="text" name="email" class="user--em" value="" placeholder="Email Address"
                    value="<?php echo $email ?>" />
                <span class="err--msg">
                    <?php echo (isset($erremail)) ? $erremail : ''; ?>
                </span>
            </div>
            <div>
                <!-- <label for="passwprd" class="lblpassword">Password</label> -->
                <input type="password" name="password" class="user--em" placeholder="Password" />
                <!-- <span class="password-toggle-icon"><i class="fas fa-eye"></i></span> -->
                <span class="err--msg">
                    <?php echo (isset($errpassword)) ? $errpassword : ''; ?>
                </span>
            </div>
            <div class="below--pass--wrapper">
                <div class="below--pass">
                    <input type="checkbox" value="checked">Remember me

                </div>
                <div class="below--pass1">
                    <a href="">Forgot Password ? </a>
                </div>
            </div>
            <div>
                <input type="submit" name="btnlogin" class="login--btn" value="Login" />
            </div>
            <div>
                <p>Don't have an account? <a href="registration-page.php">Register Now </a></p>
            </div>
        </div>
    </form>
</body>

</html>