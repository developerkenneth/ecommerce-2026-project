const productsContainer = document.querySelector(".products-container");

async function fetchProducts() {
  try {
    const response = await fetch("http://localhost/e-commerce.com/api/products.php");

    const data = await response.json();
    displayProducts(data.products);

  } catch (error) {
    console.log(error);
  }
}

function displayProducts(products) {
  productsContainer.innerHTML = "";

  products.forEach((product) => {
    productsContainer.innerHTML += `

      <div class="product-card">

        <img src="${product.image}" alt="">

        <div class="product-info">

          <h2>${product.name}</h2>

          <p>$${product.price}</p>

          <button onclick="addToCart('${product.uuid}')">
            Add To Cart
          </button>

        </div>

      </div>

    `;
  });
}

async function addToCart(id) {
  const response = await fetch(`http://localhost/e-commerce.com/api/products.php?id=${id}`);

  const data = await response.json();

  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  cart.push(data.product);

  localStorage.setItem("cart", JSON.stringify(cart));

  alert("Product added to cart");
}

fetchProducts();
