<?php
include "lib/php/functions.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$conn = makeConn();

$result = makeQuery($conn, "SELECT * FROM products WHERE id = $id");
$product = isset($result[0]) ? $result[0] : null;

if (!$product) {
    $conn->close();
    die("Product not found.");
}

$prev_result = makeQuery($conn, "SELECT MAX(id) as id FROM products WHERE id < $id");
$prev_id = (isset($prev_result[0]) && $prev_result[0]->id) ? $prev_result[0]->id : null;

$next_result = makeQuery($conn, "SELECT MIN(id) as id FROM products WHERE id > $id");
$next_id = (isset($next_result[0]) && $next_result[0]->id) ? $next_result[0]->id : null;

$conn->close();

$thumbnail = trim($product->thumbnail);
$images_raw = trim($product->images);

$images_array = !empty($images_raw) ? array_map('trim', explode(',', $images_raw)) : [];

$all_images = array_merge([$thumbnail], $images_array);
$all_images = array_values(array_unique(array_filter($all_images, function($img) {
    return !empty($img) && file_exists("img/" . $img);
}))); 

$main_image = isset($all_images[0]) ? $all_images[0] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Item - <?php echo htmlspecialchars($product->name); ?></title>
    <?php include "parts/meta.php"; ?>
    <style>
        .product-nav-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3.5rem;
            margin-top: 1.5rem;
        }
        .product-nav-bottom {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 3.5rem;
            margin-bottom: 3rem;
        }
        .nav-link {
            text-decoration: none;
            color: #111;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #dcd6cd;
            padding: 0.6rem 1.2rem;
            background: #fff;
            transition: all 0.2s ease;
        }
        .nav-link:hover {
            background: var(--color-secondary, #ff6b00);
            color: #fff;
            border-color: var(--color-secondary, #ff6b00);
        }
        .nav-link.disabled {
            opacity: 0.3;
            pointer-events: none;
        }
        .product-layout {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        .product-images {
            flex: 1;
            min-width: 300px;
        }
        .main-image-box {
            width: 100%;
            aspect-ratio: 1 / 1;
            border: 1px solid #dcd6cd;
            background: #fff;
            margin-bottom: 1rem;
            overflow: hidden;
        }
        .main-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .thumb-images-grid {
            display: flex;
            gap: 1rem;
            flex-wrap: nowrap;
            overflow-x: auto;
        }
        .thumb-box {
            flex: 0 0 calc(33.333% - 0.66rem);
            aspect-ratio: 1 / 1;
            border: 1px solid #dcd6cd;
            background: #fff;
            overflow: hidden;
            cursor: pointer;
        }
        .thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .product-info {
            flex: 1;
            min-width: 300px;
        }
    </style>
</head>
<body>

    <?php include "parts/navbar.php"; ?>

    <div class="container">
        
        <div class="product-nav-top">
            <div>
                <?php if ($prev_id): ?>
                    <a href="product_item.php?id=<?php echo $prev_id; ?>" class="nav-link">&larr; Prev Product</a>
                <?php else: ?>
                    <span class="nav-link disabled">&larr; Prev Product</span>
                <?php endif; ?>
            </div>

            <div>
                <?php if ($next_id): ?>
                    <a href="product_item.php?id=<?php echo $next_id; ?>" class="nav-link">Next Product &rarr;</a>
                <?php else: ?>
                    <span class="nav-link disabled">Next Product &rarr;</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="card soft">
            <div class="product-layout">
                
                <div class="product-images">
                    <div class="main-image-box">
                        <?php if (!empty($main_image)): ?>
                            <img src="img/<?php echo htmlspecialchars($main_image); ?>" alt="<?php echo htmlspecialchars($product->name); ?>" id="active-main-img">
                        <?php endif; ?>
                    </div>
                    
                    <div class="thumb-images-grid">
                        <?php
                        foreach ($all_images as $img_name) {
                            echo "
                            <div class='thumb-box' onclick=\"document.getElementById('active-main-img').src='img/{$img_name}'\">
                                <img src='img/{$img_name}' alt='Thumbnail'>
                            </div>
                            ";
                        }
                        ?>
                    </div>
                </div>

                <div class="product-info">
                    <h2 style="font-family: var(--font-serif); font-size: 32px; margin-bottom: 1rem;"><?php echo htmlspecialchars($product->name); ?></h2>
                    <div class="price" style="font-family: var(--font-mono); font-size: 24px; color: var(--color-secondary); margin-bottom: 1.5rem;">
                        $<?php echo number_format($product->price, 2); ?>
                    </div>
                    <p style="color: var(--color-muted); line-height: 1.6; margin-bottom: 2rem;">
                        <?php echo htmlspecialchars($product->description); ?>
                    </p>
                    
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product->id); ?>">
                        <button type="submit" class="form-button primary" style="width: 100%; padding: 1rem; cursor: pointer;">Add To Cart</button>
                    </form>
                </div>

            </div>
        </div>

        <div class="product-nav-bottom">
            <a href="product_list.php" class="nav-link">Back to List</a>
        </div>

    </div>

    <?php include "parts/footer.php"; ?>

</body>
</html>