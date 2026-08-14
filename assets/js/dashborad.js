document.addEventListener("DOMContentLoaded", () => {
  const API_URL = "./api/products.php";

  const totalProducts = document.getElementById("totalProducts");

  const totalInventory = document.getElementById("totalInventory");

  const inStockProducts = document.getElementById("inStockProducts");

  const outOfStockProducts = document.getElementById("outOfStockProducts");

  const inventoryProducts = document.getElementById("inventoryProducts");

  const inventoryInStock = document.getElementById("inventoryInStock");

  const inventoryOutOfStock = document.getElementById("inventoryOutOfStock");

  const productsLoading = document.getElementById("productsLoading");

  const productsError = document.getElementById("productsError");

  const productsErrorMessage = document.getElementById("productsErrorMessage");

  const productsEmpty = document.getElementById("productsEmpty");

  const productsTableWrapper = document.getElementById("productsTableWrapper");

  const recentProductsBody = document.getElementById("recentProductsBody");

  const retryProducts = document.getElementById("retryProducts");

  const addProductBtn = document.getElementById("addProductBtn");

  if (addProductBtn) {
    addProductBtn.addEventListener("click", () => {
      window.location.href = "./add.php";
    });
  }

  if (retryProducts) {
    retryProducts.addEventListener("click", loadProducts);
  }

  loadProducts();

  async function loadProducts() {
    showLoading();

    try {
      const response = await fetch(API_URL, {
        method: "GET",
        headers: {
          Accept: "application/json",
        },
      });

      const text = await response.text();

      console.log("DASHBOARD PRODUCT API:", text);

      let data;

      try {
        data = JSON.parse(text);
      } catch (error) {
        throw new Error("The products API returned invalid JSON.");
      }

      if (!response.ok || !data.success) {
        throw new Error(data.message || "Unable to load products.");
      }

      const products = Array.isArray(data.products) ? data.products : [];

      updateStats(products);

      renderRecentProducts(products);

      hideLoading();
    } catch (error) {
      console.error("Dashboard product error:", error);

      showError(error.message || "Unable to connect to the product API.");
    }
  }

  function updateStats(products) {
    const productCount = products.length;

    const inventory = products.reduce((total, product) => {
      return total + Number(product.stocks_available || 0);
    }, 0);

    const inStock = products.filter(
      (product) => Number(product.stocks_available || 0) > 0,
    ).length;

    const outOfStock = products.filter(
      (product) => Number(product.stocks_available || 0) <= 0,
    ).length;

    totalProducts.textContent = productCount;

    totalInventory.textContent = inventory;

    inStockProducts.textContent = inStock;

    outOfStockProducts.textContent = outOfStock;

    inventoryProducts.textContent = productCount;

    inventoryInStock.textContent = inStock;

    inventoryOutOfStock.textContent = outOfStock;
  }

  function renderRecentProducts(products) {
    recentProductsBody.innerHTML = "";

    if (!products.length) {
      showEmpty();

      return;
    }

    hideEmpty();

    const recentProducts = products.slice(0, 8);

    recentProducts.forEach((product) => {
      const row = document.createElement("tr");

      const image = getProductImage(product);

      const stock = Number(product.stocks_available || 0);

      const stockStatus = stock > 0 ? "In Stock" : "Out of Stock";

      const statusClass = stock > 0 ? "in-stock" : "out-stock";

      row.innerHTML = `

                    <td>

                        <div class="dashboard-product">

                            <img
                                src="${escapeHTML(image)}"
                                alt="${escapeHTML(product.name || "Product")}"
                            >

                            <div>

                                <strong>
                                    ${escapeHTML(
                                      product.name || "Unnamed product",
                                    )}
                                </strong>

                                <span>
                                    ${escapeHTML(product.brand || "No brand")}
                                </span>

                            </div>

                        </div>

                    </td>


                    <td>
                        ${escapeHTML(product.category || "General")}
                    </td>


                    <td>
                        ${formatPrice(product.price)}
                    </td>


                    <td>
                        ${stock}
                    </td>


                    <td>

                        <span
                            class="status ${statusClass}">
                            ${stockStatus}
                        </span>

                    </td>


                    <td>

                        <div class="table-actions">

                            <button
                                type="button"
                                class="action-btn view"
                                data-view-id="${escapeHTML(
                                  product.uuid || "",
                                )}">

                                <i class="fa-solid fa-eye"></i>

                            </button>


                            <button
                                type="button"
                                class="action-btn edit"
                                data-edit-id="${escapeHTML(
                                  product.uuid || "",
                                )}">

                                <i class="fa-solid fa-pen"></i>

                            </button>


                            <button
                                type="button"
                                class="action-btn delete"
                                data-delete-id="${escapeHTML(
                                  product.uuid || "",
                                )}">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </div>

                    </td>

                `;

      const viewButton = row.querySelector("[data-view-id]");

      const editButton = row.querySelector("[data-edit-id]");

      const deleteButton = row.querySelector("[data-delete-id]");

      if (viewButton) {
        viewButton.addEventListener("click", () => {
          const uuid = viewButton.dataset.viewId;

          window.location.href = `./product.php?id=${encodeURIComponent(uuid)}`;
        });
      }

      if (editButton) {
        editButton.addEventListener("click", () => {
          const uuid = editButton.dataset.editId;

          window.location.href = `./edit-product.php?id=${encodeURIComponent(uuid)}`;
        });
      }

      if (deleteButton) {
        deleteButton.addEventListener("click", () => {
          deleteProduct(product.uuid, product.name);
        });
      }

      recentProductsBody.appendChild(row);
    });
  }

  async function deleteProduct(uuid, name) {
    if (!uuid) {
      return;
    }

    const confirmed = window.confirm(
      `Delete "${name}"? This action cannot be undone.`,
    );

    if (!confirmed) {
      return;
    }

    try {
      const response = await fetch(
        `${API_URL}?id=${encodeURIComponent(uuid)}`,
        {
          method: "DELETE",
          headers: {
            Accept: "application/json",
          },
        },
      );

      const text = await response.text();

      console.log("DELETE PRODUCT RESPONSE:", text);

      let data;

      try {
        data = JSON.parse(text);
      } catch (error) {
        throw new Error("Delete API returned invalid JSON.");
      }

      if (!response.ok || !data.success) {
        throw new Error(data.message || "Unable to delete product.");
      }

      await loadProducts();
    } catch (error) {
      console.error("Delete product error:", error);

      alert(error.message || "Unable to delete product.");
    }
  }

  function getProductImage(product) {
    let photos = product.photos;

    if (typeof photos === "string") {
      try {
        photos = JSON.parse(photos);
      } catch (error) {
        photos = [];
      }
    }

    if (Array.isArray(photos) && photos.length > 0) {
      return `./assets/photos/${photos[0]}`;
    }

    return "./assets/photos/product-placeholder.png";
  }

  function formatPrice(price) {
    const amount = Number(price);

    if (Number.isNaN(amount)) {
      return "Price unavailable";
    }

    return new Intl.NumberFormat("en-NG", {
      style: "currency",
      currency: "NGN",
      maximumFractionDigits: 2,
    }).format(amount);
  }

  function escapeHTML(value) {
    return String(value ?? "")
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function showLoading() {
    productsLoading.classList.add("active");

    productsError.classList.remove("active");

    productsEmpty.classList.remove("active");

    productsTableWrapper.classList.remove("active");
  }

  function hideLoading() {
    productsLoading.classList.remove("active");

    productsError.classList.remove("active");

    productsEmpty.classList.remove("active");

    productsTableWrapper.classList.add("active");
  }

  function showEmpty() {
    productsLoading.classList.remove("active");

    productsError.classList.remove("active");

    productsTableWrapper.classList.remove("active");

    productsEmpty.classList.add("active");
  }

  function hideEmpty() {
    productsEmpty.classList.remove("active");
  }

  function showError(message) {
    productsLoading.classList.remove("active");

    productsTableWrapper.classList.remove("active");

    productsEmpty.classList.remove("active");

    productsError.classList.add("active");

    productsErrorMessage.textContent = message;
  }
});
