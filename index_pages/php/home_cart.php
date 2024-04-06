<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Cart Page</title>
    <link rel='stylesheet' type='text/css' href='../css/home_cart.css'/>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->

</head>

<body>
<h2 class="top--selling">Top Selling</h2>
    <?php
    include('database_connection.php');
    // $pro_id=$_POST['product_id'];
    // $products="SELECT *FROM products where product_id=$pro_id";
    // $product_result=mysqli_query($conn,$products);
    // print_r($product_result);


    $select_product='SELECT *FROM products order by product_id desc LIMIT 10 ';
    $result=mysqli_query($conn,$select_product);    
   
    try{      
        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <section class="cart--section">
                
                    <div class="cart--container">
                        <div class="cart cart--1">
                            <!-- <h3 class="cart--title">   
                                cart  one
                            </h3> -->
                            <div class="cart--body">
                                <div>
                                <img class="cart--img" src="../uploaded_images/' .$row['thumb'].'">
                                </div>
                                <div class="cart--desc">
                                    <span class="cart--info">Price:</span>
                                    <span class="cart--price">' . $row['price'] . '</span>
                                </div>
                                <div class="cart--details">
                                    <ul class="cart--lists">
                                        <li>' . $row['product_name'] . '</li>
                                        <li>two</li>
                                        <li>' . $row['description'] . '</li>
                                    </ul>
                                </div>
                                <div class="btn--parent--cart"> 
                                    <ul class="cart_lists">
                                        <li><a href=""? id=' . $row['product_id'] . '" class="btn--cart cart--buy" >
                                            Add to Cart
                                            </a>
                                        </li>
                                        <li><a href="#" class="btn--cart cart--buy">
                                            Buy Now
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>';
            }
        } else {
            echo 'Data not found';
        }
    } catch (Exception $ex) {
        die ('Database Error:' . $ex->getMessage());
    }
    ?>
</body>
</html>
