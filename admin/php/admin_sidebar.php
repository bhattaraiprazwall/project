<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin_dashboard.css" />

</head>

<body class="admin--sidebar">
    <div class="header">
        <div class="side-nav">
            <div class="user">
                <img src="../icons-images/user.png" class="user--img" />
                <div>
                    <h2>Prajwal Bhattarai</h2>
                    <p>prajwalbhattarai80@gmail.com</p>
                </div>
                <img src="../icons-images/star.png" class="star-img" />

            </div>
            <ul class="admin--menu">
                <li>
                    <img src="../icons-images/dashboard.svg" />
                    <a href="../php/admin_dashboard.php">Dashboard</a>
                </li>
                <li>
                    <img src="../icons-images/category.svg">
                    <a href="../php/category_insert_form.php" id="add_category_admin">Category</a>
                </li>
                <li>
                    <img src="../icons-images/products.svg">
                    <a href="../php/add_product_page.php" name="add_product_admin" id="add_product_admin">Products</a>
                </li>
                <li>
                    <img src="../icons-images/orders-svgrepo-com.svg">
                    <a href=""> Orders</a>
                </li>
                <li>
                    <img class="user-img" src="../icons-images/download.svg">
                    <a href="">Add User</a>
                </li>

            </ul>
            <ul>
                <li><img src="../icons-images/logout.png">
                <a href="admin_logout.php">Logout</a>
                </li>
            </ul>

        </div>