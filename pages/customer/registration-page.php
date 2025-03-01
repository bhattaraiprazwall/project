<?php
include('../../includes/topnavbar.php');
echo '<link rel="stylesheet" href="../../css/topnavbar.css"/>';
$error = 0;
$name = $email = $password = $con_pwd = $phone = $address = $city = "";
$errname = $erremail = $errpassword = $errcon_pwd = $errphone = $erraddress = $errcity = "";
if (isset($_POST['btnSubmit'])) {
   if ($_FILES['thumb']['error'] == 0) {
      if ($_FILES['thumb']['size'] < 2024000) {
          $filetype = ['image/png', 'image/jpeg','image/jpg'];
          if (in_array($_FILES['thumb']['type'], $filetype)) {
              $filename = uniqid() . '_' . $_FILES['thumb']['name'];
              if (move_uploaded_file($_FILES['thumb']['tmp_name'], '../../images/uploaded_images/' . $filename)) {
                  // Display the uploaded image
                  // echo 'File upload success';
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
          $errthumb = 'File size must be below 1 MB';
      }
  } else {
      $error++;
      $errthumb = 'FileUpload Error';
  }

   if (isset($_POST['name']) && !empty($_POST['name']) && trim($_POST['name'])) {
      $name = $_POST['name'];
   } else {
      $error++;
      $errname = "Please enter your name";
   }

   if (isset($_POST['email']) && !empty($_POST['email']) && trim($_POST['email'])) {
      $email = $_POST['email'];
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
         $error++;
         $erremail='Please enter a valid mail address';
      }else{
         $email = $_POST['email'];
      }
   } else {
      $error++;
      $erremail = "Please enter your email";
   }

   if (isset($_POST['password']) && !empty($_POST['password']) && trim($_POST['password'])) {
      $password = $_POST['password'];
   } else {
      $error++;
      $errpassword = "Please enter your password";
   }

   if (isset($_POST['con_pwd']) && !empty($_POST['con_pwd']) && trim($_POST['con_pwd'])) {
      $con_pwd = $_POST['con_pwd'];
   } else {
      $error++;
      $errcon_pwd = "Please enter your con_pwd";
   }

   if (isset($_POST['phone']) && !empty($_POST['phone']) && trim($_POST['phone'])) {
      $phone = $_POST['phone'];
   } else {
      $error++;
      $errphone = "Please enter your phone";
   }

   if (isset($_POST['address']) && !empty($_POST['address']) && trim($_POST['address'])) {
      $address = $_POST['address'];
   } else {
      $error++;
      $erraddress = "Please enter your address";
   }

   if (isset($_POST['city']) && !empty($_POST['city']) && trim($_POST['city'])) {
      $city = $_POST['city'];
   } else {
      $error++;
      $errcity = "Please enter your city";
   }
   // Check if email already exists
   include('../../database/database_connection.php');   
   $query = "SELECT * FROM users_data WHERE email = '$email'";
   $result = mysqli_query($conn, $query);
   if (mysqli_num_rows($result) > 0) {
       $error++;
       $erremail = "Email is already registered";
   }
   //check if phone number already exists 
   $query = "SELECT * FROM users_data WHERE phone = '$phone'";
   $result = mysqli_query($conn, $query);
   if (mysqli_num_rows($result) > 0) {
       $error++;
       $errphone = "phone number is already registered";
   }
   if ($password === $con_pwd) {

      if ($error === 0) {
         echo '<script>alert ("Form Sumbitted Successfully")</script>';
         include('../../database/users_data_insert.php');
      } else {
         echo '<script>alert ("Form submission failed,check for errors")</script>';

      }
   } else {
      echo "<script>alert ('Passwords do not match')</script>";

   }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" type="text/css" href="../../css/registration-page.css" />
   <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia"> -->
   <script src="registration_page.js"></script>
   <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
   <title>User Registration</title>
</head>
<body id="reg--body">
    <section class="main--section">
        <form action="" method="post" class="main--section form" enctype="multipart/form-data" novalidate >
            <h3 class="user--reg">User Registration</h3>
            <p class="para">Fill out the form carefully for registration</p>
            <div>
                <label for="thumb" class="user-lbl">Profile Image</label>
                <input type="file" name="thumb" />
                <span class="error"><?php echo (isset($errthumb)) ? $errthumb : ''; ?></span>
            </div>
            <div>
                <label for="name" class="user-lbl">Name</label>
                <input type="text" name="name" id="name" class="user-register" placeholder="Enter your full name" value="<?php echo $name; ?>" />
                <span class="error"><?php echo (isset($errname)) ? $errname : ''; ?></span>
            </div>
            <div>
                <label for="email" class="user-lbl">Email</label>
                <input type="text" name="email" id="email" class="user-register" placeholder="Enter your email address" value="<?php echo $email; ?>" />
                <span class="error"><?php echo (isset($erremail)) ? $erremail : ''; ?></span>
            </div>
            <div>
                <label for="password" class="user-lbl">Password</label>
                <input type="password" name="password" id="password" class="user-register" placeholder="Create a password" value="<?php echo $password; ?>" />
                <span class="error"><?php echo (isset($errpassword)) ? $errpassword : ''; ?></span>
            </div>
            <div>
                <label for="con_pwd" class="user-lbl">Confirm Password</label>
                <input type="password" name="con_pwd" id="con_pwd" class="user-register" placeholder="Confirm password" value="<?php echo $con_pwd; ?>" />
                <span class="error"><?php echo (isset($errcon_pwd)) ? $errcon_pwd : ''; ?></span>
            </div>
            <div>
                <label for="phone" class="user-lbl">Phone</label>
                <input type="number" name="phone" id="phone" class="user-register" placeholder="Enter your phone number" value="<?php echo $phone; ?>" />
                <span class="error"><?php echo (isset($errphone)) ? $errphone : ''; ?></span>
            </div>
            <div>
                <label for="address" class="user-lbl">Address</label>
                <input type="text" name="address" id="address" class="user-register" placeholder="Enter your current address" value="<?php echo $address; ?>" />
                <span class="error"><?php echo (isset($erraddress)) ? $erraddress : ''; ?></span>
            </div>
            <div>
                <label for="city" class="user-lbl">City</label>
                <input type="text" name="city" id="city" class="user-register" placeholder="Enter your current city" value="<?php echo $city; ?>" />
                <span class="error"><?php echo (isset($errcity)) ? $errcity : ''; ?></span>
            </div>
            <div class="sign--up--wrap">
                <input type="submit" id="btnSubmit" class="submit" value="Sign Up" name="btnSubmit" />
            </div>
            <div class="login--redirect">
                <h4>Already have an account ? <a href="user_login.php">Sign in</a></h4>
            </div>
        </form>
    </section>
</body>
</html>
<?php include('../../includes/footer.php');?>
<link rel="stylesheet"href="../../css/footer.css"/>

