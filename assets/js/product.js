const urlString = window.location.search;

const searchParams = new URLSearchParams(urlString);

const uuid = searchParams.get("id");

const productContainer = document.querySelector(".product-container");

const fullDescription = document.querySelector(".full-desc");

// ========================================
// API
// ========================================

const API_URL = "http://localhost/fullproductv1/api/products.php";

// ========================================
// FETCH PRODUCT
// ========================================

async function fetchProduct() {
  if (!uuid) {
    productContainer.innerHTML = `
            <div class="product-error">
                <h2>Product not found</h2>
                <p>No product ID was provided.</p>
            </div>
        `;

    return;
  }

  try {
    productContainer.innerHTML = `
            <div class="product-loading">
                Loading product...
            </div>
        `;

    const response = await fetch(`${API_URL}?id=${encodeURIComponent(uuid)}`);

    const data = await response.json();

    console.log("Product API:", data);

    if (!response.ok || !data.success || !data.product) {
      throw new Error(data.message || "Product could not be found.");
    }

    fillDescription(data.product.description);

    displayProduct(data.product);
  } catch (error) {
    console.error("Product error:", error);

    productContainer.innerHTML = `
            <div class="product-error">
                <h2>Unable to load product</h2>
                <p>${error.message}</p>
            </div>
        `;
  }
}

// ========================================
// DESCRIPTION
// ========================================

function fillDescription(description) {
  if (!fullDescription) {
    return;
  }

  fullDescription.textContent = description || "No description available.";
}

// ========================================
// DISPLAY PRODUCT
// ========================================

function displayProduct(product) {
  const photos = getProductPhotos(product.photos);

  const mainPhoto =
    photos.length > 0
      ? getImageUrl(photos[0])
      : "./assets/images/product-placeholder.png";

  const thumbnails =
    photos.length > 0
      ? photos
          .map((photo, index) => {
            const imageUrl = getImageUrl(photo);

            return `
                <img
                    src="${imageUrl}"
                    class="thumb ${index === 0 ? "active" : ""}"
                    data-image="${imageUrl}"
                    alt="${escapeHTML(product.name)}"
                >
            `;
          })
          .join("")
      : `
            <div class="no-image">
                No images
            </div>
        `;

  const discountPercentage = Number(product.discount_percentage || 0);

  const price = Number(product.price || 0);

  const discountedPrice = calculateDiscount(price, discountPercentage);

  const stock = Number(product.stocks_available || 0);

  productContainer.innerHTML = `

        <div class="product-gallery">

            <div class="main-image">

                <img
                    src="${mainPhoto}"
                    id="mainImage"
                    alt="${escapeHTML(product.name)}"
                >

            </div>


            <div class="thumbnail-images">

                ${thumbnails}

            </div>

        </div>


        <div class="product-details">

            <div class="product-category">
                ${escapeHTML(product.category || "Product")}
            </div>


            <h1>
                ${escapeHTML(product.name)}
            </h1>


            <div class="product-brand">

                Brand:
                <strong>
                    ${escapeHTML(product.brand || "N/A")}
                </strong>

            </div>


            <div class="rating">

                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>

                <span>
                    Product rating
                </span>

            </div>


            <div class="price">

                <h2>
                    ₦${formatPrice(discountedPrice)}
                </h2>


                ${
                  discountPercentage > 0
                    ? `
                            <del>
                                ₦${formatPrice(price)}
                            </del>

                            <span class="discount">
                                ${discountPercentage}% OFF
                            </span>
                        `
                    : ""
                }

            </div>


            <p class="stock">

                ${
                  stock > 0
                    ? `
                            <i class="fas fa-check-circle"></i>
                            ${stock} available
                        `
                    : `
                            <i class="fas fa-times-circle"></i>
                            Out of stock
                        `
                }

            </p>


            ${
              product.description
                ? `
                        <p class="description">
                            ${escapeHTML(product.description)}
                        </p>
                    `
                : ""
            }


            <div class="quantity">

                <button
                    type="button"
                    id="minus">
                    -
                </button>


                <input
                    type="text"
                    value="1"
                    id="qty"
                    readonly
                >


                <button
                    type="button"
                    id="plus">
                    +
                </button>

            </div>


            <div class="buttons">

                <button
                    type="button"
                    class="cart-btn"
                    ${stock <= 0 ? "disabled" : ""}
                >

                    <i class="fas fa-cart-shopping"></i>

                    Add to Cart

                </button>


                <button
                    type="button"
                    class="buy-btn"
                    ${stock <= 0 ? "disabled" : ""}
                >

                    Buy Now

                </button>

            </div>

        </div>

    `;

  setupGallery();

  setupQuantity(stock);
}

// ========================================
// PRODUCT PHOTOS
// ========================================

function getProductPhotos(photos) {
  if (!photos) {
    return [];
  }

  if (Array.isArray(photos)) {
    return photos;
  }

  try {
    const parsed = JSON.parse(photos);

    return Array.isArray(parsed) ? parsed : [];
  } catch (error) {
    console.error("Could not parse product photos:", error);

    return [];
  }
}

// ========================================
// IMAGE URL
// ========================================

function getImageUrl(photo) {
  if (!photo) {
    return "./assets/images/product-placeholder.png";
  }

  if (photo.startsWith("http://") || photo.startsWith("https://")) {
    return photo;
  }

  return `http://localhost/fullproductv1/assets/photos/${photo}`;
}

// ========================================
// GALLERY
// ========================================

function setupGallery() {
  const mainImage = document.getElementById("mainImage");

  const thumbnails = document.querySelectorAll(".thumb");

  if (!mainImage || thumbnails.length === 0) {
    return;
  }

  thumbnails.forEach((thumb) => {
    thumb.addEventListener("click", function () {
      mainImage.src = this.dataset.image;

      thumbnails.forEach((item) => {
        item.classList.remove("active");
      });

      this.classList.add("active");
    });
  });
}

// ========================================
// QUANTITY
// ========================================

function setupQuantity(stock) {
  const minus = document.getElementById("minus");

  const plus = document.getElementById("plus");

  const qty = document.getElementById("qty");

  if (!minus || !plus || !qty) {
    return;
  }

  let quantity = 1;

  plus.addEventListener("click", function () {
    if (quantity < stock) {
      quantity++;

      qty.value = quantity;
    }
  });

  minus.addEventListener("click", function () {
    if (quantity > 1) {
      quantity--;

      qty.value = quantity;
    }
  });
}

// ========================================
// DISCOUNT
// ========================================

function calculateDiscount(price, percentage) {
  if (!percentage || percentage <= 0) {
    return price;
  }

  const discount = (percentage / 100) * price;

  return price - discount;
}

// ========================================
// PRICE FORMAT
// ========================================

function formatPrice(price) {
  return Number(price).toLocaleString("en-NG", {
    minimumFractionDigits: 0,

    maximumFractionDigits: 2,
  });
}

// ========================================
// HTML SAFETY
// ========================================

function escapeHTML(value) {
  const div = document.createElement("div");

  div.textContent = value ?? "";

  return div.innerHTML;
}

// ========================================
// START
// ========================================

fetchProduct();
