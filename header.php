<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ButtonOn</title>
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="mosaic.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>

    <div class="promo-bar">
        Free Shipping on Orders Over RM150 | Download the App for 10% Off
    </div>

    <nav>
        <div class="logo">ButtonOn</div>
        
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="products.php">Shop</a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php">My Account</a>
                <a href="logout.php" style="color: var(--accent-red);">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php" class="sale-link">Sign Up</a>
            <?php endif; ?>
        </div>

        <div class="nav-icons">
            <a href="products.php">Search</a>
            <a href="cart.php">Cart (<?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : '0'; ?>)</a>
        </div>
    </nav>