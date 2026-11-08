<?php
include "lib/php/functions.php";

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['id'])) {
    $product_id = $_POST['id'];
    $product_amount = isset($_POST['amount']) ? intval($_POST['amount']) : 1;

    $found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $product_id) {
            $cart_item['amount'] += $product_amount;
            $found = true;
            break;
        }
    }
    unset($cart_item);

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'amount' => $product_amount
        ];
    }

    header("Location: cart.php");
    exit;
}

if (isset($_GET['action'])) {
    $index = isset($_GET['index']) ? $_GET['index'] : null;
    
    if ($index !== null && isset($_SESSION['cart'][$index])) {
        if ($_GET['action'] == 'remove') {
            array_splice($_SESSION['cart'], $index, 1);
        } else if ($_GET['action'] == 'update') {
            $qty = intval($_GET['qty']);
            if ($qty > 0) {
                if (is_array($_SESSION['cart'][$index])) {
                    $_SESSION['cart'][$index]['amount'] = $qty;
                }
            } else {
                array_splice($_SESSION['cart'], $index, 1);
            }
        }
    }
    header("Location: cart.php");
    exit;
}

$conn = makeConn();
$cart_items = [];
$total_price = 0;

if (!empty($_SESSION['cart'])) {
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
                $total_price += ($product->price * $amount);
            }
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <?php include "parts/meta.php"; ?>
    <style>
        .cart-layout {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        .cart-list {
            flex: 2;
            min-width: 300px;
        }
        .cart-summary {
            flex: 1;
            min-width: 280px;
        }
        .cart-item-card {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            border: 1px solid #dcd6cd;
            background: #fff;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .cart-item-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 1px solid #dcd6cd;
            background: #f9f9f9;
        }
        .cart-item-info {
            flex-grow: 1;
        }
        .qty-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .qty-btn {
            padding: 0.2rem 0.6rem;
            border: 1px solid #111;
            background: #fff;
            cursor: pointer;
            text-decoration: none;
            color: #111;
            font-weight: bold;
        }
        .remove-btn {
            color: var(--color-secondary);
            font-size: 13px;
            text-decoration: underline;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>

    <?php include "parts/navbar.php"; ?>

    <div class="container">
        <h2 style="font-family: var(--font-serif); margin-bottom: 2rem;">Your Shopping Cart</h2>

        <?php if (empty($cart_items)): ?>
            <div class="card soft" style="text-align: center; padding: 3rem;">
                <p style="color: var(--color-muted); margin-bottom: 1.5rem;">Your cart is currently empty.</p>
                <a href="product_list.php" class="form-button primary" style="display: inline-block; padding: 0.8rem 1.5rem; text-decoration: none;">Explore Collection</a>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                
                <div class="cart-list">
                    <?php foreach ($cart_items as $index => $item): ?>
                        <div class="cart-item-card">
                            <img src="img/<?php echo htmlspecialchars($item->thumbnail); ?>" alt="<?php echo htmlspecialchars($item->name); ?>" class="cart-item-img">
                            
                            <div class="cart-item-info">
                                <h4 style="font-family: var(--font-serif); font-size: 18px; margin: 0 0 0.3rem 0;"><?php echo htmlspecialchars($item->name); ?></h4>
                                <div style="font-family: var(--font-mono); font-size: 14px; color: var(--color-primary);">$<?php echo number_format($item->price, 2); ?></div>
                                
                                <div class="qty-control">
                                    <span style="font-size: 14px; color: var(--color-muted);">Qty: <?php echo $item->amount; ?></span>
                                    <a href="cart.php?action=update&index=<?php echo $index; ?>&qty=<?php echo $item->amount - 1; ?>" class="qty-btn">-</a>
                                    <a href="cart.php?action=update&index=<?php echo $index; ?>&qty=<?php echo $item->amount + 1; ?>" class="qty-btn">+</a>
                                </div>
                                
                                <div>
                                    <a href="cart.php?action=remove&index=<?php echo $index; ?>" class="remove-btn">Remove</a>
                                </div>
                            </div>
                            
                            <div style="font-family: var(--font-mono); font-size: 16px; font-weight: bold;">
                                $<?php echo number_format($item->price * $item->amount, 2); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <div class="card soft">
                        <h3 style="font-family: var(--font-serif); font-size: 20px; margin-bottom: 1rem;">Order Summary</h3>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 14px;">
                            <span style="color: var(--color-muted);">Subtotal</span>
                            <span style="font-family: var(--font-mono);">$<?php echo number_format($total_price, 2); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; font-size: 16px; font-weight: bold; border-top: 1px solid #dcd6cd; padding-top: 1rem;">
                            <span>Total</span>
                            <span style="font-family: var(--font-mono); color: var(--color-secondary);">$<?php echo number_format($total_price, 2); ?></span>
                        </div>
                        <a href="checkout.php" class="form-button primary" style="display: block; text-align: center; padding: 1rem; text-decoration: none;">Proceed to Checkout</a>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    </div>

    <?php include "parts/footer.php"; ?>

</body>
</html>