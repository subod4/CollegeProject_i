<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> User Registration</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" type="text/css" href="../css/loginstyle.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>
<body>
   
<div class="form-container">
<?php
       if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordRepeat = $_POST["cpassword"];
        $passwordHash = password_Hash($password, PASSWORD_DEFAULT);


        $errors =array();
        if (empty($username) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"all fields are required");
       }
       if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
       {
           array_push($errors,"email not valid");
       }
       if(strlen($password) < 6)
       {
           array_push($errors,"password must be 6 char long");
       }
       if($password!==$passwordRepeat)
       {
           array_push($errors,"password did not match");
       }
       require_once"dbconnect.php";
       $sql = "SELECT * FROM users WHERE email = '$email'";
       $result = mysqli_query($conn, $sql);
       $rowCount = mysqli_num_rows($result);
       if ($rowCount>0) 
       {
          array_push($errors,"Email already exists!");
       }
       if (count($errors)>0) 
       {
          foreach ($errors as  $error) 
           {
              echo "<div class='alert alert-danger'>$error</div>";
           }
       }else
       {
           require_once"dbconnect.php";
           $sql = "INSERT INTO users(username,email,password) VALUES ( ?, ?, ? )";
           $stmt = mysqli_stmt_init($conn);
           $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
           if($prepareStmt)
           {
            mysqli_stmt_bind_param($stmt,"sss", $username,$email,$passwordHash);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'>You are registered successfully.</div>";         
          }else {
            die("something went wrong");
          }

       }
       }
    ?>

   <form action="userregister.php" method="post">
      <h3>Register now</h3>
      <input type="text" name="username" required placeholder="Enter your username">
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
   
      <input type="submit" name="submit" value="Register now" class="form-btn">
      <p>Already have an account? <a href="userlogin.php">Login now</a></p>
   </form>
</div>

</body>
</html>
