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
          <a href="#">
            <p><i class="fa fa-shopping-cart"></i> My cart</p>
          </a>
        </div>
      </nav>
    </div>
  </header>
  <!-- Sidebar starts here -->
  <div id="sidebar" class="sidebar">
    <!-- Close button -->
    <button class="fa fa-close close-button" onclick="closeSidebar()">Close</button>
    <!-- Sidebar content (cart items, checkout button, etc.) -->
    <div class="cart--lists--cart">
      <?php
      include ('database_connection.php');
      if (isset($_POST['btnDelete'])) {
        $item_id = $_POST['id'];
        $deleteQuery = "DELETE FROM cart WHERE id = $item_id";
        if (mysqli_query($conn, $deleteQuery)) {
          // Data deleted successfully
          // echo "<script>alert('Item deleted successfully!')</script>";
          // You may choose to redirect or refresh the page after deletion
          // header("Location: admin_dashboard.php");
          // exit();
        } else {
          echo "Error deleting user: " . mysqli_error($connection);
        }
      }
      $select_product = 'SELECT *FROM cart';
      $result = mysqli_query($conn, $select_product);
      $sum_query = "SELECT SUM(price) AS total_price FROM cart";
      $sum_result = mysqli_query($conn, $sum_query);
      $row = mysqli_fetch_assoc($sum_result);
      $total_price = $row['total_price'];

      try {
        if (mysqli_num_rows($result) > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '
            <div class="cart--lists--cart-item">
              <img src="../uploaded_images/' . $row['thumb'] . '" class="cart--inside--image" />
              <div class="cart--details">
                <p>' . $row['product_name'] . '</p>
                <p>' . 'Rs ' . $row['price'] . '</p>
                <form action="" method="POST">
                  <input type="hidden" name="id" value="' . $row['id'] . '" />
                  <input type="submit" name="btnDelete" value="Delete" class="delete--cart--item"/>
                </form>
              </div>
            </div>';
          }
          echo '<div class="sub_total">Subtotal: Rs ' . $total_price . '</div>';
        } else {
          echo 'Cart is Empty';
        }
      } catch (Exception $ex) {
        die('Database Error:' . $ex->getMessage());
      }
      ?>
    </div>
    <div class="check--view">
      <div class="check">
        <a href="#" class="checkout-button">Checkout</a>
      </div>
      <div class="view">
        <a href="#" class="view-button">View Cart</a>
      </div>
    </div>
  </div>
  <!-- Sidebar ends here -->

  <script src="../js/topnavbar.js"></script>
</body>

</html>