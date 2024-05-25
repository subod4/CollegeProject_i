<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuctionHub</title>
    <link rel="stylesheet" href="../css/userstyle.css">
    <link rel="stylesheet" href="../css/userstyle1.css">
    <link rel="stylesheet" href="../css/item-container.css">
</head>
<body>
    <section id="header">
        <a href="#"><img id="logo" src="../images/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="bid.php">Lots</a></li>
                <li><a href="mailto:subodhbadal111@gmail.com">Contact Us</a></li>
                <li>
                    <?php
                    
                        if (!isset($_SESSION["logged_in"])) {
                            echo '<a href="userlogin.php"><img id="icon" src="../images/bidding.png" alt=""></a>';
                        } else {
                            echo '<a href="cart.php"><img id="icon" src="../images/bidding.png" alt=""></a>';
                        }
                    ?>
                </li>

                <?php
                if (!isset($_SESSION["logged_in"])) {
                    echo '<li><a href="userlogin.php">Login</a></li>';
                } else {
                    echo '<li><a href="logout.php">Logout</a></li>';
                }
                ?>
            </ul>
        </div>
    </section>

    <section id="hero">
        <div class="hero-container">
            <h1>Bid, Win, Thrill!</h1>
            <p>Uncover rare finds, place secure bids, and win unique treasures.<br>Elevate your collecting experience today!</p>
            <a href="bid.php" class="btn">Start Bidding</a> 
        </div>
    </section>
</body>
</html>
