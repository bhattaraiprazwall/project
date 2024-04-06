<?php
include("admin_sidebar.php");
$error = 0;
$pname = $thumb = $description = $price = "";
$errpname = $errthumb = $errdesc = $errprice = "";

if (isset($_POST['btnSubmit'])) {
    if (isset($_POST['pname']) && !empty($_POST['pname']) && trim($_POST['pname'])) {
        $pname = $_POST['pname'];
    } else {
        $error++;
        $errpname = "Enter product name";
    }

    if ($_FILES['thumb']['error'] == 0) {
        if ($_FILES['thumb']['size'] < 2024000) {
            $filetype = ['image/png', 'image/jpeg'];
            if (in_array($_FILES['thumb']['type'], $filetype)) {
                $filename = uniqid() . '_' . $_FILES['thumb']['name'];
                if (move_uploaded_file($_FILES['thumb']['tmp_name'], '../../index_pages/uploaded_images/' . $filename)) {
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
        $error++;
        $errthumb = 'FileUpload Error';
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

    if (isset($_POST['cat_id']) && !empty($_POST['cat_id']) && trim($_POST['cat_id'])) {
        $cat_id = $_POST['cat_id'];
    } else {
        $error++;
        $errcat_id = "Please the cat_id";
    }

    if ($error === 0) {
        $err_pro= 'Product added successfully';
        include('../database/add_product_db.php');
    } else {
        $err_pro= 'Failed to add product';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="add_product_page.css"/>
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/add_product_page.css" />

</head>

<body class="add--pro">
    <form action="" method="post" enctype="multipart/form-data" class="product--form">
        <h2>Add Product</h2>
        <section class="add--product--form">
        <span class="err_pro"><?php echo (isset($err_pro)) ? $err_pro : ''; ?></span>
            <div class="product--add">
                <label for="pname" class="lbl--product">Product Name</label>
                <input type="text" name="pname" id="pname" class="txt--product" placeholder="Enter the product name"
                    value="<?php echo $pname; ?>" />
                <span class="error"><?php echo (isset($errpname)) ? $errpname : ''; ?></span>
            </div>

            <div class="product--add">
                <label for="thumb" class="lbl--product">Add Image</label>
                <input type="file" name="thumb" id="thumb" class="txt--product" />
                <span class="error"><?php echo (isset($errthumb)) ? $errthumb : ''; ?></span>
            </div>

            <div class="product--add">
                <label for="description" class="lbl--product" id="lbl--desc">Description</label>
                <input type="text" name="description" id="description" class="txt--product"
                    placeholder="Enter the product description" value="<?php echo $description; ?>" />
                    <span class="error"> <?php echo (isset($errdesc)) ? $errdesc : ''; ?></span>
            </div>

            <div class="product--add">
                <label for="price" class="lbl--product">Pricing</label>
                <input type="text" name="price" id="price" class="txt--product" placeholder="Enter the product price"
                    value="<?php echo $price; ?>" />
                    <span class="error"> <?php echo (isset($errprice)) ? $errprice : ''; ?></span>
            </div>

            

            <div class="product--add">
                <label for="cat-id" class="lbl--product">CAT ID</label>
                <input type="number" name="cat_id" class="txt--product" value="<?php echo $cat_id?>" />
                <span class="error"> <?php echo (isset($errcat_id)) ? $errcat_id : ''; ?></span>
            </div>

            <div class="product--add">
                <input type="submit" id="btnSubmit" class="add--submit" value="ADD PRODUCT" name="btnSubmit" />
            </div>
        </section>
    </form>
</body>

</html>
