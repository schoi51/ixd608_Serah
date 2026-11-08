<?php
include "lib/php/functions.php";

$conn = makeConn();
$products = makeQuery($conn, "SELECT * FROM products");
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <?php include "parts/meta.php"; ?>
    <style>
        .custom-product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            width: 100%;
        }
        .custom-product-col {
            flex: 0 0 calc(33.333% - 1rem); 
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }
        @media (max-width: 768px) {
            .custom-product-col {
                flex: 0 0 100%;
            }
        }

        .figure.product {
            border: 1px solid #dcd6cd;
            border-radius: 0;
            background-color: #fff;
            overflow: hidden;
            margin: 0;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-placeholder {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-bottom: 1px solid #dcd6cd;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>

    <?php include "parts/navbar.php"; ?>

    <div class="container">
        <h2>Product List</h2>

        <div class="custom-product-grid">
            <?php
            foreach($products as $o) {
                $thumbnail = trim($o->thumbnail);

                echo "
                <div class='custom-product-col'>
                    <a href='product_item.php?id={$o->id}' style='text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;'>
                        <figure class='figure product'>
                            <div class='product-placeholder' style='background-image: url(img/{$thumbnail});'></div>
                            <figcaption style='padding: 1.2rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;'>
                                <div style='font-weight: bold; font-size: 20px;'>{$o->name}</div>
                                <div style='font-family: var(--font-mono); color: var(--color-primary); margin-top: 0.3rem;'>\${$o->price}</div>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                ";
            }
            ?>
        </div>
    </div>

    <?php include "parts/footer.php"; ?>

</body>
</html>