<?php
include "lib/php/functions.php";

session_start();

// URL 파라미터로 넘어온 product ID와 amount 확인
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$amount = isset($_GET['amount']) ? intval($_GET['amount']) : 1;

$conn = makeConn();
$result = makeQuery($conn, "SELECT * FROM products WHERE id = $id");
$product = isset($result[0]) ? $result[0] : null;
$conn->close();

if (!$product) {
    header("Location: product_list.php");
    exit;
}

// 현재 세션의 장바구니에서 해당 상품의 총 수량 구하기 (있다면)
$total_in_cart = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (is_array($item) && $item['id'] == $id) {
            $total_in_cart = $item['amount'];
            break;
        } elseif (is_object($item) && $item->id == $id) {
            $total_in_cart = $item->amount;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Added to Cart - <?php echo htmlspecialchars($product->name); ?></title>
    <?php include "parts/meta.php"; ?>
    <style>
        .added-container {
            max-width: 700px;
            margin: 5rem auto;
        }
        .added-card {
            border: 1px solid #dcd6cd;
            background: #fff;
            padding: 4rem 3rem;
            min-height: 320px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .added-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            margin-top: 2.5rem;
            width: 100%;
            max-width: 320px;
        }
        .btn-outline {
            border: 1px solid #111;
            background: #fff;
            color: #111;
            padding: 0.9rem 1.5rem;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            display: block;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }
        .btn-outline:hover {
            background: #f5f5f5;
        }
        .btn-primary-custom {
            display: block;
            width: 100%;
            text-align: center;
            padding: 0.9rem 1.5rem;
            text-decoration: none;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <?php include "parts/navbar.php"; ?>

    <div class="container added-container">
        <div class="added-card">
            <h2 style="font-family: var(--font-serif); font-size: 32px; margin-bottom: 1.2rem;">Added to Cart</h2>
            <p style="color: var(--color-muted); font-size: 16px; margin-bottom: 0.6rem;">
                You added <strong><?php echo htmlspecialchars($product->name); ?></strong> to your cart.
            </p>
            <p style="color: var(--color-muted); font-size: 14px; margin-bottom: 0;">
                There are now <?php echo $total_in_cart; ?> of <?php echo htmlspecialchars($product->name); ?> in your cart.
            </p>
            
            <div class="added-actions">
                <a href="product_list.php" class="btn-outline">Continue Shopping</a>
                <a href="cart.php" class="form-button primary btn-primary-custom">Go To Cart</a>
            </div>
        </div>
    </div>

    <?php include "parts/footer.php"; ?>

</body>
</html>