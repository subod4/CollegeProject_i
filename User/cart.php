<?php
session_start();
if (!isset($_SESSION["logged_in"])) {
    header('Location: userlogin.php');
    exit;
}
$userId = $_SESSION["user"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products You Bid On</title>
    <link rel="stylesheet" href="../css/userstyle.css">
    <link rel="stylesheet" href="../css/userstyle1.css">
    <link rel="stylesheet" href="../css/item-container.css">
</head>
<body>
    <section id="header">
        <a href="#"><img id="logo" src="../images/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="bid.php">Lots</a></li>
                <li><a href="mailto:subodhbadal111@gmail.com">Contact Us</a></li>
                <li class="active"><a href="cart.php"><img id="icon" src="../images/bidding.png" alt=""></a></li>
                <?php
                if (!isset($_SESSION["user"])) {
                    echo '<li><a href="userlogin.php">Login</a></li>';
                } else {
                    echo '<li><a href="logout.php">Logout</a></li>';
                }
                ?>
            </ul>
        </div>
    </section>

    <section id="lots">
        <h1 class="lots">Your Bids</h1>
        <?php
        // Fetch and display products the user has bid on
        require_once "dbconnect.php";
        $sql = "SELECT bids.*, products.productName, products.productDescription, products.productPrice, products.productImage, products.bid_action, products.id
        FROM bids
        INNER JOIN products ON bids.productid = products.id
        WHERE bids.userid = $userId";


        $result = mysqli_query($conn, $sql);

        // Display the bid details
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="bigcontainer">
                <div class="item-container">
                    <img src="../Uploads/<?php echo $row['productImage']; ?>" alt="Item Image" class="item-image">
                    <div class="item-details">
                        <div class="item-name"><?php echo $row['productName']; ?></div>
                        <div class="item-price-condition">
                            <div class="item-price-container">Current Price <span class="price">$<?php echo $row['productPrice']; ?>/-</span></div>
                            <div class="yourbid-container">Your Bid<span class="price">$<?php echo ($row['bidamount']); ?></span></div>
                            <div class="item-condition">Condition <span class="condition">New</span></div>
                            <!-- You may need to adjust this according to your database structure -->
                            <div class="item-status-container">Status <span class="price"><?php echo ($row['bid_action'] == "StopBid") ? "Open" : "Closed"; ?></span></div>
                        </div>
                        <textarea class="item-description" readonly placeholder="Product Description"><?php echo $row['productDescription']; ?></textarea>
                        <?php
                        if (isset($_SESSION["user"])) {
                            // If logged in, show the "Place Your Bid" button
                            echo '<a href="placebid.php?productId=' . $row['id'] . '" class="item-button">Place Your Bid Again</a>';
                        } else {
                            // If not logged in, redirect to userlogin.php when the button is clicked
                            echo '<a href="userlogin.php" class="item-button">Login to Bid</a>';
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </section>
</body>
</html>
