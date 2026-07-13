const accountBtn = document.querySelector("#account-help");
const accountMenu = document.querySelector(".account-options");

const helpBtn = document.querySelector("#help-icon");
const helpMenu = document.querySelector(".help-options");


const cartBtn = document.querySelector("#cart-icon");
const cartMenu = document.querySelector(".cart-options");

accountBtn.addEventListener("click", () => {

    // Close Help menu first
    helpMenu.classList.remove("show");

    // Toggle Account menu
    accountMenu.classList.toggle("show");
    //toggle cart menu
    cartMenu.classList.remove("show");

});

helpBtn.addEventListener("click", () => {

    // Close Account menu first
    accountMenu.classList.remove("show");

    // Toggle Help menu
    helpMenu.classList.toggle("show");
    //toggle cart menu
    cartMenu.classList.remove("show");

});

cartBtn.addEventListener("click", () => {

    // Close Account menu first
    accountMenu.classList.remove("show");
    // Close Help menu first
    helpMenu.classList.remove("show");
    // Toggle Cart menu
    cartMenu.classList.toggle("show");
});