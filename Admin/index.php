<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../css/adminstyle.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <!-- <div class="container">
        <h1>Welcome to Dashboard</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div> -->
    <?php
        session_start();
        if (!isset($_SESSION["admin"])) 
        {
            ?> <h1>this is admin</h1>
                <nav>
                    <ul>
                        <li><a href = index.php>Home</a></li>
                        <li><a href = adminlogin.php>Login</a></li>
                        <li><a href = adminregister.php>Register</a></li>
                    </ul>
            </nav>
            <?php
        }
        if (isset($_SESSION["admin"])) 
        {
         
            if (isset($_POST["add_product"])) 
            {
                $productName = $_POST["product_name"];
                $productPrice = $_POST["product_price"];
                $productDescription = $_POST["product_info"];
                $productImage = $_FILES["product_image"]["name"];
                $errors =array();
               if (empty($productName) OR empty($productPrice) OR empty($productDescription)) {
                  array_push($errors,"all fields are required");
                }
                if (count($errors)>0) 
                    {
                        foreach ($errors as  $error) 
                        {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    }else
                        {   $targetDirectory = "../Uploads/";
                            $targetFile = $targetDirectory . basename($_FILES["product_image"]["name"]);
                            move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile);

                            require_once"dbconnect.php";
                            $sql = "INSERT INTO products(productName,productPrice,productDescription,productImage) VALUES ( ?, ?, ?, ? )";
                            $stmt = mysqli_stmt_init($conn);
                            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                           if($prepareStmt)
                            {
                                mysqli_stmt_bind_param($stmt,"siss", $productName,$productPrice,$productDescription,$productImage);
                                mysqli_stmt_execute($stmt);
                                echo "<div class='alert alert-success'>Product added successfully.</div>";         
                            }else {
                                die("something went wrong");
                            }
                            

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
            
                header('location: index.php');
            }
            
        
            ?>     
                <div class="container">
                    <h1>Welcome to Admin Dashboard </h1>
                    <a href="logout.php" class="btn btn-warning">Logout</a>
                </div>
                <div class ="container">
                    <div class = "admin_product_form_container">
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            <h3>add a new product</h3>
                            <input type="text" placeholder="enter product name" name="product_name" class="box">
                            <textarea rows="5" cols="50" placeholder="Write your description here..." name = "product_info" class = "box"></textarea>
                            <input type="number" placeholder="enter product base price" name="product_price" class="box">
                            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                            <input type="submit" class="btn" name="add_product" value="add product">
                        </form>
                    </div>
                    <?php
                        // Database connection 
                        require_once "dbconnect.php";
                        $select = mysqli_query($conn, "SELECT * FROM products");
   
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
                                        <a href="index.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
                                    </td>
            
                                </tr>
                            <?php } ?>
                            
                        </table>
                    </div>
                </div>
            <?php
        }
    ?>

</body>
</html>