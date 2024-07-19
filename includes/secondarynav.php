<!DOCTYPE html>
<html>
<head>
<title>Dropdown Menu</title>
<link rel="stylesheet" href="../../css/secondarynav.css"/>
</head>
<body>
<div class="category--menu-container">
<?php
require_once('../../database/database_connection.php');
// Fetch categories
$sql_categories = "SELECT *FROM category";
$result_categories = mysqli_query($conn, $sql_categories);
if($result_categories){
  echo'<a href="../../pages/index/dashboard.php" class="menu--list">Home</a>';
  while($row = mysqli_fetch_array($result_categories)){
    $category_name = $row['cat_name'];
    echo"<a href='../../pages/index/all_cat.php?id=$row[cat_id]' class='menu--list'>$category_name</a>";
  }
  echo '</div>';
}
?>
</body>
</html>
