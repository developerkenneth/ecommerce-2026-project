const form = document.getElementById("addProductForm");
const responseMessage = document.getElementById("responseMessage");

const imageInput = document.getElementById("imageInput");
const previewContainer = document.getElementById("previewContainer");
const dropArea = document.getElementById("dropArea");

// ========================================
// IMAGE PREVIEW
// ========================================

let selectedFiles = [];

imageInput.addEventListener("change", function () {
  selectedFiles = Array.from(this.files);

  showImagePreviews();
});

function showImagePreviews() {
  previewContainer.innerHTML = "";

  selectedFiles.forEach((file, index) => {
    if (!file.type.startsWith("image/")) {
      return;
    }

    const reader = new FileReader();

    reader.onload = function (event) {
      const previewCard = document.createElement("div");

      previewCard.className = "preview-card";

      previewCard.innerHTML = `
                <img src="${event.target.result}" alt="Product image">

                <button
                    type="button"
                    class="remove-btn"
                    data-index="${index}">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="preview-footer">
                    ${file.name}
                </div>
            `;

      previewContainer.appendChild(previewCard);
    };

    reader.readAsDataURL(file);
  });
}

// ========================================
// REMOVE IMAGE
// ========================================

previewContainer.addEventListener("click", function (e) {
  const button = e.target.closest(".remove-btn");

  if (!button) {
    return;
  }

  const index = Number(button.dataset.index);

  selectedFiles.splice(index, 1);

  updateFileInput();

  showImagePreviews();
});

function updateFileInput() {
  const dataTransfer = new DataTransfer();

  selectedFiles.forEach((file) => {
    dataTransfer.items.add(file);
  });

  imageInput.files = dataTransfer.files;
}

// ========================================
// DRAG & DROP
// ========================================

dropArea.addEventListener("dragover", function (e) {
  e.preventDefault();

  dropArea.classList.add("dragging");
});

dropArea.addEventListener("dragleave", function () {
  dropArea.classList.remove("dragging");
});

dropArea.addEventListener("drop", function (e) {
  e.preventDefault();

  dropArea.classList.remove("dragging");

  const files = Array.from(e.dataTransfer.files);

  selectedFiles = files.filter((file) =>
    ["image/jpeg", "image/png", "image/jpg"].includes(file.type),
  );

  updateFileInput();

  showImagePreviews();
});

// ========================================
// FORM SUBMISSION
// ========================================

form.addEventListener("submit", addProduct);

async function addProduct(e) {
  e.preventDefault();

  let errors = [];

  // ========================================
  // GET FORM VALUES
  // ========================================

  const name = form.elements["name"].value.trim();
  const category = form.elements["category"].value;
  const brand = form.elements["brand"].value.trim();
  const price = form.elements["price"].value;
  const discount = form.elements["discount_percentage"].value;
  const stocks = form.elements["stocks_available"].value;
  const description = form.elements["description"].value.trim();

  // ========================================
  // VALIDATION
  // ========================================

  if (name === "") {
    errors.push("Product name is required.");
  }

  if (name.length > 0 && name.length < 3) {
    errors.push("Product name must be at least 3 characters.");
  }

  if (category === "" || category === "Select Category") {
    errors.push("Please select a category.");
  }

  if (brand === "") {
    errors.push("Brand is required.");
  }

  if (price === "") {
    errors.push("Price is required.");
  }

  if (Number(price) < 0.5) {
    errors.push("Price cannot be less than ₦0.50.");
  }

  if (stocks === "") {
    errors.push("Stock quantity is required.");
  }

  if (Number(stocks) < 1) {
    errors.push("Stock quantity must be at least 1.");
  }

  if (description === "") {
    errors.push("Product description is required.");
  }

  if (selectedFiles.length === 0) {
    errors.push("Please upload at least one product image.");
  }

  // ========================================
  // SHOW VALIDATION ERRORS
  // ========================================

  if (errors.length > 0) {
    responseMessage.innerHTML = `
            <div class="error">
                ${errors.map((error) => `<p>${error}</p>`).join("")}
            </div>
        `;

    return;
  }

  // ========================================
  // LOADING
  // ========================================

  responseMessage.innerHTML = `
        <div class="loading">
            Adding product...
        </div>
    `;

  const submitButton = document.getElementById("sumit-btn");

  submitButton.disabled = true;

  submitButton.textContent = "Adding Product...";

  // ========================================
  // FORM DATA
  // ========================================

  const formData = new FormData(form);

  try {
    const response = await fetch(
      "http://localhost/fullprojectv1/api/products.php",
      {
        method: "POST",
        body: formData,
      },
    );

    const data = await response.json();

    console.log("API response:", data);

    // ========================================
    // SUCCESS
    // ========================================

    if (response.ok && data.success) {
      responseMessage.innerHTML = `
                <div class="success">
                    ${data.message}
                </div>
            `;

      form.reset();

      selectedFiles = [];

      previewContainer.innerHTML = "";

      return;
    }

    // ========================================
    // API ERROR
    // ========================================

    let errorHTML = "";

    if (data.errors) {
      if (Array.isArray(data.errors)) {
        errorHTML = data.errors.map((error) => `<p>${error}</p>`).join("");
      } else {
        errorHTML = Object.values(data.errors)
          .map((error) => `<p>${error}</p>`)
          .join("");
      }
    } else {
      errorHTML = `<p>${data.message || "Unable to create product."}</p>`;
    }

    responseMessage.innerHTML = `
            <div class="error">
                ${errorHTML}
            </div>
        `;
  } catch (error) {
    console.error("Product creation error:", error);

    responseMessage.innerHTML = `
            <div class="error">
                <p>
                   Could not connect to the product API.
                </p>

                <p>
                    Check that Apache is running and that the API URL is correct.
                </p>
            </div>
        `;
  } finally {
    submitButton.disabled = false;

    submitButton.textContent = "Add Product";
  }
}
