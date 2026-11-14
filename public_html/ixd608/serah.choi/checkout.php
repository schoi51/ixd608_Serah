<?php
include "lib/php/functions.php";

session_start();

$order_placed = false;
if (isset($_POST['place_order'])) {
    $_SESSION['cart'] = [];
    $order_placed = true;
}

$conn = makeConn();
$cart_items = [];
$subtotal_price = 0;

if (!$order_placed && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (is_array($item)) {
            $id = isset($item['id']) ? $item['id'] : null;
            $amount = isset($item['amount']) ? $item['amount'] : 1;
        } else if (is_object($item)) {
            $id = isset($item->id) ? $item->id : null;
            $amount = isset($item->amount) ? $item->amount : 1;
        } else {
            $id = $item;
            $amount = 1;
        }

        if ($id) {
            $result = makeQuery($conn, "SELECT * FROM products WHERE id = $id");
            if (!empty($result)) {
                $product = $result[0];
                $product->amount = $amount;
                $cart_items[] = $product;
                $subtotal_price += ($product->price * $amount);
            }
        }
    }
}
$conn->close();

$tax_rate = 0.085;
$tax_price = $subtotal_price * $tax_rate;
$total_price = $subtotal_price + $tax_price;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <?php include "parts/meta.php"; ?>
    <style>
        .checkout-layout {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        .checkout-form {
            flex: 2;
            min-width: 300px;
        }
        .checkout-summary {
            flex: 1;
            min-width: 280px;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-size: 13px;
            color: var(--color-muted, #666);
            font-weight: 500;
            margin-bottom: 0.4rem;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #dcd6cd;
            background: #fff;
            font-size: 14px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <?php include "parts/navbar.php"; ?>

    <div class="container">
        <h2 style="font-family: var(--font-serif); margin-bottom: 2rem;">Checkout</h2>

        <?php if ($order_placed): ?>
            <!-- 주문이 완료된 후 보여줄 화면 (Fake Checkout Success) -->
            <div class="card soft" style="text-align: center; padding: 4rem 2rem;">
                <h3 style="font-family: var(--font-serif); font-size: 28px; margin-bottom: 1rem;">Thank you for your order!</h3>
                <p style="color: var(--color-muted); font-size: 16px; margin-bottom: 2rem;">
                    Your order has been successfully placed. Your cart is now cleared.
                </p>
                <a href="product_list.php" class="form-button primary" style="display: inline-block; padding: 0.8rem 2rem; text-decoration: none;">Continue Shopping</a>
            </div>
        <?php else: ?>
            
            <?php if (empty($cart_items)): ?>
                <div class="card soft" style="text-align: center; padding: 3rem;">
                    <p style="color: var(--color-muted); margin-bottom: 1.5rem;">Your cart is empty. Nothing to checkout.</p>
                    <a href="product_list.php" class="form-button primary" style="display: inline-block; padding: 0.8rem 1.5rem; text-decoration: none;">Explore Collection</a>
                </div>
            <?php else: ?>
                
                <div class="checkout-layout">
                    <!-- 가상의 배송/결제 정보 입력 폼 -->
                    <div class="checkout-form">
                        <div class="card soft">
                            <h3 style="font-family: var(--font-serif); font-size: 20px; margin-bottom: 1.5rem;">Billing & Shipping Information</h3>
                            
                            <form action="checkout.php" method="POST">
                                <div class="form-group">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="Serah Choi" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="serah@example.com" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Shipping Address</label>
                                    <input type="text" name="address" class="form-control" value="Beacon Avenue, Fremont, CA" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Card Information (Prototype)</label>
                                    <input type="text" name="card" class="form-control" value="4242 •••• •••• 4242" required>
                                </div>

                                <button type="submit" name="place_order" class="form-button primary" style="width: 100%; padding: 1rem; cursor: pointer; margin-top: 1rem;">
                                    Place Order ($<?php echo number_format($total_price, 2); ?>)
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- 주문 요약 영역 -->
                    <div class="checkout-summary">
                        <div class="card soft">
                            <h3 style="font-family: var(--font-serif); font-size: 20px; margin-bottom: 1rem;">Order Review</h3>
                            
                            <div style="max-height: 250px; overflow-y: auto; margin-bottom: 1.5rem; padding-right: 0.5rem;">
                                <?php foreach ($cart_items as $item): ?>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem; font-size: 14px;">
                                        <div>
                                            <strong><?php echo htmlspecialchars($item->name); ?></strong><br>
                                            <span style="color: var(--color-muted); font-size: 12px;">Qty: <?php echo $item->amount; ?></span>
                                        </div>
                                        <span style="font-family: var(--font-mono);">$<?php echo number_format($item->price * $item->amount, 2); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div style="border-top: 1px solid #dcd6cd; padding-top: 1rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 14px;">
                                    <span style="color: var(--color-muted);">Subtotal</span>
                                    <span style="font-family: var(--font-mono);">$<?php echo number_format($subtotal_price, 2); ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 14px;">
                                    <span style="color: var(--color-muted);">Taxes (8.5%)</span>
                                    <span style="font-family: var(--color-mono);">$<?php echo number_format($tax_price, 2); ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: bold; border-top: 1px solid #dcd6cd; padding-top: 1rem;">
                                    <span>Total</span>
                                    <span style="font-family: var(--font-mono); color: var(--color-secondary);">$<?php echo number_format($total_price, 2); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php include "parts/footer.php"; ?>

</body>
</html>