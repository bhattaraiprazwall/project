
<?php
session_start();
session_destroy();
setcookie('user_id', false, time() -7 * 24 * 24 * 60 * 60);
setcookie('user_email', false, time() - 7 * 24 * 24 * 60 * 60);
setcookie('user_name', false, time() - 7 * 24 * 24 * 60 * 60);

// echo "<script>alert('Logged Out Successfully');</script>";
header('location:../../user_pages/php/user_login.php');

?>