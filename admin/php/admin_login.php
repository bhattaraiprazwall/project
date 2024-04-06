<?php
if(isset($_COOKIE['admin_id'])){
    session_start();
    $_SESSION['admin_id']=$_COOKIE['admin_id'];
    $_SESSION['admin_email']=$_COOKIE['admin_email'];
    header('location:admin_dashboard.php');
}

$error = 0;
$email=$password="";
$errmail=$errpassword="";
if(isset($_GET['err'])&& $_GET['err']==1){
    $errdetails="Please login to continue";
}


if (isset($_POST['button'])) {
    if (isset($_POST['email']) && !empty($_POST['email']) && trim($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $error++;
        $errmail='Please input email';
    }

    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
        $encrypted_password=md5($password);
    } else {
        $error++;
        $errpassword='Please input password';
    }

    if ($error === 0) {
        include ('../database/database_connection.php');
        try {
            $sql = "SELECT * FROM admin_data WHERE email='$email' AND password='$encrypted_password' AND status=1";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row=$result->fetch_assoc();
                // echo "Login Successfull";

                //storing the database file in the session
                session_start();
                $_SESSION['admin_id']=$row['id'];
                $_SESSION['admin_email']=$row['email'];

                //check remember me button
                if(isset($_POST['remember'])){
                    //store data into cookie also
                    setcookie('admin_id',$row['id'],time()+7*24*24*60*60);
                    setcookie('admin_email',$row['email'],time()+7*24*24*60*60);

                }
                //redirecting to dashboard
                header("Location: ../php/admin_dashboard.php");
            } else {
                $errdetails= "Invalid credentials";
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/admin_login.css" />
</head>

<body>

    <form action="" method="post">
    
        <div class="container">
        <span class="error--details"><?php echo isset($errdetails) ?$errdetails:'';?></span>
            <h2>Admin Login</h2>
         
            <label for="email" id="lblemail" class="admin--data">Email</label>
            <input type="text" name="email" id="username" value="<?php echo $email ?>" placeholder="Enter email" />
            <?php echo isset($errmail)? $errmail:'';?>

            <label for="password" id="lblpassword" class="admin--data">Password</label>
            <input type="password" name="password" placeholder="Enter password" value="<?php echo $password ?>" />
            <?php echo isset($errpassword)? $errpassword:'';?>
            <br />
            

            <label>
                <input type="checkbox"  name="remember"> Remember me
            </label>

            <button type="submit" name="button">Login</button>

        </div>
    </form>

</body>

</html>