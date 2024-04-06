<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>topNav</title>
  <link rel="stylesheet" type="text/css" href="../css/topnavbar.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
</head>

<body>
  <header class="header">
    <div class="header-wrap">
      <a href="dashboard.php" class="main-logo link">Electronic Store</a>
      <nav class="header-text-box">
        <div class="header-link-wrap">
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
        </div>
        <div class="header-btn-wrap">
          <a href="/project/user_pages/php/user_login.php" class="btn header-btn btn--sm btn--outline">Sign In</a>
          <a href="/project/user_pages/php/registration-page.php" class="btn btn--sm btn--full">Sign Up</a>
        </div>
        <div class="cart--logo" onclick="toggleSidebar()">
          <a href="#"><p><i class="fa fa-shopping-cart"></i> My cart</p></a>
          <!-- Sidebar starts here -->
          <div id="sidebar" class="sidebar">
            <!-- Close button -->
            <button class="close-button" onclick="closeSidebar()">Close</button>
            <!-- Sidebar content (cart items, checkout button, etc.) -->
            <p>Cart items.</p>
          </div>
          <!-- Sidebar ends here -->
        </div>
      </nav>
    </div>
  </header>
  <script src="../js/topnavbar.js"></script>
</body>

</html>
