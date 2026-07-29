

const form = document.querySelector("form");
form.addEventListener("submit", (e) => {
  e.preventDefault();

  let error = "";
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