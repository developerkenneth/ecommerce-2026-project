// Get the form and response container
const form = document.getElementById("addProductForm");
const responseMessage = document.getElementById("responseMessage");

// Listen for form submission
form.addEventListener("submit", addProduct);
async function addProduct(e) {
  e.preventDefault();
  let error = "";
  // Get all form data
  const formData = new FormData(form);
  const formObject = Object.fromEntries(formData);
  // Validation
  Object.entries(formObject).forEach(([field, value]) => {
    if (typeof value === "string" && value.trim() === "") {
      error += `${field} cannot be empty.<br>`;
    }
  });

  if (formObject.name && formObject.name.trim().length < 3) {
    error += "Product name must be at least 3 characters long.<br>";
  }
  // Stop if there are validation errors
  if (error !== "") {
    responseMessage.innerHTML = `
      <div class="error">
        ${error}
      </div>
    `;
    return;
  }

  // Show loading message
  responseMessage.innerHTML = `
    <div class="loading">
      Adding product...
    </div>
  `;

  try {
    const response = await fetch(
      "http://localhost/fullprojectv1/api/products.php",
      {
        method: "POST",
        body: formData,
      },
    );

    const data = await response.json();

    if (data.success) {
      responseMessage.innerHTML = `
        <div class="success">
          ${data.message}
        </div>
      `;

      form.reset();
    } else {
      let html = "";

      if (data.errors) {
        Object.values(data.errors).forEach((err) => {
          html += `<p>${err}</p>`;
        });
      } else {
        html = `<p>${data.message}</p>`;
      }

      responseMessage.innerHTML = `
        <div class="error">
          ${html}
        </div>
      `;
    }
  } catch (err) {
    console.error(err);

    responseMessage.innerHTML = `
      <div class="error">
        Something went wrong while sending your request.
      </div>
    `;
  }
}
