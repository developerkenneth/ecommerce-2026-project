<?php

$pageTitle = "Shopping Cart";

require_once "components/user/head.php";

?>

<?php require_once "components/user/header.php"; ?>

<link rel="stylesheet" href="./assets/css/cart.css">

<main class="cart-page">

    <section class="cart-breadcrumb">

        <a href="./index.php">
            Home
        </a>

        <span>/</span>

        <strong>
            Shopping Cart
        </strong>

    </section>


    <section class="cart-header">

        <div>

            <span class="cart-eyebrow">
                YOUR SHOPPING BAG
            </span>

            <h1>
                Shopping Cart
            </h1>

            <p id="cartItemCount">
                Loading cart...
            </p>

        </div>

        <button
            type="button"
            class="clear-cart-btn"
            id="clearCartBtn">
            <i class="fa-solid fa-trash"></i>
            Clear Cart
        </button>

    </section>


    <!-- LOADING -->

    <section
        class="cart-loading"
        id="cartLoading">

        <div class="cart-spinner"></div>

        <p>
            Loading your cart...
        </p>

    </section>


    <!-- ERROR -->

    <section
        class="cart-error"
        id="cartError"
        hidden>

        <i class="fa-solid fa-circle-exclamation"></i>

        <h2>
            Unable to load your cart
        </h2>

        <p id="cartErrorMessage">
            Something went wrong.
        </p>

        <button
            type="button"
            id="retryCartBtn">
            Try Again
        </button>

    </section>


    <!-- EMPTY -->

    <section
        class="empty-cart"
        id="emptyCart"
        hidden>

        <div class="empty-cart-icon">

            <i class="fa-solid fa-cart-shopping"></i>

        </div>

        <h2>
            Your cart is empty
        </h2>

        <p>
            You haven't added anything to your cart yet.
        </p>

        <a href="./index.php">
            Continue Shopping
        </a>

    </section>


    <!-- CART -->

    <section
        class="cart-layout"
        id="cartLayout"
        hidden>

        <!-- ITEMS -->

        <div class="cart-items-card">

            <div class="cart-items-header">

                <h2>
                    Your Items
                </h2>

                <span id="cartProductsCount">
                    0 products
                </span>

            </div>


            <div id="cartItems">

                <!-- JS inserts products here -->

            </div>

        </div>


        <!-- SUMMARY -->

        <aside class="cart-summary">

            <div class="summary-header">

                <h2>
                    Order Summary
                </h2>

            </div>


            <div class="summary-row">

                <span>
                    Items
                </span>

                <strong id="summaryItems">
                    0
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Subtotal
                </span>

                <strong id="summarySubtotal">
                    ₦0.00
                </strong>

            </div>


            <div class="summary-row">

                <span>
                    Delivery
                </span>

                <strong>
                    Calculated at checkout
                </strong>

            </div>


            <div class="summary-divider"></div>


            <div class="summary-total">

                <span>
                    Total
                </span>

                <strong id="summaryTotal">
                    ₦0.00
                </strong>

            </div>


            <button
                type="button"
                class="checkout-btn"
                id="payNowBtn">

                Pay Now

                <i class="fa-solid fa-arrow-right"></i>

            </button>


            <a
                href="./index.php"
                class="continue-shopping">

                <i class="fa-solid fa-arrow-left"></i>

                Continue Shopping

            </a>

        </aside>

    </section>

</main>


<script src="https://js.paystack.co/v2/inline.js"></script>
<script src="./assets/js/cart.js"></script>
<script src="./assets/js/paystack.js"></script>
<?php require_once "./components/user/footer.php"; ?>