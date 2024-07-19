<?php 
session_start();
if(!isset($_SESSION['admin_id'])){
    header('location:admin_login.php?err=1');
}
include("../../includes/admin_sidebar.php");
?>

<link rel="stylesheet" href="../../css/admin_dashboard.css"/>
        <div class="main--content">
            <h2>Users List</h2>
            <div class="user--list">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>PASSWORD</th>
                        <th>PHONE</th>
                        <th>ADDRESS</th>
                        <th>CITY</th>
                        <th>ACTIONS</th>
                    </tr>
                    <?php
                    // Handle Delete Action
                    if (isset($_POST['btnDelete'])) {
                        $userId = $_POST['id'];
                        $connection = mysqli_connect('localhost', 'root', '', 'electronics_store');
                        $deleteQuery = "DELETE FROM users_data WHERE id = $userId";
                        if (mysqli_query($connection, $deleteQuery)) {
                            // Data deleted successfully
                            echo "User deleted successfully!";
                            // You may choose to redirect or refresh the page after deletion
                            // header("Location: admin_dashboard.php");
                            // exit();
                        } else {
                            echo "Error deleting user: " . mysqli_error($connection);
                        }
                    }

                    // Display User List
                    try {
                        $connection = mysqli_connect('localhost', 'root', '', 'electronics_store');
                        $select = "SELECT * FROM users_data";
                        $result = mysqli_query($connection, $select);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['password'] . '</td>
                    <td>' . $row['phone'] . '</td>
                    <td>' . $row['address'] . '</td>
                    <td>' . $row['city'] . '</td>
                    <td>
                        <span class="user-actions">
                            <a href="edit_user.php?id=' . $row['id'] . '" onclick="return confirm(\'are you sure to edit the user?\')"; class="btn--action");">Edit</a>
                            <form action="" method="POST">
                                <input type="hidden" name="id" value="' . $row['id'] . '" />
                                <input type="submit" name="btnDelete" onlick="return confirm("Are you sure to delete?");" value="Delete" class="delete--action"/>
                            </form>
                        </span>
                    </td>
                </tr>';
                            }
                        }
                    } catch (Exception $ex) {
                        die('Database Error' . $ex->getMessage());
                    }
                    ?>

                </table>
            </div>
        </div>
        <script>
    if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>

</html>