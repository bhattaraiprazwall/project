<?php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    // Fetch user data from the database
    include ('../../database/database_connection.php');
    $select = "SELECT * FROM products WHERE product_id= $product_id";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) == 1) {
        $product_data = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
        exit(); // Exit if Product not found
    }
} else {
    echo "Product ID not provided.";
    exit(); // Exit if Product ID not provided
}
$error = 0;
$pname = $brand = $thumb = $description = $price = $quantity = "";
$errpname = $errbrand = $errthumb = $errdesc = $errprice = $errquantity = "";

// Check if form is submitted for updating Product data
if (isset($_POST['updateProduct'])) {
    // Retrieve form data
    if (isset($_POST['pname']) && !empty($_POST['pname']) && trim($_POST['pname'])) {
        $pname = $_POST['pname'];
    } else {
        $error++;
        $errpname = "Enter product name";
    }

    if (isset($_POST['brand']) && !empty($_POST['brand']) && trim($_POST['brand'])) {
        $brand = $_POST['brand'];
    } else {
        $error++;
        $errbrand = "Enter the brand";
    }


    if ($_FILES['thumb']['error'] == 0) {
        if ($_FILES['thumb']['size'] < 2024000) {
            $filetype = ['image/png', 'image/jpeg'];
            if (in_array($_FILES['thumb']['type'], $filetype)) {
                $filename = uniqid() . '_' . $_FILES['thumb']['name'];
                if (move_uploaded_file($_FILES['thumb']['tmp_name'], '../../images/uploaded_images/' . $filename)) {
                    // Display the uploaded image
                    echo 'File upload success';
                    $thumb = $filename; // Save the filename after successful upload
                } else {
                    $error++;
                    $errthumb = 'Upload failed';
                }
            } else {
                $error++;
                $errthumb = 'File type must be png/jpeg';
            }
        } else {
            $error++;
            $errthumb = 'File size must be below 1 MB';
        }
    } else {
        $thumb = $product_data['thumb']; // use existing image if not updated
    }

    if (isset($_POST['description']) && !empty($_POST['description']) && trim($_POST['description'])) {
        $description = $_POST['description'];
    } else {
        $error++;
        $errdesc = "Mention product description";
    }

    if (isset($_POST['price']) && !empty($_POST['price']) && trim($_POST['price'])) {
        $price = $_POST['price'];
    } else {
        $error++;
        $errprice = "Enter the price";
    }

    if (isset($_POST['quantity']) && !empty($_POST['quantity']) && trim($_POST['quantity'])) {
        $quantity = $_POST['quantity'];
    } else {
        $error++;
        $errquantity = "Enter the quantity";
    }

    if (isset($_POST['cat_id']) && !empty($_POST['cat_id']) && trim($_POST['cat_id'])) {
        $cat_id = $_POST['cat_id'];
    } else {
        $error++;
        $errcat_id = "Please input the cat_id";
    }

    if ($error === 0) {
        $err_pro = 'Product added successfully';
        // Update user data in the database
        $updateQuery = "UPDATE products SET product_name = '$pname', brand = '$brand', thumb = '$thumb', description = '$description', price = '$price', quantity = '$quantity' ,cat_id='$cat_id' WHERE product_id = '$product_id'";
        if (mysqli_query($conn, $updateQuery)) {
            echo "User data updated successfully!";
            header('location:product_list.php');
            // You may choose to redirect back to the admin dashboard after updating
            // header("Location: admin_dashboard.php");
            // exit();
        }
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}

?>
<style>
    body.add--pro {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .product--form {
        background-color: #fff;
        width: 400px;
        margin: 50px auto;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .add--product--form {
        margin-bottom: 20px;
    }

    .lbl--product {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .txt--product {
        width: calc(100% - 10px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .error {
        color: #ff0000;
        font-size: 14px;
        display: block;
        margin-top: -10px;
        margin-bottom: 10px;
    }

    .add--submit {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .add--submit:hover {
        background-color: #0056b3;
    }
</style>

<body class="add--pro">
    <form action="" method="post" enctype="multipart/form-data" class="product--form">
        <h2>EDIT PRODUCT</h2>
        <section class="add--product--form">
            <span class="err_pro"><?php echo (isset($err_pro)) ? $err_pro : ''; ?></span>
            <div class="product--add">
                <label for="pname" class="lbl--product">Product Name</label>
                <input type="text" name="pname" id="pname" class="txt--product" placeholder="Enter the product name"
                    value="<?php echo $product_data['product_name']; ?>" />
                <span class="error"><?php echo (isset($errpname)) ? $errpname : ''; ?></span>
            </div>

            <div class="product--add">
                <label for="brand" class="lbl--product">Brand</label>
                <input type="text" name="brand" id="brand" class="txt--product" placeholder="Enter the product brand"
                    value="<?php echo $product_data['brand']; ?>" />
                <span class="error"> <?php echo (isset($errbrand)) ? $errbrand : ''; ?></span>
            </div>

            <div class="product--add">
                <label for="thumb" class="lbl--product">Add Image</label>
                <input type="file" name="thumb" id="thumb" class="txt--product" />
                <span class="error"><?php echo (isset($errthumb)) ? $errthumb : ''; ?></span>
            </div>

            <div class="product--add">
                <label for="description" class="lbl--product" id="lbl--desc">Description</label>
                <textarea name="description" id="description" class="txt--product" rows="4" cols="50"
                    placeholder="Enter the product description"><?php echo $product_data['description']; ?></textarea>
                <span class="error"> <?php echo (isset($errdesc)) ? $errdesc : ''; ?></span>
            </div>

            <div class="product--add">
                <label for="price" class="lbl--product">Pricing</label>
                <input type="text" name="price" id="price" class="txt--product" placeholder="Enter the product price"
                    value="<?php echo $product_data['price']; ?>" />
                <span class="error"> <?php echo (isset($errprice)) ? $errprice : ''; ?></span>
            </div>

            <div class="product--add">
                <label for="quantity" class="lbl--product">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="txt--product"
                    placeholder="Enter the product quantity" value="<?php echo $product_data['quantity']; ?>" />
                <span class="error"> <?php echo (isset($errquantity)) ? $errquantity : ''; ?></span>
            </div>


            <div class="product--add">
                <label for="cat-id" class="lbl--product">CAT ID</label>
                <input type="number" name="cat_id" class="txt--product"
                    value="<?php echo $product_data['cat_id']; ?>" />
                <span class="error"> <?php echo (isset($errcat_id)) ? $errcat_id : ''; ?></span>
            </div>

            <div class="product--add">
                <input type="submit" id="btnSubmit" class="add--submit" value="UPDATE PRODUCT" name="updateProduct" />
            </div>
        </section>
    </form>
    <script>
    if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>

</html>