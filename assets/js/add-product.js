// Get the form and response container
const form = document.getElementById("addProductForm");
const responseMessage = document.getElementById("responseMessage");

<<<<<<< HEAD
// Listen for form submission
form.addEventListener("submit", addProduct);
async function addProduct(e) {
=======
// progressCircle.style.strokeDasharray = circumference;

// window.addEventListener("scroll", () => {
//   const scrollTop = window.scrollY;

//   const pageHeight = document.documentElement.scrollHeight - window.innerHeight;

//   const progress = scrollTop / pageHeight;

//   const offset = circumference - progress * circumference;

//   progressCircle.style.strokeDashoffset = offset;

//   // Show after scrolling down a little
//   if (scrollTop > 150) {
//     progressButton.classList.add("show");
//   } else {
//     progressButton.classList.remove("show");
//   }
// });

// progressButton.addEventListener("click", () => {
//   window.scrollTo({
//     top: 0,

//     behavior: "smooth",
//   });
// });

// // typerwitering animation

// const sentences = [
//   "Sell Faster And Efficiency..",
//   "Reach More Customers..",
//   "Grow Your Business..",
//   "Manage Everything Easily..",
// ];

// const typing = document.getElementById("typing");

// let sentenceIndex = 0;
// let letterIndex = 0;
// let deleting = false;

// function type() {
//   const current = sentences[sentenceIndex];

//   if (!deleting) {
//     typing.textContent = current.substring(0, letterIndex);

//     letterIndex++;

//     if (letterIndex > current.length) {
//       deleting = true;

//       setTimeout(type, 1800);

//       return;
//     }
//   } else {
//     typing.textContent = current.substring(0, letterIndex);

//     letterIndex--;

//     if (letterIndex < 0) {
//       deleting = false;

//       sentenceIndex++;

//       if (sentenceIndex >= sentences.length) {
//         sentenceIndex = 0;
//       }
//     }
//   }

//   setTimeout(type, deleting ? 45 : 80);
// }

// type();

// handle submission

const form = document.querySelector("form");
form.addEventListener("submit", (e) => {
>>>>>>> gabriel
  e.preventDefault();
  let error = "";
<<<<<<< HEAD
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
=======
  const productForm = new FormData(form);
  const formObect = Object.fromEntries(productForm);

  Object.entries(formObect).forEach((fields) => {
    if (typeof fields[1] === "string") {
      if (fields[1].length < 1) {
        error += `${fields[0]} cannot be empty, `;
      }
    }
  });

  if (productForm.get("name").length < 3) {
    error += "name should be at least 3 characters long";
  }

  if (error.length < 1) {
  }

console.log(error);
  return;
});

const imageInput = document.getElementById("imageInput");
const previewContainer = document.getElementById("previewContainer");

imageInput.addEventListener("change", previewImages);

function previewImages() {
  previewContainer.innerHTML = "";

  const files = imageInput.files;

  for (const file of files) {
    const imageURL = URL.createObjectURL(file);

    const card = document.createElement("div");
    card.className = "preview-card";

    card.innerHTML = `
            <button type="button" class="remove-btn">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <img src="${imageURL}" alt="${file.name}">

            <div class="preview-footer">
                <span>${file.name}</span>
            </div>
        `;

    previewContainer.appendChild(card);
  }
}
>>>>>>> gabriel
