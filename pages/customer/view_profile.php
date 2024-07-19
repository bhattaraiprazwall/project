<?php
include("../../includes/topnavbar.php");
include("../../includes/secondarynav.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
   <link rel="stylesheet" href="../../css/view_profile.css"/>
   <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</head>
<body class="body--view">
    <?php
    require_once("../../database/database_connection.php");
    
    // session_start();
    if(isset($_SESSION["user_id"])){
     
    $id=$_SESSION['user_id'];
    $sql="SELECT *FROM users_data where id='$id'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)> 0){
    $row=mysqli_fetch_array($result);
    echo'
    <div class="container--full">
        <h1>User Profile</h1>
        <img src="../../images/user_profile_image/' . $_SESSION['user_image'] . '" alt="Profile Picture" class="profile-picture">
        <div class="profile-info">
            <label for="name">Name</label>
            <div id="name">'.$row['name'].'</div>
        </div>
        <div class="profile-info">
            <label for="email">Email:</label>
            <div id="email">'.$row['email'].'</div>
        </div>
        <div class="profile-info">
            <label for="password">Password:</label>
            <a href="#" class="edit-pwd-button">Change Password</a>
        </div>
        <div class="profile-info">
            <label for="phone">Phone:</label>
            <div id="phone">'.$row['phone'].'</div>
        </div>
        <div class="profile-info">
            <label for="address">Address:</label>
            <div id="address">'.$row['address'].'</div>
        </div>
        <div class="profile-info">
            <label for="city">City:</label>
            <div id="city">'.$row['city'].'</div>
        </div>
        <a href="edit_profile.php?id='.$row['id'].'" class="edit-profile-button">Edit Profile</a>
    </div>';
    }
}else{
        echo '';
}
    ?>
    
</body>
</html>
<?php include('../../includes/footer.php');
echo'<link rel="stylesheet" href="../../css/footer.css"/>'?>