<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login into the website</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" type="text/css" href="../css/loginstyle.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">


</head>
<body>
   
<div class="form-container">
<?php
session_start();

// Database connection (replace placeholders with your credentials)
require_once "dbconnect.php";

// Check if the login form is submitted
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    if ($user) {
                if (password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die();
                }else{
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            }else{
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }

?>


   <form action="userlogin.php" method="post">
      <h3>login now</h3>
      
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="login" value="login" class="form-btn">
     
      
      <p>don't have an account? <a href="userregister.php">register now</a></p>
   </form>

</div>

</body>
</html>