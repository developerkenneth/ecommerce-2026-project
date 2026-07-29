<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Products</title>

    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/dashboard.css">
</head>

<body>
    <!-- HEADER -->
    <header>

        <div class="logo">
            <h2><a href="dashboard.php">GABSITE</a></h2>
        </div>

        <div class="search-box">


            <input id="searchInput" type="text" placeholder="Search products...">
            <button> <i class="fa-solid fa-magnifying-glass"></i></button>
        </div>

        <div class="nav-icons">
            <!-- account help section -->

            <div class="dropdown">

                <div class="icon" id="account-help">
                    <i class="fa-regular fa-user"></i>
                    <span>Gabriel</span>
                    <span><img src="./chevron-down.svg" class="chevron"></span>
                </div>

                <div class="account-options">
                    <ul>
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="#">Help</a></li>
                        <li class="active"><a href="#">Logout</a></li>
                    </ul>
                </div>

            </div>

            <!-- help section -->
            <div class="dropdown">

                <div class="icon" id="help-icon">
                    <i class="fa-solid fa-question-circle"></i>
                    <span>Help</span>
                    <span><img src="./chevron-down.svg" class="chevron"></span>
                </div>

                <div class="help-options">
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Contact Support</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Report a Problem</a></li>
                    </ul>
                </div>

            </div>

            <!-- cart section -->
            <div class="dropdown">

                <div class="icon" id="cart-icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Cart</span>
                    <span><img src="./chevron-down.svg" class="chevron"></span>
                </div>

                <div class="cart-options">
                    <ul>
                        <li><a href="#">View Cart</a></li>
                        <li><a href="#">Checkout</a></li>
                        <li><a href="#">Order History</a></li>
                        <li><a href="#">Track Order</a></li>
                    </ul>
                </div>
            </div>

        </div>

    </header>

    <section class="products-section">

        <h1>Our Products</h1>
        <!-- filter by price -->
        <div class="filter-container">
            <div>
                <p>maximum price of product:</p>
                <input class="max-price filter" type="range" min="0" max="100000">
                <span id="output-max"></span>
            </div>


            <div>
                <p>minimum price of product:</p>
                <input class="min-price filter" type="range" min="0" max="100000">
            </div>
        </div>
        <div class="loader-container">
            <div class="loader">

            </div>
        </div>
        <div class="products-container hidden"></div>
    </section>

    <script src="./assets/js/products.js"></script>
    <script src="./assets/js/dashborad.js" ></script>
</body>

</html>