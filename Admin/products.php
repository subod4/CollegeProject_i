<?php
session_start();
@include 'nav.php';
require_once "dbconnect.php";

// Check if the toggle bid action button is clicked
if(isset($_POST['toggle_bid'])) {
    // Retrieve product ID and bid action state from the form submission
    $productId = $_POST['product_id'];
    $bid_action = ($_POST['current_action'] == 'StartBid') ? 'StopBid' : 'StartBid';
    
    // Update bid action state in the database
    $sqlupdate = "UPDATE products SET bid_action = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sqlupdate)) {
        mysqli_stmt_bind_param($stmt, "si", $bid_action, $productId);
        mysqli_stmt_execute($stmt);
        echo "<div class='alert alert-success'>Bid action updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to update bid action.</div>";
    }
}
if (isset($_GET['delete'])) {
    require_once "dbconnect.php";
    $id = $_GET['delete'];

    // Retrieve the product image filename before deletion
    $stmt = mysqli_prepare($conn, "SELECT productImage FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $productImage);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Delete the product from the database
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");

    // Remove the associated image file
    $imagePath = "../Uploads/" . $productImage;
    if (file_exists($imagePath)) {
        unlink($imagePath); // Remove the file from the directory
    }

    header('location: products.php');
}


// Retrieve products data including bid action state
$select = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../css/adminstyle.css">
</head>
<body>
    <div class="product-display">
        <table class="product-display-table">
            <thead>
                <tr class="table">
                    <td>Product Image</td>
                    <td>Product Name</td>
                    <td>Product Baseprice</td>
                    <td>Action</td>
                    <td>Bid Action</td>
                </tr>
            </thead>
            <?php while($row = mysqli_fetch_assoc($select)) { ?>
            <tr class="table">
            <td class="image-container">
                <img src="../Uploads/<?php echo $row['productImage']; ?>" alt="">
            </td>
                <td><?php echo $row['productName']; ?></td>
                <td>$<?php echo $row['productPrice']; ?>/-</td>
                <td>
                    <a href="updateproduct.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                    <a href="products.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
                </td>
 <td>
    <!-- Display the button with dynamic text -->
    <form method="post">
        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
        <input type="hidden" name="current_action" value="<?php echo $row['bid_action']; ?>">
        <button type="submit" class="btn" name="toggle_bid">
            <?php echo $row['bid_action']; ?>
        </button>
    </form>
</td>

            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
