<?php

use App\Core\Auth;

$user = Auth::user();

$currentPage = basename($_SERVER['PHP_SELF']);

?>
<link rel="stylesheet" href="./assets/css/header.css">

<header class="site-header">

    <div class="header-left">

        <button
            type="button"
            class="mobile-menu-btn"
            id="mobileMenuBtn"
            aria-label="Open navigation">

            <i class="fa-solid fa-bars"></i>

        </button>


        <a
            href="./dashboard.php"
            class="site-logo">

            <span class="logo-mark">
                G
            </span>

            <span class="logo-text">
                GABSITE
            </span>

        </a>

    </div>


    <div class="header-search">

        <i class="fa-solid fa-magnifying-glass"></i>

        <input
            type="search"
            id="globalSearch"
            placeholder="Search products, orders, customers..."
            autocomplete="off">

        <kbd>
            Ctrl K
        </kbd>

    </div>


    <div class="header-actions">


        <button
            type="button"
            class="header-action"
            id="notificationBtn"
            aria-label="Notifications">

            <i class="fa-regular fa-bell"></i>

            <span class="notification-dot"></span>

        </button>


        <a
            href="./cart.php"
            class="header-action"
            aria-label="Cart">

            <i class="fa-solid fa-cart-shopping"></i>

            <span
                class="cart-count"
                id="headerCartCount">
                0
            </span>

        </a>


        <div class="profile-wrapper">

            <button
                type="button"
                class="profile-trigger"
                id="profileTrigger">

                <span class="profile-avatar">

                    <?php if (!empty($user->profile_picture)): ?>

                        <img
                            src="./assets/photos/<?= htmlspecialchars($user->profile_picture) ?>"
                            alt="Profile">

                    <?php else: ?>

                        <?= strtoupper(substr($user->name ?? "U", 0, 1)) ?>

                    <?php endif; ?>

                </span>


                <span class="profile-info">

                    <strong>
                        <?= htmlspecialchars($user->name ?? "User") ?>
                    </strong>

                    <small>
                        Seller
                    </small>

                </span>


                <i class="fa-solid fa-chevron-down profile-chevron"></i>

            </button>


            <div
                class="profile-menu"
                id="profileMenu">

                <div class="profile-menu-header">

                    <strong>
                        <?= htmlspecialchars($user->name ?? "User") ?>
                    </strong>

                    <span>
                        <?= htmlspecialchars($user->email ?? "") ?>
                    </span>

                </div>


                <a href="./settings.php">
                    <i class="fa-regular fa-user"></i>
                    Profile & Settings
                </a>


                <a href="./orders.php">
                    <i class="fa-solid fa-box"></i>
                    My Orders
                </a>


                <a href="./cart.php">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Cart
                </a>


                <div class="profile-menu-divider"></div>


                <a
                    href="./logout.php"
                    class="logout-link">

                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout

                </a>

            </div>

        </div>

    </div>

</header>


<div
    class="mobile-overlay"
    id="mobileOverlay">
</div>