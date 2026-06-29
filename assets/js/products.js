const productsContainer = document.querySelector(".products-container");
const loaderContainer = document.querySelector(".loader-container");
const maxPrice = document.querySelector(".max-price");
const outputMax = document.querySelector("#output-max");



async function fetchProducts(url) {
  try {
    const response = await fetch(url);

    const data = await response.json();
    displayProducts(data.products);

  } catch (error) {
    console.log(error);
  } finally {
    loaderContainer.classList.add("hidden");
    productsContainer.classList.remove("hidden");
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

fetchProducts("http://localhost/e-commerce.com/api/products.php");


// search functionality

const searchBar = document.querySelector(".search-bar");
const handleSearch = async (event) => {
  // get current search value
  const searchKey = event.currentTarget.value;
  // call loading state
  loaderContainer.classList.remove("hidden");

  try {
    const response = await fetchProducts(`http://localhost/e-commerce.com/api/products.php?search=${searchKey}`);
  } catch (error) {
    console.error(error);
  }

}

maxPrice.addEventListener("input", (event) => {
  const currentPrice = event.currentTarget.value;
  outputMax.innerHTML = currentPrice;
});

const handleFilter = async (e) => {
  const maxPrice = e.currentTarget.value;
  console.log(maxPrice);

  try {
    productsContainer.classList.add("hidden");
    const data = await fetchProducts(`http://localhost/e-commerce.com/api/products.php?max_price=${maxPrice}`);
  } catch (error) {
    console.error(error);
  }
}
maxPrice.addEventListener("change", handleFilter);
searchBar.addEventListener("change", handleSearch);