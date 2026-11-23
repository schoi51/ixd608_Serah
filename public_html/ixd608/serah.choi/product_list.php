<?php
include "lib/php/functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <?php include "parts/meta.php"; ?>
    <style>
        .toolbar-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1rem;
            border: 1px solid var(--color-line);
            background-color: var(--color-white);
        }
        .filter-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0;
        }
        .filter-pill {
            display: inline-block;
            padding: 0.5em 1em;
            border: 1px solid var(--color-line);
            background-color: var(--color-white);
            color: var(--color-primary);
            font-family: var(--font-mono);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s, border-color 0.2s;
        }
        .filter-pill:hover {
            border-color: var(--color-secondary);
            color: var(--color-secondary);
        }
        .filter-pill.active {
            background-color: var(--color-primary);
            color: var(--color-white);
            border-color: var(--color-primary);
        }
        .search-sort-controls {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem;
        }
        .search-form {
            display: flex;
            align-items: center;
            width: 280px;
        }
        .hotdog-compact {
            padding: 0.15em 0.4em;
        }
        .hotdog-compact input[type="search"] {
            padding: 0.35em 0.6em;
            font-size: 13px;
        }
        .hotdog-compact .form-button {
            padding: 0.45em 0.9em;
        }
        .sort-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sort-label {
            font-family: var(--font-mono);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--color-primary);
        }
        .form-select.sort-select {
            width: auto;
            min-width: 175px;
            padding: 0.45em 2.2em 0.45em 0.8em;
            font-family: var(--font-mono);
            font-size: 11px;
            letter-spacing: 0.06em;
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
            box-sizing: border-box;
        }
        @media (max-width: 900px) {
            .custom-product-col {
                flex: 0 0 calc(50% - 0.75rem);
            }
        }
        @media (max-width: 768px) {
            .custom-product-col {
                flex: 0 0 100%;
            }
            .toolbar-row {
                flex-direction: column;
                align-items: stretch;
            }
            .search-sort-controls {
                flex-direction: column;
                align-items: stretch;
            }
            .search-form {
                width: 100%;
            }
            .sort-group {
                justify-content: space-between;
            }
            .form-select.sort-select {
                flex: 1;
                max-width: 240px;
            }
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
    </style>
</head>
<body>

    <?php include "parts/navbar.php"; ?>

    <div class="container">
        <h2 style="margin-bottom: 1.5rem;">Product List</h2>

        <div class="toolbar-row">
            <div class="filter-pills" id="filter-pills">
                <button type="button" class="filter-pill active" data-category="all">All</button>
                <button type="button" class="filter-pill" data-category="chair">Chairs</button>
                <button type="button" class="filter-pill" data-category="table">Tables</button>
                <button type="button" class="filter-pill" data-category="lighting">Lighting</button>
                <button type="button" class="filter-pill" data-category="decor">Decor</button>
            </div>

            <div class="search-sort-controls">
                <form id="search-form" class="search-form">
                    <div class="hotdog hotdog-compact">
                        <input
                            type="search"
                            id="search-input"
                            placeholder="Search..."
                            aria-label="Search products"
                        >
                        <button type="submit" class="form-button">Go</button>
                    </div>
                </form>

                <button type="button" id="reset-btn" class="filter-pill">Reset</button>

                <div class="sort-group">
                    <label for="sort-select" class="sort-label">Sort</label>
                    <div class="form-select sort-select">
                        <select id="sort-select" aria-label="Sort products">
                            <option value="default">Default</option>
                            <option value="price_asc">Price: Low - High</option>
                            <option value="price_desc">Price: High - Low</option>
                            <option value="name_asc">Name: A - Z</option>
                            <option value="name_desc">Name: Z - A</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-product-grid" id="product-list-container"></div>
    </div>

    <?php include "parts/footer.php"; ?>

    <script>
        const productContainer = document.getElementById("product-list-container");
        const searchForm = document.getElementById("search-form");
        const searchInput = document.getElementById("search-input");
        const sortSelect = document.getElementById("sort-select");
        const filterButtons = document.querySelectorAll("#filter-pills .filter-pill");
        const resetBtn = document.getElementById("reset-btn");

        function escapeHtml(str) {
            return String(str ?? "").replace(/[&<>"']/g, function(m) {
                return {
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#039;"
                }[m];
            });
        }

        function productCardTemplate(item) {
            const thumb = escapeHtml(String(item.thumbnail || "").trim());
            const name = escapeHtml(item.name);
            const price = Number(item.price || 0).toFixed(2);
            const id = encodeURIComponent(item.id);

            return `
                <div class="custom-product-col">
                    <a href="product_item.php?id=${id}" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;">
                        <figure class="figure product">
                            <div class="product-placeholder" style="background-image: url('img/${thumb}');"></div>
                            <figcaption style="padding: 1.2rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                <div style="font-weight: bold; font-size: 20px;">${name}</div>
                                <div style="font-family: var(--font-mono); color: var(--color-primary); margin-top: 0.3rem;">$${price}</div>
                            </figcaption>
                        </figure>
                    </a>
                </div>
            `;
        }

        function renderProducts(items) {
            if (!Array.isArray(items) || items.length === 0) {
                productContainer.innerHTML = `
                    <div class="card soft" style="width: 100%; text-align: center; padding: 3rem;">
                        <p style="color: var(--color-muted); margin-bottom: 0;">No products found.</p>
                    </div>
                `;
                return;
            }
            productContainer.innerHTML = items.map(productCardTemplate).join("");
        }

        function loadProducts(url) {
            fetch(url)
                .then(function(res) { return res.json(); })
                .then(function(data) { renderProducts(data); })
                .catch(function(err) {
                    console.error("Error loading products:", err);
                    productContainer.innerHTML = "<p>Could not load products.</p>";
                });
        }

        function setActiveFilterButton(targetBtn) {
            filterButtons.forEach(function(btn) { btn.classList.remove("active"); });
            if (targetBtn) {
                targetBtn.classList.add("active");
            }
        }

        searchForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const q = encodeURIComponent(searchInput.value.trim());
            sortSelect.value = "default";
            setActiveFilterButton(null);
            loadProducts("data/api.php?type=search&q=" + q);
        });

        filterButtons.forEach(function(btn) {
            btn.addEventListener("click", function() {
                const cat = btn.getAttribute("data-category");
                searchInput.value = "";
                sortSelect.value = "default";
                setActiveFilterButton(btn);
                if (cat === "all") {
                    loadProducts("data/api.php?type=all");
                } else {
                    loadProducts("data/api.php?type=filter&column=category&value=" + encodeURIComponent(cat));
                }
            });
        });

        sortSelect.addEventListener("change", function() {
            const sortVal = encodeURIComponent(sortSelect.value);
            searchInput.value = "";
            setActiveFilterButton(null);
            loadProducts("data/api.php?type=sort&sort=" + sortVal);
        });

        resetBtn.addEventListener("click", function() {
            searchInput.value = "";
            sortSelect.value = "default";
            setActiveFilterButton(document.querySelector('#filter-pills .filter-pill[data-category="all"]'));
            loadProducts("data/api.php?type=all");
        });

        loadProducts("data/api.php?type=all");
    </script>

</body>
</html>