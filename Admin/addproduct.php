<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="../css/adminstyle.css">
</head>
<body>
    <?php
    @include 'nav.php';
    require_once "dbconnect.php";
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
    ?>
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
    </div>
</body>
</html>
