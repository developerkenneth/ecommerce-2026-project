const urlString = window.location.search;
const searchParams = new URLSearchParams(urlString);
const uuid = searchParams.get("id");
const productContainer = document.querySelector(".product-container");
const fullDescription = document.querySelector(".full-desc");

async function fetchProduct(url) {
    try {
        const response = await fetch(url);
        const data = await response.json();
        fillDesc(data.product.description);
        displayProduct(data.product);

    } catch (error) {
        console.log(error);
    } finally {
        // loaderContainer.classList.add("hidden");
        // productsContainer.classList.remove("hidden");
    }
}


const fillDesc = (description) => {
    fullDescription.textContent = description ? description : "No description found";

}
const displayProduct = (product) => {
    productContainer.innerHTML = `
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
        <div class="product-details">

            <h1>${product?.name}</h1>

            <div class="rating">

                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>

                <span>(212 Reviews)</span>

            </div>

            <div class="price">

                <h2>₦${discount(parseInt(product?.price), product?.discount_percentage)}</h2>

               <del>₦${product?.price}</del>

                ${product?.discount_percentage}% OFF</span>

            </div>

            <p class="stock">
                <i class="fas fa-check-circle"></i>
                In Stock
            </p>

            ${product?.description && `
            <p class="description">
            ${product?.description}
            </p>`}

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
        
        
        `
}

const discount = (price, percentage) => {
    const discount = percentage / 100 * price;

    return price - discount;
}


fetchProduct(`http://localhost/e-commerce.com/api/products.php?id=${uuid}`)