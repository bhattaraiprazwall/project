<?php
include('topnavbar.php');
include('secondarynav.php');
include('database_connection.php');
// Query the database to fetch headphones products (assuming product ID = 1)
$sql = "SELECT * FROM products WHERE cat_id = 2";
$result = $conn->query($sql);
echo'<h1>Top In HeadPhones</h1>';
// Check if products were found
if ($result->num_rows > 0) {
    // Display products
    while($row = $result->fetch_assoc()) {
        // echo "Product Name: " . $row["product_name"] . "<br>";
        
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
                                        <li><a href="cart_receive.php? id=' . $row['product_id'] . '" name="send_cart" class="btn--cart cart--buy">
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
        // Display other product information as needed
    }
} else {
    echo "No products found in the 'headphones' category.";
    echo'<br />';
}

// Close the database connection
$conn->close();

?>

<link rel="stylesheet" href="../css/headphones_cat.css"/>
<?php
include('footer.php');
?>
