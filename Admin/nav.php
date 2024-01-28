<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
.navbar{
    background-color: #0e0e0e;
    border-radius: 5px;
}
.navbar ul{
    overflow:auto ;
}
.navbar li.active{
   
    border-bottom: 5px solid #ff9900;
}
.navbar li{
    float: left;
    list-style: none;
    padding: 30px 30px;
}
.navbar .right{
    float: right;
    list-style: none;
    padding: 30px 30px;

}
.navbar li a{
    padding: 30px 30px;
    text-decoration: none;
    color: white;
    font-size: 20px;
}
.navbar li:hover{
    background-color: #191919;
}
.navbar li a:hover{
    background-color: #191919;
}
    </style>
</head>
<body>
<?php
$currentFileName = basename($_SERVER['PHP_SELF']);
$currentPage = '';

switch ($currentFileName) {
    case 'index.php':
        $currentPage = 'index';
        break;
    case 'products.php':
        $currentPage = 'products';
        break;
    case 'addproduct.php':
        $currentPage = 'addproduct';
        break;
    case 'manageuser.php':
        $currentPage = 'manageuser';
        break;
    default:
        // Set a default value for other pages
        $currentPage = 'other';
}
?>
    <nav class="navbar">
        <ul>
            <li <?php echo ($currentPage == 'index') ? 'class="active"' : ''; ?> ><a href="index.php">home</a></li>
            <li <?php echo ($currentPage == 'products') ? 'class="active"' : ''; ?> ><a href="products.php">products</a> </li>
            <li <?php echo ($currentPage == 'addproduct') ? 'class="active"' : ''; ?> ><a href="addproduct.php">add products</a> </li>
            <li <?php echo ($currentPage == 'manageuser') ? 'class="active"' : ''; ?> ><a href="manageuser.php">manage users</a> </li> 
            <li class="right"><a href="logout.php">logout</a></li>
        </ul>
        
    </nav>
</body>
</html>