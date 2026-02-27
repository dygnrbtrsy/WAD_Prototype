<?php
include 'header.php';
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please register first.'); window.location='register.php';</script>";
    exit();
}

$total = 0;
if (isset($_SESSION['cart_total'])) {
    $total = $_SESSION['cart_total'];
}

if ($total <= 0) {
    echo "<script>alert('Cart empty.'); window.location='products.php';</script>";
    exit();
}

if (isset($_POST['pay_btn'])) {
    $uid = $_SESSION['user_id'];
    $sql = "INSERT INTO transactions (user_id, total_amount, status) VALUES ('$uid', '$total', 'completed')";
    
    if (mysqli_query($conn, $sql)) {
        $trans_id = mysqli_insert_id($conn);
        foreach ($_SESSION['cart'] as $pid => $qty) {
            $q = mysqli_query($conn, "SELECT price FROM products WHERE product_id = $pid");
            $row = mysqli_fetch_assoc($q);
            $price = $row['price'];
            $sql2 = "INSERT INTO transaction_items (transaction_id, product_id, quantity, price_at_purchase) 
                    VALUES ('$trans_id', '$pid', '$qty', '$price')";
            mysqli_query($conn, $sql2);
        }

        unset($_SESSION['cart']);
        unset($_SESSION['cart_count']);
        unset($_SESSION['cart_total']);
        echo "<div style='text-align:center; padding:50px;'>";
        echo "<h1 style='color:green;'>Payment Successful!</h1>";
        echo "<a href='dashboard.php'>View Orders</a>";
        echo "</div>";
        exit();

    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<div class="section-header">
    <h2>Checkout</h2>
</div>

<div style="padding: 20px 40px; max-width: 600px; margin: 0 auto;">
    <div style="background: #f9f9f9; padding: 20px; border: 1px solid #ddd; margin-bottom: 20px;">
        <p>Total Items: <?php echo $_SESSION['cart_count'] ?? 0; ?></p>
        <h3>Total: RM <?php echo number_format($total, 2); ?></h3>
    </div>

    <form method="POST">
        <button type="submit" name="pay_btn" style="background: black; color: white; padding: 15px; width: 100%; font-weight: bold;">PAY NOW</button>
    </form>
    
    <br>
    <a href="cart.php">Back to Cart</a>
</div>

</body>
</html>