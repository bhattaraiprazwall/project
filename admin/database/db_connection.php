<?php
// Handle Delete Action
if(isset($_POST['btnDelete'])) {
    $userId = $_POST['id'];
    $connection = mysqli_connect('localhost', 'root', '', 'electronics_store');
    $deleteQuery = "DELETE FROM users_data WHERE id = $userId";
    if(mysqli_query($connection, $deleteQuery)) {
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
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['name'].'</td>
                <td>'.$row['email'].'</td>
                <td>*****</td> <!-- Displaying a placeholder for password -->
                <td>'.$row['phone'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['city'].'</td>
                <td>
                    <span class="user-actions">
                        <a href="edit_user.php?id='.$row['id'].'">Edit</a>
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="' . $row['id'] . '" />
                            <input type="submit" name="btnDelete" value="Delete" class="delete"/>
                        </form>
                    </span>
                </td>
            </tr>';
        }
    }
} catch(Exception $ex) {
    die('Database Error'.$ex->getMessage());
}
?>
