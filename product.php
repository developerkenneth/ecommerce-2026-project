<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/product.css">
</head>

<body>

    <!-- HEADER -->
    <header>

        <div class="logo">
            <h2>GABSITE</h2>
        </div>

        <div class="search-box">


            <input id="searchInput" type="text" placeholder="Search products...">
            <button> <i class="fa-solid fa-magnifying-glass"></i></button>
        </div>

        <div class="nav-icons">

            <div class="icon">
                <i class="fa-regular fa-user"></i>
                <span>Account</span>

            </div>
            <div class="icon">
                <i class="fa-regular fa-heart"></i>
                <span>what we love</span>
            </div>



            <div class="icon">
                <i class="fa-regular fa-user"></i>
                <span>help </span>

            </div>

            <div class="icon cart-icon">
                <a href="cart.php">
                    <i class="fa-solid fa-cart-shopping"></i>

                    <span class="cart-count">0 </span></a>
            </div>

        </div>

    </header>

    <!-- section for more product -->


    <!-- BREADCRUMB -->
    <section class="breadcrumb">
        <a href="#">Home</a>
        <span>/</span>
        <a href="#">Electronics</a>
        <span>/</span>
        <a href="#">Laptops</a>
        <span>/</span>
        <strong>HP EliteBook 840 G7</strong>
    </section>

    <!-- PRODUCT SECTION -->
    <section class="product-container">

        <!-- LEFT -->
        <div class="product-gallery">

            <div class="main-image">
                <img src="./img/laptop1.png" id="mainImage" alt="Product">
            </div>

            <div class="thumbnail-images">

                <img src="./img/laptop1.png" class="thumb active">

                <img src="./img/laptop2.png" class="thumb">

                <img src="./img/laptop3.png" class="thumb">

                <img src="./img/laptop4.png" class="thumb">

            </div>

        </div>

        <!-- RIGHT -->
        <div class="product-details">

            <h1>HP EliteBook 840 G7</h1>

            <div class="rating">

                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>

                <span>(212 Reviews)</span>

            </div>

            <div class="price">

                <h2>₦350,000</h2>

                <del>₦420,000</del>

                <span class="discount">17% OFF</span>

            </div>

            <p class="stock">
                <i class="fas fa-check-circle"></i>
                In Stock
            </p>

            <p class="description">

                The HP EliteBook 840 G7 is a premium business laptop with
                Intel Core i5 processor, 16GB RAM, 512GB SSD and Full HD display.

            </p>

            <!-- Quantity -->

            <div class="quantity">

                <button id="minus">-</button>

                <input type="text" value="1" id="qty" readonly>

                <button id="plus">+</button>

            </div>

            <div class="buttons">

                <button class="cart-btn">
                    <i class="fas fa-cart-shopping"></i>
                    Add to Cart
                </button>

                <button class="buy-btn">
                    Buy Now
                </button>

            </div>

        </div>

    </section>

    <section class="highlights">

        <h2>✔ Product Highlights</h2>

        <ul>


            <li>✔ Intel Core i5 Processor</li>

            <li>✔ 16GB DDR4 RAM</li>

            <li>✔ 512GB SSD Storage</li>

            <li>✔ 14-inch Full HD Display</li>

            <li>✔ Fingerprint Sensor</li>

            <li>✔ Backlit Keyboard</li>

            <li>✔ Windows 11 Pro</li>

        </ul>

    </section>

    <section class="description-box">

        <h2>Product Description</h2>

        <p class="full-desc">



        </p>

    </section>
    <section class="specifications">

        <h2>Specifications</h2>

        <table>

            <tr>
                <td>Brand</td>
                <td>HP</td>
            </tr>

            <tr>
                <td>Model</td>
                <td>EliteBook 840 G7</td>
            </tr>

            <tr>
                <td>Processor</td>
                <td>Intel Core i5</td>
            </tr>

            <tr>
                <td>RAM</td>
                <td>16GB</td>
            </tr>

            <tr>
                <td>Storage</td>
                <td>512GB SSD</td>
            </tr>

            <tr>
                <td>Display</td>
                <td>14-inch Full HD</td>
            </tr>

            <tr>
                <td>Operating System</td>
                <td>Windows 11 Pro</td>
            </tr>

        </table>

    </section>

    <section class="delivery">

        <h2>Delivery Information</h2>

        <div class="delivery-card">

            <div>

                <h4>🚚 Standard Delivery</h4>

                <p>Delivery within 2-5 working days.</p>

            </div>

            <div>

                <h4>🔄 Easy Returns</h4>

                <p>Return within 7 days after delivery.</p>

            </div>

            <div>

                <h4>🛡 Warranty</h4>

                <p>12 Months Manufacturer Warranty.</p>

            </div>

        </div>

    </section>

    <!-- RELATED PRODUCTS -->

    <section class="related-products">

        <h2>You May Also Like</h2>

        <div class="product-grid">

            <div class="product-card">

                <span class="badge">-15%</span>

                <img src="./img/laptop4.png" alt="Laptop">

                <h3>HP EliteBook 850</h3>

                <div class="stars">
                    ★★★★★
                </div>

                <p class="price">₦320,000</p>

                <button>View Product</button>

            </div>

            <div class="product-card">

                <span class="badge">NEW</span>

                <img src="./img/laptop1.png" alt="Laptop">

                <h3>Dell Latitude</h3>

                <div class="stars">
                    ★★★★☆
                </div>

                <p class="price">₦410,000</p>

                <button>View Product</button>

            </div>

            <div class="product-card">

                <span class="badge">HOT</span>

                <img src="./img/laptop2.png" alt="Laptop">

                <h3>Lenovo ThinkPad</h3>

                <div class="stars">
                    ★★★★★
                </div>

                <p class="price">₦365,000</p>

                <button>View Product</button>

            </div>

            <div class="product-card">

                <span class="badge">SALE</span>

                <img src="./img/laptop3.png" alt="Laptop">

                <h3>MacBook Air</h3>

                <div class="stars">
                    ★★★★★
                </div>

                <p class="price">₦850,000</p>

                <button>View Product</button>

            </div>

        </div>

    </section>

    <footer>

        <div class="footer-content">

            <div>
                <h3>MyShop</h3>
                <p>Your trusted online shopping destination.</p>
            </div>

            <div>

                <h4>Quick Links</h4>

                <ul>

                    <li><a href="#">Home</a></li>

                    <li><a href="#">Shop</a></li>

                    <li><a href="#">Contact</a></li>

                    <li><a href="#">About</a></li>

                </ul>

            </div>

            <div>

                <h4>Customer Service</h4>

                <ul>

                    <li><a href="#">Returns</a></li>

                    <li><a href="#">Privacy</a></li>

                    <li><a href="#">Terms</a></li>

                    <li><a href="#">Support</a></li>

                </ul>

            </div>

        </div>

        <p class="copyright">
            © 2026 GABSITE. All Rights Reserved.
        </p>

    </footer>
    <script src="./assets/js/product.js"></script>

</body>

</html>