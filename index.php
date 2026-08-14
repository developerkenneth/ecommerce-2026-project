<?php
$pageTitle = "homepage";
require_once("components/user/head.php");
require_once("components/user/header.php");

?>

<link rel="stylesheet" href="./assets/css/home.css">

<main class="home-page">

    <!-- =========================================
         HERO
    ========================================== -->

    <section class="hero-section">

        <div class="hero-container">

            <div class="hero-content">

                <span class="hero-badge">
                    <i class="fa-solid fa-bolt"></i>
                    Welcome to GABSITE
                </span>

                <h1>
                    Discover products.
                    <span>Shop smarter.</span>
                </h1>

                <p>
                    Find the products you love from trusted sellers
                    across the GABSITE marketplace.
                </p>

                <div class="hero-search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="search"
                        id="heroSearch"
                        placeholder="What are you looking for?"
                        autocomplete="off">

                    <button id="heroSearchBtn">
                        Search
                    </button>

                </div>

                <div class="popular-searches">

                    <span>Popular:</span>

                    <button data-search="phone">
                        Phones
                    </button>

                    <button data-search="laptop">
                        Laptops
                    </button>

                    <button data-search="shoe">
                        Shoes
                    </button>

                    <button data-search="fashion">
                        Fashion
                    </button>

                </div>

            </div>

            <div class="hero-visual">

                <div class="hero-circle hero-circle-one"></div>
                <div class="hero-circle hero-circle-two"></div>

                <div class="hero-card hero-card-main">

                    <div class="hero-card-icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>

                    <div>
                        <strong>GABSITE Marketplace</strong>
                        <span>Everything you need.</span>
                    </div>

                </div>

                <div class="floating-card floating-card-top">

                    <i class="fa-solid fa-truck-fast"></i>

                    <div>
                        <strong>Fast Delivery</strong>
                        <span>Across Nigeria</span>
                    </div>

                </div>

                <div class="floating-card floating-card-bottom">

                    <i class="fa-solid fa-shield-halved"></i>

                    <div>
                        <strong>Shop With Confidence</strong>
                        <span>Trusted marketplace</span>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         QUICK CATEGORIES
    ========================================== -->

    <section class="categories-section">

        <div class="section-container">

            <div class="section-heading">

                <div>
                    <span class="section-label">
                        Explore
                    </span>

                    <h2>
                        Shop by category
                    </h2>
                </div>

                <a href="#products">
                    View all
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>


            <div class="category-grid">

                <button
                    class="category-card"
                    data-search="phone">

                    <div class="category-icon">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>

                    <span>Phones</span>

                </button>


                <button
                    class="category-card"
                    data-search="laptop">

                    <div class="category-icon">
                        <i class="fa-solid fa-laptop"></i>
                    </div>

                    <span>Laptops</span>

                </button>


                <button
                    class="category-card"
                    data-search="fashion">

                    <div class="category-icon">
                        <i class="fa-solid fa-shirt"></i>
                    </div>

                    <span>Fashion</span>

                </button>


                <button
                    class="category-card"
                    data-search="shoe">

                    <div class="category-icon">
                        <i class="fa-solid fa-shoe-prints"></i>
                    </div>

                    <span>Shoes</span>

                </button>


                <button
                    class="category-card"
                    data-search="electronics">

                    <div class="category-icon">
                        <i class="fa-solid fa-tv"></i>
                    </div>

                    <span>Electronics</span>

                </button>


                <button
                    class="category-card"
                    data-search="home">

                    <div class="category-icon">
                        <i class="fa-solid fa-house"></i>
                    </div>

                    <span>Home</span>

                </button>


                <button
                    class="category-card"
                    data-search="beauty">

                    <div class="category-icon">
                        <i class="fa-solid fa-spa"></i>
                    </div>

                    <span>Beauty</span>

                </button>


                <button
                    class="category-card"
                    data-search="accessories">

                    <div class="category-icon">
                        <i class="fa-solid fa-gem"></i>
                    </div>

                    <span>Accessories</span>

                </button>

            </div>

        </div>

    </section>


    <!-- =========================================
         MARKETPLACE
    ========================================== -->

    <section class="marketplace-section" id="products">

        <div class="section-container marketplace-layout">


            <!-- FILTER SIDEBAR -->

            <aside class="filter-sidebar">

                <div class="filter-header">

                    <h3>
                        <i class="fa-solid fa-sliders"></i>
                        Filters
                    </h3>

                    <button id="clearFilters">
                        Clear
                    </button>

                </div>


                <div class="filter-group">

                    <h4>Search</h4>

                    <div class="filter-search">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input
                            type="search"
                            id="productSearch"
                            placeholder="Search products...">

                    </div>

                </div>


                <div class="filter-group">

                    <h4>Price range</h4>

                    <div class="price-inputs">

                        <input
                            type="number"
                            id="minPrice"
                            placeholder="Min">

                        <span>—</span>

                        <input
                            type="number"
                            id="maxPrice"
                            placeholder="Max">

                    </div>

                    <button
                        class="apply-filter"
                        id="applyPriceFilter">

                        Apply price

                    </button>

                </div>


                <div class="filter-group">

                    <h4>Availability</h4>

                    <label class="checkbox-row">

                        <input
                            type="checkbox"
                            id="inStockOnly">

                        <span>
                            In stock
                        </span>

                    </label>

                </div>


                <div class="filter-group">

                    <h4>Sort products</h4>

                    <select id="sortProducts">

                        <option value="latest">
                            Latest
                        </option>

                        <option value="price-low">
                            Price: Low to High
                        </option>

                        <option value="price-high">
                            Price: High to Low
                        </option>

                        <option value="name">
                            Name: A-Z
                        </option>

                    </select>

                </div>

            </aside>


            <!-- PRODUCTS -->

            <div class="products-area">

                <div class="products-header">

                    <div>

                        <span class="section-label">
                            Marketplace
                        </span>

                        <h2 id="productsTitle">
                            Discover products
                        </h2>

                        <p id="productCount">
                            Browse products available on GABSITE.
                        </p>

                    </div>

                    <button
                        class="mobile-filter-btn"
                        id="mobileFilterBtn">

                        <i class="fa-solid fa-sliders"></i>

                        Filters

                    </button>

                </div>


                <!-- LOADING -->

                <div
                    class="products-loading"
                    id="productsLoading">

                    <div class="loading-spinner"></div>

                    <p>
                        Loading products...
                    </p>

                </div>


                <!-- ERROR -->

                <div
                    class="products-error"
                    id="productsError">

                    <div class="state-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                    <h3>
                        Something went wrong
                    </h3>

                    <p id="errorMessage">
                        We couldn't load the products.
                    </p>

                    <button id="retryProducts">
                        Try again
                    </button>

                </div>


                <!-- EMPTY -->

                <div
                    class="products-empty"
                    id="productsEmpty">

                    <div class="state-icon">
                        <i class="fa-solid fa-box-open"></i>
                    </div>

                    <h3>
                        No products found
                    </h3>

                    <p>
                        Try changing your search or filters.
                    </p>

                    <button id="emptyReset">
                        Clear filters
                    </button>

                </div>


                <!-- PRODUCT GRID -->

                <div
                    class="product-grid"
                    id="productGrid">
                </div>


                <!-- PAGINATION -->

                <div
                    class="pagination"
                    id="pagination">

                    <button
                        class="pagination-btn"
                        id="previousPage">

                        <i class="fa-solid fa-chevron-left"></i>

                    </button>

                    <div id="pageNumbers"></div>

                    <button
                        class="pagination-btn"
                        id="nextPage">

                        <i class="fa-solid fa-chevron-right"></i>

                    </button>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         TRUST SECTION
    ========================================== -->

    <section class="trust-section">

        <div class="section-container">

            <div class="trust-grid">

                <div class="trust-item">

                    <div class="trust-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <div>
                        <strong>Shop securely</strong>
                        <span>
                            Your shopping experience matters.
                        </span>
                    </div>

                </div>


                <div class="trust-item">

                    <div class="trust-icon">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>

                    <div>
                        <strong>Fast delivery</strong>
                        <span>
                            Get your products delivered.
                        </span>
                    </div>

                </div>


                <div class="trust-item">

                    <div class="trust-icon">
                        <i class="fa-solid fa-store"></i>
                    </div>

                    <div>
                        <strong>Trusted sellers</strong>
                        <span>
                            Discover products from sellers.
                        </span>

                    </div>

                </div>


                <div class="trust-item">

                    <div class="trust-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>

                    <div>
                        <strong>We're here to help</strong>
                        <span>
                            Support when you need it.
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </section>

</main>


<script src="./assets/js/home.js"></script>

</body>

</html>