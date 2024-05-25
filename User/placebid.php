<?php
session_start();

// Redirect users to login page if not logged in
if (!isset($_SESSION["user"])) {
    header('Location: login.php');
    exit;
}

// Retrieve user ID from session
$userId = $_SESSION['user'];

// Retrieve product ID from URL parameter
$productId = $_GET['productId'];

require_once "dbconnect.php";

// Retrieve product details from the database
$select = mysqli_query($conn, "SELECT * FROM products WHERE id = $productId");
$row = mysqli_fetch_assoc($select);

if (isset($_POST["bid"])) {
    // Retrieve bid amount from form
    $bidAmount = $_POST["bidAmount"];
    $bidStatus = $row['bid_action']; // Assuming 'bid_action' is the column name for bid status

    // Validate bid amount
    if ($bidAmount < $row['productPrice']) {
        echo "<div class='alert alert-danger'>Bid amount cannot be less than current price.</div>";
    } elseif ($bidStatus == "StartBid") {
        echo "<div class='alert alert-danger'>Bidding is not started yet</div>";
    } else {
        // Insert bid into database
        $sql = "INSERT INTO bids (userid, productid, bidamount) VALUES (?, ?, ?)";
        $stmt1 = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt1, $sql)) {
            mysqli_stmt_bind_param($stmt1, "iii", $userId, $productId, $bidAmount);
            mysqli_stmt_execute($stmt1);
            echo "<div class='alert alert-success'>Bid placed successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to place bid.</div>";
        }

        // Update product price in the products table
        $sqlupdate = "UPDATE products SET productPrice = ? WHERE id = ?";
        $stmt2 = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt2, $sqlupdate)) {
            mysqli_stmt_bind_param($stmt2, "ii", $bidAmount, $productId);
            mysqli_stmt_execute($stmt2);
            echo "<div class='alert alert-success'>Product price updated successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to update product price.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/item-container.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Place Bid</title>
</head>
<body>
    <h1>Place your bid here (Product ID: <?php echo $productId ?>, User ID: <?php echo $userId ?>)</h1>
    <form action="placebid.php?productId=<?php echo $productId ?>" method="post">
        <div class="item-container_1">
            <img src="../Uploads/<?php echo $row['productImage']; ?>" alt="Item Image" class="item-image_1">
            <div class="item-details_1">
                <div class="item-name_1"><?php echo $row['productName']; ?></div>
                <div class="item-price-condition_1">
                    <div class="item-price-container_1">Price <span class="price1">$<?php echo $row['productPrice']; ?>/-</span></div>
                    <div class="item-condition_1">Condition <span class="condition_1">New</span></div>
                </div>
                <textarea class="item-description_1" readonly placeholder="Product description"><?php echo $row['productDescription']; ?></textarea>
                <div class="bidding-section_1">
                    <label for="bid-amount_1">Enter your bid:</label>
                    <input type="number" id="bid-amount_1" name="bidAmount" min="<?php echo $row['productPrice']; ?>" required>
                    <button type="submit" name="bid" value="bid">Place Bid</button>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
