// const progressCircle = document.querySelector(".progress-circle");
// const progressButton = document.querySelector(".scroll-progress");
// let scrollTimer;
// const radius = 30;
// const circumference = 2 * Math.PI * radius;

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

  if (productForm.get('name').length < 3) {
    error += "name should be at least 3 characters long";
  }

  if (error.length < 1) {

  }

  console.log(error);
  return;
})