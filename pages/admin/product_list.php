    <?php
    include ('../../includes/admin_sidebar.php');
    if (isset($_POST['btnDelete'])) {
        $prod_id= $_POST['id'];
        require_once('../../database/database_connection.php');
        $deleteQuery = "DELETE FROM products WHERE product_id = '$prod_id'";
        if (mysqli_query($conn, $deleteQuery)) {
            // Data deleted successfully
            echo "Product deleted successfully!";
            // You may choose to redirect or refresh the page after deletion
            // header("Location: admin_dashboard.php");
            // exit();
        } else {
            echo "Error deleting product: " . mysqli_error($connection);
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product List</title>
        <link rel="stylesheet" href="../../css/product_list.css">
        <script>
    if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    }
</script>
    </head>

    <body class="product--list">
        <h1 class="products--heading">Products List</h1>
        <a href="add_product_page.php" class="add--product--button">ADD NEW PRODUCT</a>
        <table class="product--table">
            <thead>
                <tr>
                    <th class="product--head">Image</th>
                    <th class="product--head">Name</th>
                    <th class="product--head">Price</th>
                    <th class="product--head">Action</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php include('../../database/database_connection.php');
                $sql="SELECT *FROM products";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_array($result)){
                        echo'
                <tr>
                    <td class="product--data"><img src="../../images/uploaded_images/' . $row['thumb'] . '" class="tbl--image" /></td>
                    <td class="product--data">'.$row['product_name'].'</td>
                    <td class="product--data">Rs '.$row['price'].'</td>
                    <td class="product--data">
                    <span class="user-actions">
                        <a href="edit_product.php?id=' . $row['product_id'] . '">Edit</a>
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="' . $row['product_id'] . '" />
                            <input type="submit" name="btnDelete" value="Delete" class="delete"/>
                        </form>
                    </span>
                    </td>
                </tr>';
            }
        }
            ?>
            </tbody>
        </table>
    </body>

    </html>