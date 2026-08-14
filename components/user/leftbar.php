<?php

$currentPage = basename($_SERVER['PHP_SELF']);

?>
<link rel="stylesheet" href="./assets/css/sidebar.css">

<aside
    class="seller-sidebar"
    id="sellerSidebar">


    <div class="sidebar-brand">

        <div class="sidebar-brand-icon">
            <i class="fa-solid fa-store"></i>
        </div>

        <div>

            <strong>
                Seller Center
            </strong>

            <span>
                GABSITE Marketplace
            </span>

        </div>

    </div>


    <div class="sidebar-section">

        <span class="sidebar-label">
            WORKSPACE
        </span>


        <nav class="sidebar-nav">


            <a
                href="./dashboard.php"
                class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>">

                <i class="fa-solid fa-grid-2"></i>

                <span>
                    Overview
                </span>

            </a>


            <a
                href="./products.php"
                class="<?= $currentPage === 'product.php' ? 'active' : '' ?>">

                <i class="fa-solid fa-box"></i>

                <span>
                    Products
                </span>

            </a>


            <a
                href="./add.php"
                class="<?= $currentPage === 'add.php' ? 'active' : '' ?>">

                <i class="fa-solid fa-circle-plus"></i>

                <span>
                    Add Product
                </span>

            </a>


            <a
                href="./orders.php"
                class="<?= $currentPage === 'orders.php' ? 'active' : '' ?>">

                <i class="fa-solid fa-bag-shopping"></i>

                <span>
                    Orders
                </span>

            </a>


            <a
                href="./customers.php"
                class="<?= $currentPage === 'customers.php' ? 'active' : '' ?>">

                <i class="fa-solid fa-users"></i>

                <span>
                    Customers
                </span>

            </a>


            <a
                href="./reviews.php"
                class="<?= $currentPage === 'reviews.php' ? 'active' : '' ?>">

                <i class="fa-solid fa-star"></i>

                <span>
                    Reviews
                </span>

            </a>

        </nav>

    </div>


    <div class="sidebar-section">

        <span class="sidebar-label">
            ACCOUNT
        </span>


        <nav class="sidebar-nav">


            <a
                href="./settings.php"
                class="<?= $currentPage === 'settings.php' ? 'active' : '' ?>">

                <i class="fa-solid fa-gear"></i>

                <span>
                    Settings
                </span>

            </a>


            <a href="./help.php">

                <i class="fa-regular fa-circle-question"></i>

                <span>
                    Help Center
                </span>

            </a>

        </nav>

    </div>


    <div class="sidebar-footer">

        <div class="seller-status">

            <span class="status-indicator"></span>

            <div>

                <strong>
                    Store Active
                </strong>

                <small>
                    Marketplace is live
                </small>

            </div>

        </div>


        <a
            href="./logout.php"
            class="sidebar-logout">

            <i class="fa-solid fa-right-from-bracket"></i>

            <span>
                Logout
            </span>

        </a>

    </div>

</aside>