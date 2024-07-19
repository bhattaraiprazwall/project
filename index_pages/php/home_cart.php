<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Cart Page</title>
    <link rel='stylesheet' type='text/css' href='../css/home_cart.css'/>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
</head>

<body>
    <h2 class="top--selling">Top Selling</h2>

    <?php
    include('database_connection.php');

    $select_product = 'SELECT * FROM products ORDER BY product_id DESC LIMIT 10';
    $result = mysqli_query($conn, $select_product);    

    try {      
        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <section class="cart--section">
                    <div class="cart--container">
                        <div class="cart cart--1">
                            <div class="cart--body">
                                <div>
                                    <img class="cart--img" src="../uploaded_images/' . $row['thumb'] . '">
                                </div>
                                <div class="cart--desc">
                                    <span class="cart--info">Price:</span>
                                    <span class="cart--price">'.'Rs '. $row['price'] . '</span>
                                </div>
                                <div class="cart--details">
                                    <ul class="cart--lists">
                                        <li>' . $row['product_name'] . '</li>
                                        <li>two</li>
                                        <li>' . $row['description'] . '</li>
                                    </ul>
                                </div>
                                <div class="btn--parent--cart"> 
                                    <form action="../../admin/database/cart_item.php" method="post">
                                        <input type="hidden" name="product_id" value="' . $row['product_id'] . '">
                                        <input type="hidden" name="product_name" value="' . $row['product_name'] . '">
                                        <input type="hidden" name="thumb" value="' . $row['thumb'] . '">
                                        <input type="hidden" name="price" value="' . $row['price'] . '">
                                        <input type="hidden" name="quantity" value="1"> <!-- You may modify this to allow user input -->
                                        <input type="hidden" name="user_id" value="123"> <!-- Example user ID, if applicable -->
                                        <button type="submit" class="btn--cart cart--buy">Add to Cart</button>
                                        <a href="#" class="btn--cart cart--buy">
                                        Buy Now
                                    </a>
                                    </form>
                                    
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
