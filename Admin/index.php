<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css">-->
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
            ?>
                <div class="container">
                    <h1>Welcome to Admin Dashboard</h1>
                    <a href="logout.php" class="btn btn-warning">Logout</a>
                </div>
            <?php
        }
    ?>

</body>
</html>