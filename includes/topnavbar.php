<?php
session_start();
// session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>topNav</title>
  <link rel="stylesheet" type="text/css" href="../../css/topnavbar.css" />
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'> -->
</head>
<body class="topnavbar--body">
  <header class="header">
    <div class="header-wrap">
      <a href="../../pages/index/dashboard.php" class="main-logo link"><h1 class="main-logo link">Electronics Store</h1></a>
      <div class="search-container">
        <form action="../../pages/index/dashboard.php" method="GET">
        <input type="text" placeholder="Search for items..." class="search-box" name="searchBox" />
        <button type="submit" class="search-button" name="searchBtn">Search</button>
        </form>
      </div>
      <nav class="header-text-box">
        <!-- <div class="header-link-wrap">
          <ul class="list">
            <li class="header-link-list">
              <a class="link header-link" href="#">Shop Now</a>
            </li>
            <li class="header-link-list">
              <a class="link header-link" href="#">Pricing</a>
            </li>
            <li class="header-link-list">
              <a class="link header-link" href="#">Service</a>
            </li>
            <li class="header-link-list">
              <a class="link header-link" href="#">FAQs</a>
            </li>
          </ul>
        </div> -->
        <?php
        if (isset($_SESSION['user_id'])) {
          // User is logged in
          echo '<div class="profile--container">
                  <div class="profile--image">
                    <img src="../../images/user_profile_image/' . $_SESSION['user_image'] . '" id="user_image_profile">  
                  </div>
                  <div class="profile--user"
                    <a href="" class="profile--username">' . $_SESSION['user_name'] . '</a>  
                    <div class="dropdown">
                      <button onclick="toggleDropdown()" class="dropbtn">&#9660;</button>
                      <div id="myDropdown" class="dropdown-content">
                        <a href="../../pages/customer/view_profile.php">View Profile</a>
                        <a href="../../pages/customer/my_orders.php">My Orders</a>
                        <a href="../../pages/customer/wishlist.php">My Wishlist</a>
                        <a href="../../pages/customer/user_logout.php">Logout</a>
                      </div>
                    </div>
                  </div>
                </div>';
        } else {
          // User is not logged in)
          echo '<div class="header-btn-wrap">
          <a href="../../pages/customer/user_login.php" class="btn header-btn btn--sm btn--outline">Sign In</a>
          <a href="../../pages/customer/registration-page.php" class="btn btn--sm btn--full">Sign Up</a>
          </div>';
        }
        ?>
        <?php if(isset($_SESSION['user_id'])) {
        echo'<div class="cart--logo" onclick="toggleSidebar()">
          <a href="#">
            <p><img src="../../assets/trolley.png" class="cart--icon"></p>
          </a>
        </div>';
        }else{
          echo'<div class="cart--logo" onclick="toggleSidebarRedirect()">
          <a href="#">
            <p><img src="../../assets/trolley.png" class="cart--icon"></p>
          </a>
        </div>';
        }
        ?>
      </nav>
    </div>
  </header>
  <?php include ('../../pages/index/sidebar_cart.php')?>
  <script src="../../js/topnavbar.js"></script>
</body>

</html>