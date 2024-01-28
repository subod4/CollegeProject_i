<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../css/adminstyle.css">
</head>
<body>
    <?php
    @include 'nav.php';
    require_once "dbconnect.php";
    $select = mysqli_query($conn, "SELECT * FROM products");
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
    ?>
<div class="product-display">
    <table class = "product-display-table">
        <thead>
            <tr>
                <td>Product Image</td>
                <td>Product Name</td>
                <td>Product Baseprice</td>
                <td>Action</td>
            </tr>
        </thead>
                           
    <?php while($row = mysqli_fetch_assoc($select)){ ?>
        <tr>
            <td><img src="../Uploads/<?php echo $row['productImage']; ?>" height="100" alt=""></td>
                <td><?php echo $row['productName']; ?></td>
                <td>$<?php echo $row['productPrice']; ?>/-</td>
                <td>
                    <a href="updateproduct.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                    <a href="products.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
                </td>
            
            </tr>
    <?php } ?>
</body>
</html>