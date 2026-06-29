<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Products</title>

    <link rel="stylesheet" href="./assets/css/style.css" />
</head>

<body>
    <nav>
        <div class="logo">GABSTORE</div>

        <!-- search bar -->

        <div class="search-container">
            <input class="search-bar" type="search" placeholder="enter a search key word">
        </div>

        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="products.html">Products</a></li>
            <li><a href="login.html">Login</a></li>
        </ul>
    </nav>

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
</body>

</html>