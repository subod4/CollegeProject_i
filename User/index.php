<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../css/userstyle.css">
    <link rel="stylesheet" href="../css/userstyle1.css">
    <link rel="stylesheet" href="../css/item-container.css">
    <title>User Dashboard</title>
</head>
<body>
    <!-- <div class="container">
        <h1>Welcome to Dashboard</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div> -->
    <?php
        session_start();
        if (!isset($_SESSION["user"])) 
        {
            ?>
                 <body>
    <section id = "header">
        <a href="#"><img id="logo" src="../images/logo.png" class="logo" alt=""></a>
         
        <div>
            <ul id="navbar">
                <li class="active"><a href="index.html">Home</a></li>
                <li><a href="bid.html">Bid</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                <li><a href="cart.html"><img id="icon" src="../images/bidding.png" alt=""></a></li>
                <li><a href="userlogin.php">login</a></li>

            </ul>
        </div>
    </section>
    <section id="hero">
        <body>
            <div class="hero-container">
              <h1>Bid, Win, Thrill!</h1>
              <p>Uncover rare finds, place secure bids, and win unique treasures.<br>Elevate your collecting experience today!</p>
              <a href="#">Get Started</a> <img class="hero-image" src="../images/auction.png" alt="Background Image">
            </div>
           
          </body>
    </section>
    <section id="lots">
        <div class="item-container">
            <img src="../images/bidding.png" alt="Item Image" class="item-image">
            <div class="item-details">
              <div class="item-name">Item Name</div>
              <div class="item-price-condition">
                <div class="item-price-container">Price <span class="price">$100</span></div>
                <div class="item-condition">Condition <span class="condition">New</span></div>
              </div>
              <textarea class="item-description" readonly placeholder="product description"></textarea>
              <button class="item-button">Buy Now</button>
            </div>
          </div>
    </section>
    <div class="item-container">

    </div>
  </body>
            <?php
        }
        if (isset($_SESSION["user"])) 
        {
            ?>
                                <body>
    <section id = "header">
        <a href="#"><img id="logo" src="../images/logo.png" class="logo" alt=""></a>
         
        <div>
            <ul id="navbar">
                <li class="active"><a href="index.html">Home</a></li>
                <li><a href="bid.html">Bid</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                <li><a href="cart.html"><img id="icon" src="../images/bidding.png" alt=""></a></li>
                <li><a href="logout.php">logout</a></li>

            </ul>
        </div>
    </section>
    <section id="hero">
        <body>
            <div class="hero-container">
              <h1>Bid, Win, Thrill!</h1>
              <p>Uncover rare finds, place secure bids, and win unique treasures.<br>Elevate your collecting experience today!</p>
              <a href="#">Get Started</a> <img class="hero-image" src="../images/auction.png" alt="Background Image">
            </div>
           
          </body>
    </section>
    <h1 class= "lots">All lots</h1>
        <?php
            // Database connection 
            require_once "dbconnect.php";
            $select = mysqli_query($conn, "SELECT * FROM products");
   
            while($row = mysqli_fetch_assoc($select)) {
        ?>
                <section id="lots">
                    
        <div class="item-container">
            <img src="../Uploads/<?php echo $row['productImage']; ?>" alt="Item Image" class="item-image">
            <div class="item-details">
              <div class="item-name"><?php echo $row['productName']; ?></div>
              <div class="item-price-condition">
                <div class="item-price-container">Price <span class="price">$<?php echo $row['productPrice']; ?>/-</span></div>
                <div class="item-condition">Condition <span class="condition">New</span></div>
              </div>
              <textarea class="item-description" readonly placeholder="product description"><?php echo $row['productDescription']; ?></textarea>
              <button class="item-button"> Place Your Bid</button>
            </div>
          </div>
    </section>
        <?php } ?>
    </div>
            <?php
        }
    ?>

</body>
</html>