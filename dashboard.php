<?php

$pageTitle = "Dashboard";

require_once "components/user/head.php";
require_once "components/user/header.php";

?>

<link rel="stylesheet" href="./assets/css/dashboard.css">

<section class="dashboard-container">

    <?php require_once "components/user/leftbar.php"; ?>


    <main class="dashboard-content">

        <div class="dashboard-header">

            <div>

                <span class="dashboard-eyebrow">
                    SELLER CENTER
                </span>

                <h1>
                    Dashboard
                </h1>

                <p>
                    Manage your products, inventory and marketplace activity.
                </p>

            </div>


            <button
                type="button"
                class="add-product-btn"
                id="addProductBtn">

                <i class="fa-solid fa-plus"></i>

                Add Product

            </button>

        </div>


        <!-- DASHBOARD STATS -->

        <section class="dashboard-cards">


            <article class="card">

                <div class="card-icon">
                    <i class="fa-solid fa-box"></i>
                </div>

                <div>

                    <span class="card-label">
                        Total Products
                    </span>

                    <h2 id="totalProducts">
                        0
                    </h2>

                    <small>
                        Products in marketplace
                    </small>

                </div>

            </article>


            <article class="card">

                <div class="card-icon inventory-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>

                <div>

                    <span class="card-label">
                        Inventory Units
                    </span>

                    <h2 id="totalInventory">
                        0
                    </h2>

                    <small>
                        Total available stock
                    </small>

                </div>

            </article>


            <article class="card">

                <div class="card-icon success-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <div>

                    <span class="card-label">
                        In Stock
                    </span>

                    <h2 id="inStockProducts">
                        0
                    </h2>

                    <small>
                        Products currently available
                    </small>

                </div>

            </article>


            <article class="card">

                <div class="card-icon danger-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div>

                    <span class="card-label">
                        Out of Stock
                    </span>

                    <h2 id="outOfStockProducts">
                        0
                    </h2>

                    <small>
                        Products needing attention
                    </small>

                </div>

            </article>


        </section>


        <!-- RECENT PRODUCTS -->

        <section class="dashboard-section recent-products">

            <div class="section-header">

                <div>

                    <h2>
                        Recent Products
                    </h2>

                    <p>
                        Your latest products from the marketplace.
                    </p>

                </div>


                <a
                    href="./index.php#products"
                    class="view-all">

                    View Marketplace

                </a>

            </div>


            <div
                class="dashboard-loading"
                id="productsLoading">

                <i class="fa-solid fa-spinner fa-spin"></i>

                <span>
                    Loading products...
                </span>

            </div>


            <div
                class="dashboard-error"
                id="productsError">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>

                    <strong>
                        Unable to load products
                    </strong>

                    <p id="productsErrorMessage">
                        Something went wrong.
                    </p>

                </div>


                <button
                    type="button"
                    id="retryProducts">

                    Retry

                </button>

            </div>


            <div
                class="dashboard-empty"
                id="productsEmpty">

                <i class="fa-solid fa-box-open"></i>

                <h3>
                    No products yet
                </h3>

                <p>
                    Add your first product to start building your marketplace.
                </p>

                <a href="./add.php">
                    Add Product
                </a>

            </div>


            <div
                class="table-wrapper"
                id="productsTableWrapper">

                <table class="products-table">

                    <thead>

                        <tr>

                            <th>
                                Product
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Stock
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody id="recentProductsBody"></tbody>

                </table>

            </div>

        </section>


        <!-- INVENTORY OVERVIEW -->

        <section class="dashboard-grid">


            <div class="dashboard-section inventory-overview">

                <div class="section-header">

                    <div>

                        <h2>
                            Inventory Overview
                        </h2>

                        <p>
                            A quick look at your inventory health.
                        </p>

                    </div>

                </div>


                <div class="inventory-stats">


                    <div class="inventory-stat">

                        <span class="inventory-stat-icon">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </span>

                        <div>

                            <strong id="inventoryProducts">
                                0
                            </strong>

                            <span>
                                Total products
                            </span>

                        </div>

                    </div>


                    <div class="inventory-stat">

                        <span class="inventory-stat-icon green">
                            <i class="fa-solid fa-check"></i>
                        </span>

                        <div>

                            <strong id="inventoryInStock">
                                0
                            </strong>

                            <span>
                                In stock
                            </span>

                        </div>

                    </div>


                    <div class="inventory-stat">

                        <span class="inventory-stat-icon red">
                            <i class="fa-solid fa-xmark"></i>
                        </span>

                        <div>

                            <strong id="inventoryOutOfStock">
                                0
                            </strong>

                            <span>
                                Out of stock
                            </span>

                        </div>

                    </div>


                </div>

            </div>


            <div class="dashboard-section dashboard-actions-card">

                <div class="section-header">

                    <div>

                        <h2>
                            Quick Actions
                        </h2>

                        <p>
                            Common seller actions.
                        </p>

                    </div>

                </div>


                <div class="quick-actions">

                    <a href="./add.php">
                        <i class="fa-solid fa-plus"></i>
                        Add Product
                    </a>

                    <a href="./index.php#products">
                        <i class="fa-solid fa-store"></i>
                        View Marketplace
                    </a>

                    <a href="./settings.php">
                        <i class="fa-solid fa-gear"></i>
                        Settings
                    </a>

                    <a href="./product.php">
                        <i class="fa-solid fa-box"></i>
                        Products
                    </a>

                </div>

            </div>


        </section>


        <!-- FUTURE ORDERS AREA -->

        <section class="dashboard-section coming-soon-section">

            <div class="coming-soon-icon">
                <i class="fa-solid fa-chart-line"></i>
            </div>

            <div>

                <span class="dashboard-eyebrow">
                    NEXT PHASE
                </span>

                <h2>
                    Orders, Sales & Revenue
                </h2>

                <p>
                    This section will become live when we connect the
                    orders, payments and checkout system.
                </p>

            </div>

        </section>


    </main>

</section>



<?php include_once "./components/user/footer.php"; ?>