<?php
session_start();
@include 'nav.php';
require_once "dbconnect.php";

// Check if the toggle bid action button is clicked
if(isset($_POST['toggle_bid'])) {
    // Retrieve product ID and bid action state from the form submission
    $productId = $_POST['product_id'];
    $bid_action = ($_POST['current_action'] == 'StartBid') ? 'StopBid' : 'StartBid';
    
    // Update bid action state in the database
    $sqlupdate = "UPDATE products SET bid_action = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sqlupdate)) {
        mysqli_stmt_bind_param($stmt, "si", $bid_action, $productId);
        mysqli_stmt_execute($stmt);
        echo "<div class='alert alert-success'>Bid action updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to update bid action.</div>";
    }
}

// Retrieve products data including bid action state
$select = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Lots</title>
    <link rel="stylesheet" href="../css/userstyle.css">
    <link rel="stylesheet" href="../css/userstyle1.css">
    <link rel="stylesheet" href="../css/item-container.css">
</head>
<body>
<section id="header">
        <a href="#"><img id="logo" src="../images/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li ><a href="index.php">Home</a></li>
                <li class="active"><a href="bid.php">Lots</a></li>
                <li><a href="mailto:subodhbadal111@gmail.com">Contact Us</a></li>
                <li>
                    <?php
                        if (!isset($_SESSION["user"])) {
                            echo '<a href="userlogin.php"><img id="icon" src="../images/bidding.png" alt=""></a>';
                        } else {
                            echo '<a href="cart.php"><img id="icon" src="../images/bidding.png" alt=""></a>';
                        }
                    ?>
                </li>

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
        <h1 class="lots">Lots</h1>
        <?php
        // Fetch and display products
        while ($row = mysqli_fetch_assoc($select)) {
            ?>
            <div class="bigcontainer">
                <div class="item-container">
                    <img src="../Uploads/<?php echo $row['productImage']; ?>" alt="Item Image" class="item-image">
                    <div class="item-details">
                        <div class="item-name"><?php echo $row['productName']; ?></div>
                        <div class="item-price-condition">
                            <div class="item-price-container">Current Price <span class="price">$<?php echo $row['productPrice']; ?>/-</span></div>
                            <div class="item-condition">Condition <span class="condition">New</span></div>
                            <div class="item-status-container">Status <span class="price"><?php echo ($row['bid_action'] == "StopBid") ? "Open" : "Closed"; ?></span></div>
                        </div>
                        <textarea class="item-description" readonly placeholder="product description"><?php echo $row['productDescription']; ?></textarea>
                        <?php
                        // Check if the user is logged in
                        if (isset($_SESSION["user"])) {
                            // If logged in, show the "Place Your Bid" button
                            echo '<a href="placebid.php?productId=' . $row['id'] . '" class="item-button">Place Your Bid</a>';
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
