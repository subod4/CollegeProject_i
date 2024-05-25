<?php
session_start();
@include 'nav.php';
require_once "dbconnect.php";
$select = mysqli_query($conn, "SELECT * FROM users");
if (isset($_GET['delete'])) {
    require_once "dbconnect.php";
    $id = $_GET['delete'];
    // Delete the product from the database
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    header('location: manageuser.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/adminstyle.css">
    <link rel="stylesheet" href="../css/userstyle1.css">
</head>
<body>
   <div class="product-display">
        <table class="product-display-table">
            <thead>
                <tr class="table">
                    <td>User Name</td>
                    <td>Email</td>
                    <td>Action</td>
                </tr>
            </thead>
            <?php while($row = mysqli_fetch_assoc($select)) { ?>
            <tr class="table">
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="manageuser.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>