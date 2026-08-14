const API_URL = "./api/products.php";

const productGrid = document.getElementById("productGrid");

const productsLoading = document.getElementById("productsLoading");

const productsError = document.getElementById("productsError");

const productsEmpty = document.getElementById("productsEmpty");

const errorMessage = document.getElementById("errorMessage");

const productCount = document.getElementById("productCount");

const productsTitle = document.getElementById("productsTitle");

const pagination = document.getElementById("pagination");

const pageNumbers = document.getElementById("pageNumbers");

const previousPage = document.getElementById("previousPage");

const nextPage = document.getElementById("nextPage");

const productSearch = document.getElementById("productSearch");

const heroSearch = document.getElementById("heroSearch");

const minPrice = document.getElementById("minPrice");

const maxPrice = document.getElementById("maxPrice");

const sortProducts = document.getElementById("sortProducts");

const inStockOnly = document.getElementById("inStockOnly");

let allProducts = [];

let currentProducts = [];

let currentPage = 1;

const productsPerPage = 12;

/* =========================================
   INITIAL LOAD
========================================= */

document.addEventListener("DOMContentLoaded", () => {
  loadProducts();
});

/* =========================================
   LOAD PRODUCTS
========================================= */

async function loadProducts() {
  showLoading();

  const params = new URLSearchParams();

  const search = productSearch.value.trim();

  const min = minPrice.value.trim();

  const max = maxPrice.value.trim();

  if (search) {
    params.append("search", search);
  }

  if (min) {
    params.append("min_price", min);
  }

  if (max) {
    params.append("max_price", max);
  }

  try {
    const url = params.toString() ? `${API_URL}?${params.toString()}` : API_URL;

    const response = await fetch(url);

    if (!response.ok) {
      throw new Error(`Server returned ${response.status}`);
    }

    const data = await response.json();

    if (!data.success) {
      throw new Error(data.message || "Unable to load products");
    }

    allProducts = Array.isArray(data.products) ? data.products : [];

    currentProducts = [...allProducts];

    applyFrontendFilters();

    hideLoading();
  } catch (error) {
    console.error("Product API error:", error);

    showError(error.message || "Unable to connect to the product server.");
  }
}

/* =========================================
   FRONTEND FILTERS
========================================= */

function applyFrontendFilters() {
  let products = [...allProducts];

  /*
   * STOCK FILTER
   */

  if (inStockOnly.checked) {
    products = products.filter((product) => {
      return Number(product.stocks_available) > 0;
    });
  }

  /*
   * SORT
   */

  const sort = sortProducts.value;

  if (sort === "price-low") {
    products.sort((a, b) => Number(a.price) - Number(b.price));
  }

  if (sort === "price-high") {
    products.sort((a, b) => Number(b.price) - Number(a.price));
  }

  if (sort === "name") {
    products.sort((a, b) => String(a.name).localeCompare(String(b.name)));
  }

  currentProducts = products;

  currentPage = 1;

  renderProducts();
}

/* =========================================
   RENDER PRODUCTS
========================================= */

function renderProducts() {
  hideAllStates();

  productGrid.innerHTML = "";

  if (!currentProducts.length) {
    showEmpty();

    return;
  }

  const start = (currentPage - 1) * productsPerPage;

  const end = start + productsPerPage;

  const visibleProducts = currentProducts.slice(start, end);

  visibleProducts.forEach((product) => {
    productGrid.appendChild(createProductCard(product));
  });

  productCount.textContent = `${currentProducts.length} product${
    currentProducts.length === 1 ? "" : "s"
  } available`;

  updatePagination();
}

/* =========================================
   PRODUCT CARD
========================================= */

function createProductCard(product) {
  const card = document.createElement("article");

  card.className = "product-card";

  /*
   * PRODUCT IMAGE
   */

  let image = getProductImage(product);

  /*
   * STOCK
   */

  const stock = Number(product.stocks_available) || 0;

  const stockText = stock > 0 ? `${stock} available` : "Out of stock";

  /*
   * CARD
   */

  card.innerHTML = `

        <div class="product-image">

            <img
                src="${escapeHTML(image)}"
                alt="${escapeHTML(product.name || "Product")}"
                loading="lazy"
                onerror="this.src='./assets/photos/product-placeholder.png';"
            >

            ${
              stock > 0
                ? `<span class="product-badge">
                        Available
                       </span>`
                : ""
            }

        </div>


        <div class="product-body">

            <span class="product-brand">

                ${escapeHTML(product.brand || "GABSITE")}

            </span>


            <h3 class="product-name">

                ${escapeHTML(product.name || "Unnamed product")}

            </h3>


            <div class="product-price">

                ${formatPrice(product.price)}

            </div>


            <span
                class="product-stock"
                style="${stock <= 0 ? "color:#dc2626;" : ""}">

                ${stockText}

            </span>


            <div class="product-actions">

                <button
                    class="add-cart-btn"
                    data-product-id="${escapeHTML(product.uuid || "")}"
                    ${stock <= 0 ? "disabled" : ""}>

                    <i class="fa-solid fa-cart-plus"></i>

                    ${stock <= 0 ? "Out of stock" : "Add to cart"}

                </button>


                <button
                    class="view-product-btn"
                    data-product-id="${escapeHTML(product.uuid || "")}">

                    <i class="fa-solid fa-eye"></i>

                </button>

            </div>

        </div>

    `;


  const addButton = card.querySelector(".add-cart-btn");

  const viewButton = card.querySelector(".view-product-btn");

  if (addButton) {
    addButton.addEventListener("click", () => {
      addToCart(product);
    });
  }

  if (viewButton) {
    viewButton.addEventListener("click", () => {
      viewProduct(product.uuid);
    });
  }

  return card;
}

/* =========================================
   PRODUCT IMAGE
========================================= */

function getProductImage(product) {
  let photos = product.photos;

  /*
   * photos may come from MySQL
   * as JSON string
   */

  if (typeof photos === "string") {
    try {
      photos = JSON.parse(photos);
    } catch {
      photos = [];
    }
  }

  if (Array.isArray(photos) && photos.length > 0) {
    return `./assets/photos/${photos[0]}`;
  }

  return "./assets/photos/product-placeholder.png";
}

/* =========================================
   PRICE
========================================= */

function formatPrice(price) {
  const number = Number(price);

  if (Number.isNaN(number)) {
    return "Price unavailable";
  }

  return new Intl.NumberFormat("en-NG", {
    style: "currency",
    currency: "NGN",
    maximumFractionDigits: 2,
  }).format(number);
}

/* =========================================
   SEARCH
========================================= */

let searchTimer;

productSearch.addEventListener("input", () => {
  clearTimeout(searchTimer);

  searchTimer = setTimeout(() => {
    loadProducts();
  }, 500);
});

/* =========================================
   HERO SEARCH
========================================= */

document
  .getElementById("heroSearchBtn")
  .addEventListener("click", performHeroSearch);

heroSearch.addEventListener("keydown", (event) => {
  if (event.key === "Enter") {
    performHeroSearch();
  }
});

function performHeroSearch() {
  const value = heroSearch.value.trim();

  productSearch.value = value;

  loadProducts();

  document.getElementById("products").scrollIntoView({
    behavior: "smooth",
  });
}

/* =========================================
   POPULAR SEARCHES
========================================= */

document.querySelectorAll("[data-search]").forEach((button) => {
  button.addEventListener("click", () => {
    const value = button.dataset.search;

    heroSearch.value = value;

    productSearch.value = value;

    loadProducts();

    document.getElementById("products").scrollIntoView({
      behavior: "smooth",
    });
  });
});

/* =========================================
   PRICE FILTER
========================================= */

document.getElementById("applyPriceFilter").addEventListener("click", () => {
  loadProducts();
});

/* =========================================
   STOCK FILTER
========================================= */

inStockOnly.addEventListener("change", () => {
  applyFrontendFilters();
});

/* =========================================
   SORT
========================================= */

sortProducts.addEventListener("change", () => {
  applyFrontendFilters();
});

/* =========================================
   CLEAR FILTERS
========================================= */

document.getElementById("clearFilters").addEventListener("click", clearFilters);

document.getElementById("emptyReset").addEventListener("click", clearFilters);

function clearFilters() {
  productSearch.value = "";

  heroSearch.value = "";

  minPrice.value = "";

  maxPrice.value = "";

  inStockOnly.checked = false;

  sortProducts.value = "latest";

  loadProducts();
}

/* =========================================
   MOBILE FILTER
========================================= */

document.getElementById("mobileFilterBtn").addEventListener("click", () => {
  document.querySelector(".filter-sidebar").classList.toggle("mobile-open");
});

/* =========================================
   PAGINATION
========================================= */

function updatePagination() {
  const totalPages = Math.ceil(currentProducts.length / productsPerPage);

  if (totalPages <= 1) {
    pagination.classList.remove("active");

    return;
  }

  pagination.classList.add("active");

  pageNumbers.innerHTML = "";

  for (let page = 1; page <= totalPages; page++) {
    const button = document.createElement("button");

    button.className = "page-number";

    if (page === currentPage) {
      button.classList.add("active");
    }

    button.textContent = page;

    button.addEventListener("click", () => {
      currentPage = page;

      renderProducts();

      document.getElementById("products").scrollIntoView({
        behavior: "smooth",
      });
    });

    pageNumbers.appendChild(button);
  }

  previousPage.disabled = currentPage === 1;

  nextPage.disabled = currentPage === totalPages;
}

/* =========================================
   PREVIOUS PAGE
========================================= */

previousPage.addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;

    renderProducts();
  }
});

/* =========================================
   NEXT PAGE
========================================= */

nextPage.addEventListener("click", () => {
  const totalPages = Math.ceil(currentProducts.length / productsPerPage);

  if (currentPage < totalPages) {
    currentPage++;

    renderProducts();
  }
});

/* =========================================
   VIEW PRODUCT
========================================= */

function viewProduct(uuid) {
  if (!uuid) {
    console.error("Product UUID missing");

    return;
  }

  window.location.href = `product.php?id=${encodeURIComponent(uuid)}`;
}

/* =========================================
   CART
========================================= */

async function addToCart(product) {

  const productUuid = product?.uuid;

  if (!productUuid) {

    console.error("Product UUID is missing:", product);

    showCartMessage("Unable to add this product.");

    return;
  }


  const stock =
    Number(product.stocks_available || 0);


  if (stock < 1) {

    showCartMessage("This product is out of stock.");

    return;
  }


  const addButton =
    productGrid.querySelector(
      `.add-cart-btn[data-product-id="${CSS.escape(productUuid)}"]`
    );


  const originalText =
    addButton ? addButton.innerHTML : "";


  if (addButton) {

    addButton.disabled = true;

    addButton.innerHTML = `
      <i class="fa-solid fa-spinner fa-spin"></i>
      Adding...
    `;

  }


  try {

    const response = await fetch(
      "./api/cart.php",
      {
        method: "POST",

        credentials: "include",

        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json"
        },

        body: JSON.stringify({
          product_uuid: productUuid,
          quantity: 1
        })
      }
    );


    const rawResponse =
      await response.text();


    console.log(
      "HOME CART API STATUS:",
      response.status
    );


    console.log(
      "HOME CART API RESPONSE:",
      rawResponse
    );


    let data;

    try {

      data =
        JSON.parse(rawResponse);

    } catch (error) {

      console.error(
        "Cart API returned invalid JSON:",
        rawResponse
      );

      throw new Error(
        "The cart server returned an invalid response."
      );
    }


    if (response.status === 401) {

      showCartMessage(
        "Please login before adding products to your cart."
      );

      return;
    }


    if (!response.ok || !data.success) {

      throw new Error(
        data.message ||
        "Unable to add product to cart."
      );
    }


    console.log(
      "Homepage cart success:",
      data
    );


    if (addButton) {

      addButton.innerHTML = `
        <i class="fa-solid fa-check"></i>
        Added
      `;

    }


    showCartMessage(
      `${product.name} added to cart`
    );


    setTimeout(() => {

      if (addButton) {

        addButton.innerHTML =
          originalText;

        addButton.disabled = false;

      }

    }, 1200);


  } catch (error) {

    console.error(
      "Homepage add to cart error:",
      error
    );


    showCartMessage(
      error.message ||
      "Unable to add product to cart."
    );


    if (addButton) {

      addButton.innerHTML =
        originalText;

      addButton.disabled = false;

    }

  }

}



/* =========================================
   CART MESSAGE
========================================= */

function showCartMessage(message) {
  const notification = document.createElement("div");

  notification.className = "cart-notification";

  notification.innerHTML = `

        <i class="fa-solid fa-circle-check"></i>

        <span>
            ${escapeHTML(message)}
        </span>

    `;

  document.body.appendChild(notification);

  setTimeout(() => {
    notification.classList.add("show");
  }, 10);

  setTimeout(() => {
    notification.remove();
  }, 3000);
}

/* =========================================
   LOADING / STATES
========================================= */

function hideAllStates() {
  productsLoading.classList.remove("active");

  productsError.classList.remove("active");

  productsEmpty.classList.remove("active");
}

function showLoading() {
  hideAllStates();

  productGrid.innerHTML = "";

  pagination.classList.remove("active");

  productsLoading.classList.add("active");
}

function hideLoading() {
  productsLoading.classList.remove("active");
}

function showEmpty() {
  hideAllStates();

  productsEmpty.classList.add("active");
}

function showError(message) {
  hideAllStates();

  errorMessage.textContent = message;

  productsError.classList.add("active");
}

/* =========================================
   RETRY
========================================= */

document
  .getElementById("retryProducts")
  .addEventListener("click", loadProducts);

/* =========================================
   HTML ESCAPE
========================================= */

function escapeHTML(value) {
  return String(value ?? "")
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}
