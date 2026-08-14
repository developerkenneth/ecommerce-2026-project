document.addEventListener("DOMContentLoaded", () => {
  const API_URL = "./api/products.php";

  // --------------------------------
  // ELEMENTS
  // --------------------------------

  const loading = document.getElementById("productLoading");
  const errorBox = document.getElementById("productError");
  const errorMessage = document.getElementById("productErrorMessage");

  const productContent = document.getElementById("productContent");
  const productInformation = document.getElementById("productInformation");
  const relatedSection = document.getElementById("relatedSection");

  const mainImage = document.getElementById("mainImage");
  const thumbnailImages = document.getElementById("thumbnailImages");

  const productName = document.getElementById("productName");
  const productCategory = document.getElementById("productCategory");
  const productBrand = document.getElementById("productBrand");

  const productPrice = document.getElementById("productPrice");
  const oldPrice = document.getElementById("oldPrice");
  const discountBadge = document.getElementById("discountBadge");

  const shortDescription = document.getElementById("shortDescription");
  const fullDescription = document.getElementById("fullDescription");

  const stockStatus = document.getElementById("stockStatus");
  const stockQuantity = document.getElementById("stockQuantity");

  const metaCategory = document.getElementById("metaCategory");

  const specName = document.getElementById("specName");
  const specBrand = document.getElementById("specBrand");
  const specCategory = document.getElementById("specCategory");
  const specStock = document.getElementById("specStock");
  const specStatus = document.getElementById("specStatus");

  const breadcrumbProduct = document.getElementById("breadcrumbProduct");

  const quantityInput = document.getElementById("qty");
  const minusButton = document.getElementById("minus");
  const plusButton = document.getElementById("plus");

  const addToCartButton = document.getElementById("addToCartBtn");

  const buyNowButton = document.getElementById("buyNowBtn");

  const relatedProducts = document.getElementById("relatedProducts");

  // --------------------------------
  // GET PRODUCT ID FROM URL
  // --------------------------------

  const urlParams = new URLSearchParams(window.location.search);

  const productId = urlParams.get("id");

  if (!productId) {
    showError("No product ID was provided.");

    return;
  }

  // --------------------------------
  // LOAD PRODUCT
  // --------------------------------

  loadProduct();

  async function loadProduct() {
    try {
      const response = await fetch(
        `${API_URL}?id=${encodeURIComponent(productId)}`,
      );

      const text = await response.text();

      console.log("PRODUCT API RESPONSE:", text);

      let data;

      try {
        data = JSON.parse(text);
      } catch (jsonError) {
        console.error("API did not return JSON:", text);

        throw new Error("The product API returned an invalid response.");
      }

      if (!response.ok || !data.success) {
        throw new Error(data.message || "Unable to load this product.");
      }

      console.log("PRODUCT DATA:", data.product);

      renderProduct(data.product);

      // Load related products
      loadRelatedProducts(data.product);
    } catch (error) {
      console.error("Product loading error:", error);

      showError(error.message);
    }
  }

  // --------------------------------
  // RENDER PRODUCT
  // --------------------------------

  function renderProduct(product) {
    console.log("Rendering product:", product);

    // NAME
    productName.textContent = product.name || "Unnamed Product";

    breadcrumbProduct.textContent = product.name || "Product";

    // CATEGORY
    const category = product.category || "General";

    productCategory.textContent = category;

    metaCategory.textContent = category;

    specCategory.textContent = category;

    // BRAND
    const brand = product.brand || "No brand";

    productBrand.textContent = brand;

    specBrand.textContent = brand;

    // PRICE
    const price = Number(product.price || 0);

    productPrice.textContent = formatCurrency(price);

    // DISCOUNT
    const discount = Number(product.discount_percentage || 0);

    if (discount > 0) {
      const originalPrice = price / (1 - discount / 100);

      oldPrice.textContent = formatCurrency(originalPrice);

      oldPrice.style.display = "inline";

      discountBadge.textContent = `${discount}% OFF`;

      discountBadge.style.display = "inline-block";
    } else {
      oldPrice.style.display = "none";

      discountBadge.style.display = "none";
    }

    // STOCK
    const stock = Number(product.stocks_available || 0);

    stockQuantity.textContent = stock;

    specStock.textContent = stock;

    if (stock > 0) {
      stockStatus.innerHTML = `
                <i class="fas fa-check-circle"></i>
                In Stock
            `;

      stockStatus.classList.remove("out-of-stock");

      quantityInput.max = stock;
    } else {
      stockStatus.innerHTML = `
                <i class="fas fa-circle-xmark"></i>
                Out of Stock
            `;

      stockStatus.classList.add("out-of-stock");

      addToCartButton.disabled = true;
      buyNowButton.disabled = true;
    }

    // DESCRIPTION
    const description =
      product.description || "No description available for this product.";

    shortDescription.textContent = description;

    fullDescription.textContent = description;

    // STATUS
    specStatus.textContent = product.status || "Available";

    // PHOTOS
    renderPhotos(product.photos);

    // SHOW PAGE
    loading.style.display = "none";

    productContent.style.display = "grid";

    productInformation.style.display = "block";
  }

  // --------------------------------
  // RENDER PHOTOS
  // --------------------------------

  function renderPhotos(photos) {
    let photoList = [];

    if (Array.isArray(photos)) {
      photoList = photos;
    } else if (typeof photos === "string") {
      try {
        const parsed = JSON.parse(photos);

        if (Array.isArray(parsed)) {
          photoList = parsed;
        }
      } catch (error) {
        console.warn("Could not parse product photos.");
      }
    }

    // No images
    if (photoList.length === 0) {
      const fallback = "./assets/images/no-image.png";

      mainImage.src = fallback;

      mainImage.alt = "No product image";

      return;
    }

    // First image
    mainImage.src = getPhotoUrl(photoList[0]);

    mainImage.alt = productName.textContent;

    // Clear thumbnails
    thumbnailImages.innerHTML = "";

    photoList.forEach((photo, index) => {
      const image = document.createElement("img");

      image.src = getPhotoUrl(photo);

      image.alt = `${productName.textContent} ${index + 1}`;

      image.classList.add("thumb");

      if (index === 0) {
        image.classList.add("active");
      }

      image.addEventListener("click", () => {
        mainImage.src = getPhotoUrl(photo);

        document
          .querySelectorAll(".thumbnail-images .thumb")
          .forEach((thumb) => {
            thumb.classList.remove("active");
          });

        image.classList.add("active");
      });

      thumbnailImages.appendChild(image);
    });
  }

  // --------------------------------
  // PHOTO URL
  // --------------------------------

  function getPhotoUrl(photo) {
    if (!photo) {
      return "./assets/images/no-image.png";
    }

    // If API eventually returns a full URL
    if (photo.startsWith("http://") || photo.startsWith("https://")) {
      return photo;
    }

    return `./assets/photos/${photo}`;
  }

  // --------------------------------
  // QUANTITY
  // --------------------------------

  minusButton.addEventListener("click", () => {
    let quantity = Number(quantityInput.value);

    if (quantity > 1) {
      quantity--;

      quantityInput.value = quantity;
    }
  });

  plusButton.addEventListener("click", () => {
    let quantity = Number(quantityInput.value);

    const max = Number(quantityInput.max || 999999);

    if (quantity < max) {
      quantity++;

      quantityInput.value = quantity;
    }
  });

  // --------------------------------
  // --------------------------------
  // ADD TO CART
  // --------------------------------

  addToCartButton.addEventListener("click", async () => {
    const quantity = Number(quantityInput.value);

    console.log("Add to cart:", {
      productId,
      quantity,
    });

    if (!productId) {
      alert("Product ID is missing.");

      return;
    }

    if (quantity < 1) {
      alert("Please select a valid quantity.");

      return;
    }

    const originalText = addToCartButton.innerHTML;

    addToCartButton.disabled = true;

    addToCartButton.innerHTML = `
    <i class="fas fa-spinner fa-spin"></i>
    Adding...
  `;

    try {
      const response = await fetch("./api/cart.php", {
        method: "POST",

        credentials: "include",

        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },

        body: JSON.stringify({
          product_uuid: productId,
          quantity: quantity,
        }),
      });

      const rawResponse = await response.text();

      console.log("CART API STATUS:", response.status);

      console.log("CART API RESPONSE:", rawResponse);

      let data;

      try {
        data = JSON.parse(rawResponse);
      } catch (error) {
        console.error("Cart API did not return valid JSON:", rawResponse);

        throw new Error("The cart server returned an invalid response.");
      }

      if (response.status === 401) {
        alert(
          data.message || "Please login before adding products to your cart.",
        );

        window.location.href = "./login.php";

        return;
      }

      if (!response.ok || !data.success) {
        throw new Error(data.message || "Unable to add product to cart.");
      }

      console.log("Product successfully added to cart:", data);

      addToCartButton.innerHTML = `
      <i class="fas fa-check"></i>
      Added to Cart
    `;

      setTimeout(() => {
        window.location.href = "./cart.php";
      }, 500);
    } catch (error) {
      console.error("Add to cart error:", error);

      alert(error.message || "Unable to add product to cart.");

      addToCartButton.innerHTML = originalText;

      addToCartButton.disabled = false;
    }
  });

  // --------------------------------
  // BUY NOW
  // --------------------------------

  buyNowButton.addEventListener("click", () => {
    const quantity = Number(quantityInput.value);

    console.log("Buy now:", {
      productId,
      quantity,
    });

    // We will connect this to checkout later.
  });

  // --------------------------------
  // RELATED PRODUCTS
  // --------------------------------

  async function loadRelatedProducts(currentProduct) {
    try {
      const response = await fetch(API_URL);

      const data = await response.json();

      if (!data.success || !Array.isArray(data.products)) {
        return;
      }

      const products = data.products
        .filter((product) => product.uuid !== currentProduct.uuid)
        .slice(0, 4);

      if (products.length === 0) {
        return;
      }

      relatedProducts.innerHTML = "";

      products.forEach((product) => {
        const card = createRelatedCard(product);

        relatedProducts.appendChild(card);
      });

      relatedSection.style.display = "block";
    } catch (error) {
      console.error("Related products error:", error);
    }
  }

  // --------------------------------
  // RELATED PRODUCT CARD
  // --------------------------------

  function createRelatedCard(product) {
    const card = document.createElement("article");

    card.className = "product-card";

    const image = getFirstPhoto(product.photos);

    const price = formatCurrency(Number(product.price || 0));

    card.innerHTML = `

            <div class="related-image">

                <img
                    src="${image}"
                    alt="${escapeHtml(product.name)}"
                >

            </div>

            <div class="related-content">

                <span class="related-category">
                    ${escapeHtml(product.category || "Product")}
                </span>

                <h3>
                    ${escapeHtml(product.name || "Unnamed Product")}
                </h3>

                <strong class="related-price">
                    ${price}
                </strong>

                <button
                    type="button"
                    class="view-product-btn"
                >
                    View Product
                </button>

            </div>

        `;

    const button = card.querySelector(".view-product-btn");

    button.addEventListener("click", () => {
      window.location.href = `./product.php?id=${encodeURIComponent(
        product.uuid,
      )}`;
    });

    return card;
  }

  // --------------------------------
  // GET FIRST PHOTO
  // --------------------------------

  function getFirstPhoto(photos) {
    let list = [];

    if (Array.isArray(photos)) {
      list = photos;
    } else if (typeof photos === "string") {
      try {
        list = JSON.parse(photos);
      } catch (error) {
        return "./assets/images/no-image.png";
      }
    }

    if (!Array.isArray(list) || list.length === 0) {
      return "./assets/images/no-image.png";
    }

    return getPhotoUrl(list[0]);
  }

  // --------------------------------
  // CURRENCY
  // --------------------------------

  function formatCurrency(amount) {
    return new Intl.NumberFormat("en-NG", {
      style: "currency",
      currency: "NGN",
      minimumFractionDigits: 2,
    }).format(amount);
  }

  // --------------------------------
  // ESCAPE HTML
  // --------------------------------

  function escapeHtml(value) {
    const div = document.createElement("div");

    div.textContent = value;

    return div.innerHTML;
  }

  // --------------------------------
  // ERROR
  // --------------------------------

  function showError(message) {
    loading.style.display = "none";

    productContent.style.display = "none";

    productInformation.style.display = "none";

    relatedSection.style.display = "none";

    errorMessage.textContent = message || "Something went wrong.";

    errorBox.style.display = "flex";
  }
});
