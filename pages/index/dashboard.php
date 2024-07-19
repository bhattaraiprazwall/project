<?php
// session_start(); 
// if(!isset($_SESSION['user_id'])){
//     header('location:../../index_pages/php/dashboard.php');
// }
// echo '<div class="user--display"> Hi ' . $_SESSION['user_name'] .'<a href="../../user_pages/php/user_logout.php">Logout</a></div>';
// echo "</br>";
include('../../includes/topnavbar.php');
include('../../includes/secondarynav.php');
if(isset($_GET['searchBox'])){
    include('home-1.php');
 //code to include home_cart page if no search content is given from the search box in topnavbar page
}else{
    include('home_cart.php');//code to include if the search content is given
}
// include('../../includes/shopbybrands.php');
include('../../includes/footer.php');
?>
<link rel="stylesheet"href="../../css/dashboard.css"/>
<body>
    <div id="preloader"></div>
    <script>
        var loader=document.getElementById("preloader");
        window.addEventListener("load",function(){
            loader.style.display="none";
        })
    </script>
</body>