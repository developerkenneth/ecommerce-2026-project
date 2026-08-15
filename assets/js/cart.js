document.addEventListener("DOMContentLoaded", () => {
  const API_URL = "./api/cart.php";

  const cartLoading = document.getElementById("cartLoading");
  const cartError = document.getElementById("cartError");
  const cartErrorMessage = document.getElementById("cartErrorMessage");
  const emptyCart = document.getElementById("emptyCart");
  const cartLayout = document.getElementById("cartLayout");
  const cartItems = document.getElementById("cartItems");
  const cartItemCount = document.getElementById("cartItemCount");
  const cartProductsCount = document.getElementById("cartProductsCount");
  const summaryItems = document.getElementById("summaryItems");
  const summarySubtotal = document.getElementById("summarySubtotal");
  const summaryTotal = document.getElementById("summaryTotal");
  const clearCartBtn = document.getElementById("clearCartBtn");
  const retryCartBtn = document.getElementById("retryCartBtn");
  const checkoutBtn = document.getElementById("checkoutBtn");

  loadCart();

  async function loadCart() {
    showLoading();

    try {
      const response = await fetch(API_URL, {
        method: "GET",
        headers: {
          Accept: "application/json",
        },
        credentials: "include",
      });

      const text = await response.text();

      console.log("CART API STATUS:", response.status);
      console.log("CART API RESPONSE:", text);

      let data;

      try {
        data = JSON.parse(text);
      } catch (error) {
        throw new Error("Cart API returned invalid JSON.");
      }

      if (response.status === 401) {
        showError(data.message || "Please login to view your cart.");

        return;
      }

      if (!response.ok || !data.success) {
        throw new Error(data.message || "Unable to load cart.");
      }

      console.log("CART DATA:", data.cart);

      renderCart(data.cart);
    } catch (error) {
      console.error("Cart loading error:", error);

      showError(error.message || "Something went wrong.");
    }
  }

  function renderCart(cart) {
    const items = Array.isArray(cart?.items) ? cart.items : [];

    const totalItems = Number(cart?.total_items || 0);

    const subtotal = Number(cart?.subtotal || 0);

    console.log("CART ITEMS:", items);

    if (items.length === 0) {
      showEmpty();

      updateSummary(0, 0);

      cartItemCount.textContent = "Your cart is empty";

      cartProductsCount.textContent = "0 products";

      return;
    }

    hideElement(cartLoading);
    hideElement(cartError);
    hideElement(emptyCart);
    showElement(cartLayout);

    cartItems.innerHTML = "";

    items.forEach((item) => {
      const itemElement = createCartItem(item);

      cartItems.appendChild(itemElement);
    });

    cartItemCount.textContent = `${totalItems} ${
      totalItems === 1 ? "item" : "items"
    } in your cart`;

    cartProductsCount.textContent = `${items.length} ${
      items.length === 1 ? "product" : "products"
    }`;

    updateSummary(totalItems, subtotal);
  }

  function createCartItem(item) {
    const article = document.createElement("article");

    article.className = "cart-item";

    const photo = getFirstPhoto(item.photos);

    const quantity = Number(item.quantity || 1);

    const unitPrice = Number(item.unit_price || 0);

    const lineTotal = Number(item.line_total || unitPrice * quantity);

    const originalPrice = Number(item.price || 0);

    const discount = Number(item.discount_percentage || 0);

    let oldPriceHtml = "";

    if (discount > 0) {
      oldPriceHtml = `
                <del class="cart-item-old-price">
                    ${formatCurrency(originalPrice)}
                </del>
            `;
    }

    article.innerHTML = `

            <div class="cart-item-image">

                <img
                    src="${photo}"
                    alt="${escapeHtml(item.name || "Product")}"
                >

            </div>


            <div class="cart-item-info">

                <span class="cart-item-category">
                    ${escapeHtml(item.category || "Product")}
                </span>


                <h3 class="cart-item-name">

                    ${escapeHtml(item.name || "Unnamed Product")}

                </h3>


                <p class="cart-item-brand">

                    ${escapeHtml(item.brand || "No brand")}

                </p>


                <div class="cart-item-price">

                    ${formatCurrency(unitPrice)}

                    ${oldPriceHtml}

                </div>


                <div class="cart-item-controls">


                    <div
                        class="quantity-control"
                    >

                        <button
                            type="button"
                            class="decrease-btn"
                        >
                            -
                        </button>


                        <input
                            type="text"
                            value="${quantity}"
                            readonly
                        >


                        <button
                            type="button"
                            class="increase-btn"
                        >
                            +
                        </button>

                    </div>


                    <button
                        type="button"
                        class="remove-item-btn"
                    >
                        Remove
                    </button>


                </div>

            </div>


            <div class="cart-item-total">

                <small>
                    Total
                </small>

                <strong>
                    ${formatCurrency(lineTotal)}
                </strong>

            </div>

        `;

    const decrease = article.querySelector(".decrease-btn");

    const increase = article.querySelector(".increase-btn");

    const remove = article.querySelector(".remove-item-btn");

    decrease.addEventListener("click", () => {
      const newQuantity = quantity - 1;

      if (newQuantity < 1) {
        removeItem(item.product_uuid);

        return;
      }

      updateQuantity(item.product_uuid, newQuantity);
    });

    increase.addEventListener("click", () => {
      updateQuantity(item.product_uuid, quantity + 1);
    });

    remove.addEventListener("click", () => {
      removeItem(item.product_uuid);
    });

    return article;
  }

  async function updateQuantity(productUuid, quantity) {
    try {
      const response = await fetch(API_URL, {
        method: "PUT",

        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },

        credentials: "include",

        body: JSON.stringify({
          product_uuid: productUuid,

          quantity: quantity,
        }),
      });

      const data = await response.json();

      if (!response.ok || !data.success) {
        throw new Error(data.message || "Unable to update quantity.");
      }

      await loadCart();
    } catch (error) {
      console.error("Quantity update error:", error);

      alert(error.message);
    }
  }

  async function removeItem(productUuid) {
    try {
      const response = await fetch(API_URL, {
        method: "DELETE",

        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },

        credentials: "include",

        body: JSON.stringify({
          product_uuid: productUuid,
        }),
      });

      const data = await response.json();

      if (!response.ok || !data.success) {
        throw new Error(data.message || "Unable to remove product.");
      }

      await loadCart();
    } catch (error) {
      console.error("Remove cart item error:", error);

      alert(error.message);
    }
  }

  if (clearCartBtn) {
    clearCartBtn.addEventListener("click", clearCart);
  }

  async function clearCart() {
    const confirmed = confirm("Are you sure you want to clear your cart?");

    if (!confirmed) {
      return;
    }

    try {
      const response = await fetch(`${API_URL}?clear=1`, {
        method: "DELETE",
        headers: {
          Accept: "application/json",
        },
        credentials: "include",
      });

      const data = await response.json();

      if (!response.ok || !data.success) {
        throw new Error(data.message || "Unable to clear cart.");
      }

      await loadCart();
    } catch (error) {
      console.error("Clear cart error:", error);

      alert(error.message);
    }
  }

  if (checkoutBtn) {
    checkoutBtn.addEventListener("click", () => {
      window.location.href = "./checkout.php";
    });
  }

  if (retryCartBtn) {
    retryCartBtn.addEventListener("click", loadCart);
  }

  function showLoading() {
    showElement(cartLoading);

    hideElement(cartError);
    hideElement(emptyCart);
    hideElement(cartLayout);
  }

  function showEmpty() {
    hideElement(cartLoading);
    hideElement(cartError);
    showElement(emptyCart);
    hideElement(cartLayout);
  }

  function showError(message) {
    hideElement(cartLoading);
    hideElement(emptyCart);
    hideElement(cartLayout);
    showElement(cartError);

    if (cartErrorMessage) {
      cartErrorMessage.textContent = message || "Something went wrong.";
    }
  }

  function showElement(element) {
    if (!element) {
      return;
    }

    element.hidden = false;
  }

  function hideElement(element) {
    if (!element) {
      return;
    }

    element.hidden = true;
  }

  function updateSummary(totalItems, subtotal) {
    if (summaryItems) {
      summaryItems.textContent = totalItems;
    }

    if (summarySubtotal) {
      summarySubtotal.textContent = formatCurrency(subtotal);
    }

    if (summaryTotal) {
      summaryTotal.textContent = formatCurrency(subtotal);
    }
  }

  function getFirstPhoto(photos) {
    let list = [];

    if (Array.isArray(photos)) {
      list = photos;
    } else if (typeof photos === "string") {
      try {
        list = JSON.parse(photos);
      } catch (error) {
        console.error("Could not parse product photos:", error);

        list = [];
      }
    }

    if (!Array.isArray(list) || list.length === 0) {
      return "./assets/images/no-image.png";
    }

    return `./assets/photos/${list[0]}`;
  }

  function formatCurrency(amount) {
    return new Intl.NumberFormat("en-NG", {
      style: "currency",
      currency: "NGN",
    }).format(Number(amount || 0));
  }

  function escapeHtml(value) {
       div = document.createElement("div");

    div.textContent = value ?? "";

    return div.innerHTML;
  }
});
