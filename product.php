<?php

$pageTitle = "Product Details";

require_once "components/user/head.php";

?>

<?php include_once "components/user/header.php"; ?>

<link rel="stylesheet" href="./assets/css/product.css">

<main class="single-product-page">

    <!-- BREADCRUMB -->
    <section class="breadcrumb">
        <a href="./index.php">Home</a>
        <span>/</span>
        <strong id="breadcrumbProduct">Product</strong>
    </section>


    <!-- LOADING -->
    <section id="productLoading" class="product-loading">

        <div class="loader"></div>

        <p>Loading product...</p>

    </section>


    <!-- ERROR -->
    <section id="productError" class="product-error" style="display:none;">

        <i class="fa-solid fa-circle-exclamation"></i>

        <h2>Product Not Found</h2>

        <p id="productErrorMessage">
            We couldn't find this product.
        </p>

        <a href="./index.php">
            Back to Products
        </a>

    </section>


    <!-- PRODUCT -->
    <section
        id="productContent"
        class="product-container"
        style="display:none;">

        <!-- LEFT SIDE -->
        <div class="product-gallery">

            <div class="main-image">

                <img
                    src=""
                    id="mainImage"
                    alt="Product">

            </div>

            <div
                class="thumbnail-images"
                id="thumbnailImages"></div>

        </div>


        <!-- RIGHT SIDE -->
        <div class="product-details">

            <div class="product-category" id="productCategory">
                Product
            </div>

            <h1 id="productName">
                Product Name
            </h1>


            <div class="rating">

                <span class="stars">
                    ★★★★★
                </span>

                <span>
                    No reviews yet
                </span>

            </div>


            <div class="price">

                <h2 id="productPrice">
                    ₦0.00
                </h2>

                <del id="oldPrice" style="display:none;"></del>

                <span
                    class="discount"
                    id="discountBadge"
                    style="display:none;">
                    0% OFF
                </span>

            </div>


            <p class="stock" id="stockStatus">

                <i class="fas fa-check-circle"></i>

                In Stock

            </p>


            <p
                class="description"
                id="shortDescription">
                Product description
            </p>


            <!-- BRAND -->
            <div class="product-meta">

                <div>
                    <span>Brand</span>
                    <strong id="productBrand">-</strong>
                </div>

                <div>
                    <span>Category</span>
                    <strong id="metaCategory">-</strong>
                </div>

                <div>
                    <span>Available</span>
                    <strong id="stockQuantity">-</strong>
                </div>

            </div>


            <!-- QUANTITY -->
            <div class="quantity-section">

                <label>
                    Quantity
                </label>

                <div class="quantity">

                    <button
                        type="button"
                        id="minus">
                        -
                    </button>

                    <input
                        type="number"
                        id="qty"
                        value="1"
                        min="1"
                        readonly>

                    <button
                        type="button"
                        id="plus">
                        +
                    </button>

                </div>

            </div>


            <!-- BUTTONS -->
            <div class="buttons">

                <button
                    type="button"
                    class="cart-btn"
                    id="addToCartBtn">

                    <i class="fas fa-cart-shopping"></i>

                    Add to Cart

                </button>


                <button
                    type="button"
                    class="buy-btn"
                    id="buyNowBtn">

                    Buy Now

                </button>

            </div>

        </div>

    </section>


    <!-- PRODUCT INFORMATION -->
    <section
        id="productInformation"
        class="product-information"
        style="display:none;">

        <!-- DESCRIPTION -->
        <div class="information-card">

            <div class="section-heading">

                <span class="heading-icon">
                    <i class="fa-solid fa-align-left"></i>
                </span>

                <div>

                    <h2>Product Description</h2>

                    <p>
                        Everything you need to know about this product.
                    </p>

                </div>

            </div>

            <div
                id="fullDescription"
                class="full-description"></div>

        </div>


        <!-- PRODUCT DETAILS -->
        <div class="information-card">

            <div class="section-heading">

                <span class="heading-icon">
                    <i class="fa-solid fa-circle-info"></i>
                </span>

                <div>

                    <h2>Product Information</h2>

                    <p>
                        Product specifications and information.
                    </p>

                </div>

            </div>


            <div class="specification-list">

                <div class="spec-row">

                    <span>Product Name</span>

                    <strong id="specName">-</strong>

                </div>


                <div class="spec-row">

                    <span>Brand</span>

                    <strong id="specBrand">-</strong>

                </div>


                <div class="spec-row">

                    <span>Category</span>

                    <strong id="specCategory">-</strong>

                </div>


                <div class="spec-row">

                    <span>Stock</span>

                    <strong id="specStock">-</strong>

                </div>


                <div class="spec-row">

                    <span>Product Status</span>

                    <strong id="specStatus">-</strong>

                </div>


            </div>

        </div>


        <!-- DELIVERY -->
        <div class="information-card">

            <div class="section-heading">

                <span class="heading-icon">
                    <i class="fa-solid fa-truck"></i>
                </span>

                <div>

                    <h2>Delivery & Returns</h2>

                    <p>
                        Important information about your order.
                    </p>

                </div>

            </div>


            <div class="delivery-grid">

                <div class="delivery-item">

                    <i class="fa-solid fa-truck-fast"></i>

                    <div>

                        <h4>Delivery</h4>

                        <p>
                            Delivery information will be provided
                            during checkout.
                        </p>

                    </div>

                </div>


                <div class="delivery-item">

                    <i class="fa-solid fa-rotate-left"></i>

                    <div>

                        <h4>Returns</h4>

                        <p>
                            Return policies depend on the seller
                            and product.
                        </p>

                    </div>

                </div>


                <div class="delivery-item">

                    <i class="fa-solid fa-shield-halved"></i>

                    <div>

                        <h4>Secure Shopping</h4>

                        <p>
                            Your order information is protected.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- RELATED PRODUCTS -->
    <section
        id="relatedSection"
        class="related-products"
        style="display:none;">

        <div class="related-header">

            <div>

                <span>EXPLORE MORE</span>

                <h2>You May Also Like</h2>

            </div>

            <a href="./index.php">
                View All Products
            </a>

        </div>


        <div
            id="relatedProducts"
            class="product-grid"></div>

    </section>

</main>


<script src="./assets/js/product.js"></script>

<?php include_once "./components/user/footer.php"; ?>