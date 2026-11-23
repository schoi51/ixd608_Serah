<?php
include "lib/php/functions.php";

$conn = makeConn();
$featured_products = makeQuery($conn, "SELECT * FROM products ORDER BY id ASC LIMIT 3");
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOLT — Curated Objects</title>
    <?php include "parts/meta.php"; ?>
    <style>
        .hero-window {
            height: 56vh;
            min-height: 380px;
            position: relative;
            display: flex;
            align-items: center;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            border-bottom: 1px solid var(--color-line);
            color: var(--color-white);
        }
        .hero-window::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(17, 17, 17, 0.45);
        }
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 640px;
        }
        .hero-content h1 {
            font-size: clamp(2rem, 4.5vw, 3.5rem);
            line-height: 1.08;
            margin: 0 0 1rem 0;
        }
        .hero-content p {
            margin: 0 0 1.5rem 0;
            line-height: 1.6;
            font-size: 15px;
        }
        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .hero-btn-light {
            width: auto;
            background-color: var(--color-white);
            color: var(--color-primary);
            border-color: var(--color-white);
        }
        .hero-btn-outline {
            width: auto;
            background-color: transparent;
            color: var(--color-white);
            border-color: var(--color-white);
        }

        .home-section {
            padding: 3.5rem 0;
        }
        .section-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: baseline;
            gap: 1rem;
            margin-bottom: 1.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--color-line);
        }
        .section-header h2,
        .section-header h3 {
            margin: 0;
        }
        .section-link {
            font-family: var(--font-mono);
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .editorial-strip {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 1.5rem;
            align-items: stretch;
        }
        .editorial-box {
            border: 1px solid var(--color-line);
            padding: 1.75rem;
            background-color: var(--color-white);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

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
        }
        .figure.product {
            border: 1px solid var(--color-line);
            border-radius: 0;
            box-shadow: none;
            background-color: var(--color-white);
            overflow: hidden;
            margin: 0;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .product-placeholder {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-bottom: 1px solid var(--color-line);
            background-size: cover;
            background-position: center;
        }

        @media (max-width: 900px) {
            .custom-product-col {
                flex: 0 0 calc(50% - 0.75rem);
            }
            .editorial-strip {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 768px) {
            .hero-window {
                background-attachment: scroll;
                min-height: 340px;
            }
            .custom-product-col {
                flex: 0 0 100%;
            }
            .home-section {
                padding: 2.25rem 0;
            }
        }
    </style>
</head>
<body>

    <?php include "parts/navbar.php"; ?>

    <section class="hero-window" style="background-image: url('img/hero.jpg');">
        <div class="container">
            <div class="hero-content">
                <h1>Objects With Structure &amp; Presence</h1>
                <p>Thoughtfully selected pieces for everyday spaces—balancing clean form, tactile materials, and practical function.</p>
                <div class="hero-actions">
                    <a href="product_list.php" class="form-button hero-btn-light">Explore All Products</a>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section">
        <div class="container">
            <div class="editorial-strip">
                <div class="editorial-box">
                    <div>
                        <div style="font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.12em; text-transform: uppercase; color: var(--color-secondary); margin-bottom: 0.5rem;">01 / Perspective</div>
                        <h3 style="margin: 0 0 0.75rem 0;">Designed for Calm, Built to Last</h3>
                        <p style="margin: 0; line-height: 1.65; color: var(--color-muted);">Every item in the catalog is chosen for clear proportions, honest textures, and effortless integration into daily life.</p>
                    </div>
                </div>
                <div class="editorial-box" style="background-color: var(--color-main-light);">
                    <div>
                        <div style="font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 0.5rem;">02 / Browse</div>
                        <h3 style="margin: 0 0 0.75rem 0;">Search, Filter &amp; Sort</h3>
                        <p style="margin: 0 0 1.25rem 0; line-height: 1.65;">Jump straight into the full catalog to filter by category, search keywords, or sort by price and name.</p>
                    </div>
                    <div>
                        <a href="product_list.php" class="form-button primary" style="width: auto;">Go to Catalog</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section" style="padding-top: 0;">
        <div class="container">
            <div class="section-header">
                <h3>Featured Selection</h3>
                <a href="product_list.php" class="section-link">View All &rarr;</a>
            </div>

            <div class="custom-product-grid">
                <?php
                if (is_array($featured_products)) {
                    foreach ($featured_products as $o) {
                        $thumbnail = htmlspecialchars(trim($o->thumbnail ?? ''));
                        $name = htmlspecialchars($o->name ?? '');
                        $price = number_format((float)($o->price ?? 0), 2);
                        $id = urlencode($o->id ?? '');

                        echo "
                        <div class='custom-product-col'>
                            <a href='product_item.php?id={$id}' style='text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;'>
                                <figure class='figure product'>
                                    <div class='product-placeholder' style='background-image: url(\"img/{$thumbnail}\");'></div>
                                    <figcaption style='padding: 1.2rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;'>
                                        <div style='font-weight: bold; font-size: 20px;'>{$name}</div>
                                        <div style='font-family: var(--font-mono); color: var(--color-primary); margin-top: 0.3rem;'>\${$price}</div>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        ";
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <?php include "parts/footer.php"; ?>

</body>
</html>