<?php

require_once "dbconnect.php";

$id = $_GET['edit'];

if(isset($_POST['update_product']))
{

    $productName = $_POST["product_name"];
    $productPrice = $_POST["product_price"];
    $productDescription = $_POST["product_info"];
    $productImage = $_FILES["product_image"]["name"];
    $errors =array();

    if (empty($productName) OR empty($productPrice) OR empty($productDescription) OR empty($productImage)) 
    {
        array_push($errors,"all fields are required");
    }
    if (count($errors)>0) 
    {
        foreach ($errors as  $error) 
        {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
    
    else
    {    if (!empty($productImage)) {
        // Remove the existing image file
        $stmt = mysqli_prepare($conn, "SELECT productImage FROM products WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $existingImage);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        $existingImagePath = "../Uploads/" . $existingImage;

        if (file_exists($existingImagePath)) {
            unlink($existingImagePath); // Remove the existing file
        }

        // Upload the new image
        $targetDirectory = "../Uploads/";
        $targetFile = $targetDirectory . basename($_FILES["product_image"]["name"]);
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile);
    }
        $update_data = "UPDATE products SET productName='$productName', productPrice='$productPrice',productDescription='$productDescription', productImage='$productImage'  WHERE id = '$id'";
        $upload = mysqli_query($conn, $update_data);
        if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            header('location:index.php');
         }else{
            $$message[] = 'please fill out all!'; 
         }
    }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../css/adminstyle.css">
   <title>Edit product</title>
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

<div class="container">


<div class="admin-product-form-container centered">

   <?php
      
      $select = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h2 class="title">Update the "<?php echo $row['productName']; ?>" </h3>
      <input type="text" class="box" name="product_name" value="<?php echo $row['productName']; ?>" placeholder="enter the product name">
      <textarea rows="5" cols="50"  value="<?php echo $row['productDescription']; ?>"placeholder="Write your description here..." name = "product_info" class = "box"></textarea>
      <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['productPrice']; ?>" placeholder="enter the product price">
      <input type="file" class="box" name="product_image"  accept="image/png, image/jpeg, image/jpg">
      <input type="submit" value="update product" name="update_product" class="btn">
      <a href="index.php" class="btn">go back!</a>
   </form>
   


   <?php }; ?>

   

</div>

</div>

</body>
</html>