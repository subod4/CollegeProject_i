<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../css/adminstyle.css">
    <link rel="stylesheet" href="../css/userstyle1.css">
    <style>
      
        .notloggedin{
            background-color: black;
            text-align: center;
            color: white;
          
        }
        .notloggedin a{
            background: #ff9000;
            color:#ffffff;
            text-transform: capitalize;
            font-size: 20px;
            cursor: pointer;
            text-decoration: none;
            padding: 20px 20px;
            /* margin: 40px 40px; */
            border-radius: 5px;
        }
        .notloggedin a:hover{
            background: #ffa31a;
            color:#fff;
        }

        
    </style>
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
            ?> 
                <body class ="notloggedin">
                    <div>
                        <h1>Please Login to Continue</h1>
                        <a href="adminlogin.php">login</a>
                    </div>
                </body>
                
                
             <?php
        }
        if (isset($_SESSION["admin"])) 
        {
           @include 'nav.php';
           ?>
           <body>
            
           </body>
           <h1>hi admin you are logged in</h1>
           <?php
        }
    ?>

</body>
</html>