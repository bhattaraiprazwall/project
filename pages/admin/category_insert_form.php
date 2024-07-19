<?php
include('../../includes/admin_sidebar.php');
$cat_name="";
$cat_error="";
if(isset($_POST['add_cat']))
{
  if(isset($_POST['cat_name'])&& !empty($_POST['cat_name'])&& trim($_POST['cat_name']))
  {
    $cat_name=$_POST['cat_name'];
    include('../../database/category_insert.db.php');
    echo'<script>alert("Category added successfully")</script>';
  }
  else
  {
    $cat_error='Please input category name';
  }  
}
if (isset($_POST['btnDelete'])) 
{
  $cat_id= $_POST['id'];
  require_once('../../database/database_connection.php');
  $deleteQuery = "DELETE FROM category where cat_id='$cat_id'";
  if (mysqli_query($conn, $deleteQuery)) 
  {
      // Data deleted successfully
   echo "Category deleted successfully!";
      // You may choose to redirect or refresh the page after deletion
      // header("Location: admin_dashboard.php");
      // exit();
  }
  else 
  {
    echo "Error deleting category: " . mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/category_insert_form.css"/>
    <title>Add Category</title>
    <script>
    if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>
<body>
    <form action="" method="post" class="cat-add-form">
        <label for="cat_name" class="lbl--cat">Category Name</label>
        <input type="text" name="cat_name" class="txt--cat" placeholder="Enter the category name"/>
        <span class="cat--error"><?php echo (isset($cat_error)) ? $cat_error : ''; ?></span>
        <div class="add--cat--btn">
        <input type="submit" name="add_cat" value="Add Category" class="btn-add-category"/>
        </div>
    </form>
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Category List</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2 class="title">Category List</h2>
  <table class="category-table">
    <thead>
      <tr>
        <th class="category-id">Category ID</th>
        <th class="category-name">Category Name</th>
        <th class="category-action">Action</th>
      </tr>
    </thead>
    <tbody>
      
      <?php
        require_once('../../database/database_connection.php');
        $sql="SELECT *FROM category";
        $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_array($result))
        {
          // print_r($row);
          echo'
          <tr>
          <td class="category-id">'.$row['cat_id'].'</td>
          <td class="category-name">'.$row['cat_name'].'</td>
          <td class="category-action">
          <form action="'.$_SERVER['PHP_SELF'].'" method="POST">
            <input type="hidden" name="id" value="' . $row['cat_id'] . '" />
            <input type="submit" name="btnDelete" value="Delete" class="delete-btn"/>
          </form>
          </td>
          </tr>';
        }
        ?>
      <!-- Add more category rows here -->
    </tbody>
  </table>
</body>
</html>

</body>
</html>