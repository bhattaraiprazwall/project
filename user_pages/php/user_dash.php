<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location:user_login.php?err=1');
}
echo 'Hello User';

?>;
<a href="user_logout.php">Logout</a>