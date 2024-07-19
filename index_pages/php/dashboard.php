<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location:../../user_pages/php/user_login.php?err=1');
}
echo '<div class="user--display"> Hi ' . $_SESSION['user_name'] .'<a href="../../user_pages/php/user_logout.php">Logout</a></div>';
echo "</br>";
include('topnavbar.php');
include('secondarynav.php');
include('home_cart.php');
include('footer.php');
?>

<link rel="stylesheet"href="../css/dashboard.css"/>