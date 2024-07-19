<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/admin_dashboard.css" />

</head>

<body class="admin--sidebar">
        <section class="side-nav">
            <div class="user">
                <img src="../../assets/user.png" class="user--img" />
                <div>
                    <h2>Prajwal Bhattarai</h2>
                    <p>prajwalbhattarai80@gmail.com</p>
                </div>
                <img src="../../assets/star.png" class="star-img" />

            </div>
            <ul class="admin--menu">
                <li>
                    <img src="../../assets/dashboard.svg" />
                    <a href="../../pages/admin/admin_dashboard.php" class="sidebar--menu--list">Dashboard</a>
                </li>
                <li>
                    <img src="../../assets/category.svg">
                    <a href="../../pages/admin/category_insert_form.php" id="add_category_admin"
                        class="sidebar--menu--list">Category</a>
                </li>
                <li>
                    <img src="../../assets/products.svg">
                    <a href="../../pages/admin/product_list.php" name="add_product_admin" id="add_product_admin"
                        class="sidebar--menu--list">Products</a>
                </li>
                <li>
                    <img src="../../assets/orders-svgrepo-com.svg">
                    <a href="../../pages/admin/orders_page.php" class="sidebar--menu--list"> Orders</a>
                </li>
            </ul>
            <ul>
                <li><img src="../../assets/logout.png">
                    <a href="../../pages/admin/admin_logout.php" class="sidebar--menu--list">Logout</a>
                </li>
            </ul>
        </section>