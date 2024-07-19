<?php
include ('../../includes/topnavbar.php');
include ('../../includes/secondarynav.php');
include ('../../database/database_connection.php');
?>
<html>
<head>
  <title>Edit Cart</title>
  <link rel="stylesheet" href="../../css/product_detail.css" />
  <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
</head>
<body>
<div id="preloader"></div>
  <?php
  $id = $_GET['id'];
  $select_product = "SELECT * FROM products where product_id='$id'";
  // $quantity = "SELECT quantity from products where product_id='$id'";
  $q_result = mysqli_query($conn, $select_product);
  if ($q_result) {
    // Fetch the quantity
    $row = mysqli_fetch_assoc($q_result);
    $quantity = $row['quantity'];
        // Check if quantity is greater than 0
    if ($quantity > 0) {
      if (isset($_POST['btnAdd'])) {
        if(isset($_SESSION['user_id'])){
        $user_id=$_SESSION['user_id'];
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $thumb = $_POST['thumb'];
        $price = $_POST['price'];
          
        // Check if the product is already in the cart, update quantity
        $check_query = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
          // Product is already in the cart, update its quantity
          $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$user_id' AND product_id = '$product_id'";
          $update_result = mysqli_query($conn, $updateQuery);

          $item_count="UPDATE products SET quantity = quantity -1 WHERE product_id = '$product_id'";
          $count_result = mysqli_query($conn, $item_count);

          if ($update_result) {
              echo '
              <script>
                  alert("Item quantity updated in the cart");
              </script>
              ';
          } else {
              echo 'Error:' . mysqli_error($conn);
          }
      } else {

        // Inserting the data retrieved above into the 'cart' table
        $insert_query = "INSERT INTO cart(user_id,product_id, product_name, thumb, price,quantity) 
                         VALUES ('$user_id','$product_id', '$product_name', '$thumb', '$price',1)";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
          // Inform the user that the item has been added to the cart
          echo '<script>alert("Item added successfully to the cart");</script>';
          
          $item_count="UPDATE products SET quantity = quantity -1 WHERE product_id = '$product_id'";
          $count_result = mysqli_query($conn, $item_count);
        } else {
          echo "Error: " . mysqli_error($conn);
        }
      }
      } else {
        echo '<script>alert("Please Login to Continue");</script>';
        header('location:../../pages/customer/user_login.php');
      }
      }
      $item_status = "";
    } else {
      $item_status = "Item is out of stock.";
    }
  } else {
    echo "Error: " . mysqli_error($conn);
  }

  $result = mysqli_query($conn, $select_product);
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      echo '
  <section class="product--container">
    <div class="left--side">
      <div class="image--container">
      <h1 class="item_status">' . $item_status . '</h1>
        <img src="../../images/uploaded_images/' . $row['thumb'] . '" class="product--image" alt="Product_Image"/>
      </div>
      <div class="buttons">
      <form action="" method="post">
        <input type="hidden" name="product_id" value=' . $row['product_id'] . '>
        <input type="hidden" name="product_name" value=' . $row['product_name'] . '>
        <input type="hidden" name="thumb" value=' . $row['thumb'] . '>
        <input type="hidden" name="price" value=' . $row['price'] . '>
        <input type="submit" name="btnAdd" id="btn-add" class="btn--cart cart--buy" value="Add to Cart" />
      </form>
      ' ?>
      <?php
      if ($quantity > 0 && isset($_SESSION['user_id'])) {
        echo'
        <a href="checkout_single.php?id='.$row['product_id'] . '" class="btn--cart cart--buy">Buy Now</a>
      </div>
    </div>
    <div class="right--side">
      <h1 class="heading-product">' . $row['product_name'] . '</h1>
      <br /> <p>Rs ' . $row['price'] . '</p>
      <div class="highlights">
        <h2>Highlights and Features</h2>
        <div class="highlight-item">Brand : ' . $row['brand'] . '</div>
        <div class="highlight-item">Highlights and Features</div>
        <div class="highlight-item">' . $row['description'] . '</div>
        


      </div>';
      } else {
        if(!isset($_SESSION['user_id'])){
        echo '
        <a href="../../pages/customer/user_login.php" class="btn--cart cart--buy" id="buy-btn">Buy Now</a>
      </div>
    </div>
    <div class="right--side">
      <h1 class="heading-product">' . $row['product_name'] . '</h1>
      <br /> <p>Rs ' . $row['price'] . '</p>
      <div class="highlights">
        <h2>Highlights and Features</h2>
        <div class="highlight-item">Brand : ' . $row['brand'] . '</div>
        <div class="highlight-item">Highlights</div>
        <div class="highlight-item">' . $row['description'] . '</div>
        

        <div class="highlight-item">Specifications</div>

        <div class="highlight-item">Ratings and Reviews</div>

        <div class="highlight-item">Questions and Answers</div>

        <!-- Add more highlight items as needed -->
      </div>';
        }else{
          echo '
        <a href="javascript:void(0)" class="btn--cart cart--buy" id="buy-btn">Buy Now</a>
      </div>
    </div>
    <div class="right--side">
      <h1 class="heading-product">' . $row['product_name'] . '</h1>
      <br /> <p>Rs ' . $row['price'] . '</p>
      <div class="highlights">
        <h2>Highlights and Features</h2>
        <div class="highlight-item">Brand : ' . $row['brand'] . '</div>
        <div class="highlight-item">Highlights</div>
        <div class="highlight-item">' . $row['description'] . '</div>
        

        <div class="highlight-item">Specifications</div>

        <div class="highlight-item">Ratings and Reviews</div>

        <div class="highlight-item">Questions and Answers</div>

        <!-- Add more highlight items as needed -->
      </div>';

        }

      }
    }
  }
  ?>
  </div>
  </section>
  <script>
        var loader=document.getElementById("preloader");
        window.addEventListener("load",function(){
            loader.style.display="none";
        })
    </script>
    <iframe width="792" height="522" src="https://www.youtube.com/embed/s4LJPGQRRkw?list=RDs4LJPGQRRkw" title="Manish Khoji Rahechu   Shishir Yogi" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
</body>

</html>
<?php include ('../../includes/footer.php'); ?>