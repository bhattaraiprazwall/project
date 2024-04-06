<?php
include('admin_sidebar.php');
$cat_name="";
$cat_error="";
    if(isset($_POST['add_cat'])){
        if(isset($_POST['cat_name'])&& !empty($_POST['cat_name'])&& trim($_POST['cat_name'])){
            $cat_name=$_POST['cat_name'];
            include('../database/category_insert.db.php');
            echo'<script>alert("Category added successfully")</script>';
        }
        else{
            $cat_error='Please input category name';
        }  
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/category_insert_form.css"/>
    <title>Add Category</title>
</head>
<body>
    <form action="" method="post" class="cat-add-form">
        <label for="cat_name" class="lbl--cat">Category Name</label>
        <input type="text" name="cat_name" class="txt--cat" placeholder="Enter the category name"/>
        <?php echo (isset($cat_error)) ? $cat_error : ''; ?>
        <div class="add--cat--btn">
        <input type="submit" name="add_cat" value="Add Category" class="btn-add-category"/>
        </div>
    </form>
</body>
</html>