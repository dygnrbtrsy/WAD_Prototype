<?php
include 'db_connect.php';
include 'header.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$uid = $_SESSION['user_id'];
$orders = mysqli_query($conn, "SELECT * FROM transactions WHERE user_id = '$uid' ORDER BY transaction_date DESC");
?>
<div class="section-header"><h2>Welcome, <?php echo $_SESSION['full_name']; ?></h2></div>
<div style="padding: 20px;">
    <h3>Order History</h3>
    <?php while($row = mysqli_fetch_assoc($orders)): ?>
        <div style="border-bottom: 1px solid #eee; padding: 10px 0;">
            <p><strong>Order #<?php echo $row['transaction_id']; ?></strong></p>
            <p>Total: RM<?php echo $row['total_amount']; ?> | Status: <?php echo $row['status']; ?></p>
        </div>
    <?php endwhile; ?>
</div>
</body></html>
