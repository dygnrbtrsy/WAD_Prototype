<?php
include 'db_connect.php';
include 'header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ADD TO CART */
if (isset($_POST['add_to_cart'])) {
    $product_id = (int) $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    $_SESSION['cart_count'] = array_sum($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

/* REMOVE ITEM */
if (isset($_GET['remove'])) {
    $remove_id = (int) $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);

    $_SESSION['cart_count'] = array_sum($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}
?>

<link rel="stylesheet" href="cart.css">

<div class="cart-container">
    <h2>Your Cart</h2>

<?php if (empty($_SESSION['cart'])): ?>

    <div class="cart-empty">
        Your cart is empty.
    </div>

<?php else: ?>

    <table class="cart-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        <?php
        $total = 0;

        foreach ($_SESSION['cart'] as $product_id => $qty):
            $sql = "SELECT * FROM products WHERE product_id = $product_id";
            $result = mysqli_query($conn, $sql);
            $product = mysqli_fetch_assoc($result);

            if (!$product) continue;

            $subtotal = $product['price'] * $qty;
            $total += $subtotal;
        ?>
            <tr>
                <td>
                    <div class="cart-product">
                        <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>">
                        <span><?= $product['name'] ?></span>
                    </div>
                </td>
                <td>RM <?= number_format($product['price'], 2) ?></td>
                <td><?= $qty ?></td>
                <td>RM <?= number_format($subtotal, 2) ?></td>
                <td>
                    <a href="cart.php?remove=<?= $product_id ?>" class="cart-remove">
                        Remove
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

    <?php
    $_SESSION['cart_total'] = $total;
    ?>
    
    <div class="cart-summary">
        <div class="cart-total">
            Total: RM <?= number_format($total, 2) ?>
        </div>
    </div>

    <div class="cart-actions">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <p>Please login to proceed to checkout.</p>
        <?php else: ?>
            <a href="checkout.php">Proceed to Checkout</a>
        <?php endif; ?>
    </div>

<?php endif; ?>

</div>

</body>
</html>
