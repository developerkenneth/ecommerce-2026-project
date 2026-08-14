document.addEventListener("DOMContentLoaded", () => {
  const API_URL = "./api/products.php";

  const form = document.getElementById("editProductForm");

  const loading = document.getElementById("editLoading");

  const errorBox = document.getElementById("editError");

  const errorMessage = document.getElementById("editErrorMessage");

  const responseMessage = document.getElementById("editResponseMessage");

  const updateButton = document.getElementById("updateProductBtn");

  const nameInput = document.getElementById("editName");

  const categoryInput = document.getElementById("editCategory");

  const brandInput = document.getElementById("editBrand");

  const priceInput = document.getElementById("editPrice");

  const discountInput = document.getElementById("editDiscount");

  const stockInput = document.getElementById("editStock");

  const descriptionInput = document.getElementById("editDescription");

  const params = new URLSearchParams(window.location.search);

  const productUuid = params.get("id");

  if (!productUuid) {
    showError("No product ID was provided.");

    return;
  }

  loadProduct();

  async function loadProduct() {
    showLoading();

    try {
      const response = await fetch(
        `${API_URL}?id=${encodeURIComponent(productUuid)}`,
        {
          method: "GET",
          headers: {
            Accept: "application/json",
          },
        },
      );

      const text = await response.text();

      console.log("EDIT PRODUCT API:", text);

      let data;

      try {
        data = JSON.parse(text);
      } catch (error) {
        throw new Error("The product API returned invalid JSON.");
      }

      if (!response.ok || !data.success || !data.product) {
        throw new Error(data.message || "Unable to load product.");
      }

      populateForm(data.product);

      loading.style.display = "none";

      errorBox.style.display = "none";

      form.style.display = "block";
    } catch (error) {
      console.error("Edit product loading error:", error);

      showError(error.message);
    }
  }

  function populateForm(product) {
    nameInput.value = product.name || "";

    categoryInput.value = product.category || "";

    brandInput.value = product.brand || "";

    priceInput.value = product.price || "";

    discountInput.value = product.discount_percentage || 0;

    stockInput.value = product.stocks_available || "";

    descriptionInput.value = product.description || "";
  }

  form.addEventListener("submit", updateProduct);

  async function updateProduct(event) {
    event.preventDefault();

    responseMessage.textContent = "";

    const name = nameInput.value.trim();

    const category = categoryInput.value.trim();

    const brand = brandInput.value.trim();

    const price = priceInput.value.trim();

    const discount = discountInput.value.trim();

    const stock = stockInput.value.trim();

    const description = descriptionInput.value.trim();

    if (!name) {
      showResponse("Product name is required.", "error");

      nameInput.focus();

      return;
    }

    if (!category) {
      showResponse("Please select a category.", "error");

      categoryInput.focus();

      return;
    }

    if (!brand) {
      showResponse("Brand is required.", "error");

      brandInput.focus();

      return;
    }

    if (!price || Number(price) < 0.5) {
      showResponse("Price must be at least ₦0.50.", "error");

      priceInput.focus();

      return;
    }

    if (!stock || Number(stock) < 1) {
      showResponse("Stock quantity must be at least 1.", "error");

      stockInput.focus();

      return;
    }

    if (!description) {
      showResponse("Product description is required.", "error");

      descriptionInput.focus();

      return;
    }

    const payload = {
      name,
      category,
      brand,
      price: Number(price),
      discount_percentage: Number(discount || 0),
      stocks_available: Number(stock),
      description,
    };

    const originalText = updateButton.innerHTML;

    updateButton.disabled = true;

    updateButton.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin"></i>
            Saving...
        `;

    try {
      const response = await fetch(
        `${API_URL}?id=${encodeURIComponent(productUuid)}`,
        {
          method: "PUT",

          headers: {
            "Content-Type": "application/json",

            Accept: "application/json",
          },

          body: JSON.stringify(payload),
        },
      );

      const text = await response.text();

      console.log("UPDATE PRODUCT API:", text);

      let data;

      try {
        data = JSON.parse(text);
      } catch (error) {
        throw new Error("The update API returned invalid JSON.");
      }

      if (!response.ok || !data.success) {
        let message = data.message || data.error || "Unable to update product.";

        if (Array.isArray(message)) {
          message = message.join(" ");
        }

        throw new Error(message);
      }

      showResponse(data.message || "Product updated successfully.", "success");

      updateButton.innerHTML = `
                <i class="fa-solid fa-check"></i>
                Updated
            `;

      setTimeout(() => {
        window.location.href = "./dashboard.php";
      }, 900);
    } catch (error) {
      console.error("Product update error:", error);

      showResponse(error.message, "error");

      updateButton.innerHTML = originalText;

      updateButton.disabled = false;
    }
  }

  function showLoading() {
    loading.style.display = "flex";

    errorBox.style.display = "none";

    form.style.display = "none";
  }

  function showError(message) {
    loading.style.display = "none";

    form.style.display = "none";

    errorBox.style.display = "flex";

    errorMessage.textContent = message || "Something went wrong.";
  }

  function showResponse(message, type) {
    responseMessage.textContent = message;

    responseMessage.className = `edit-response ${type}`;
  }
});
