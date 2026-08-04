const notificationBtn = document.querySelector(".notification-btn");

const notificationDropdown = document.querySelector(".admin-dropdown");

notificationBtn.addEventListener("click", () => {
  notificationDropdown.classList.toggle("active");
});

document.addEventListener("click", (e) => {
  if (!notificationDropdown.contains(e.target)) {
    notificationDropdown.classList.remove("active");
  }
});

// toggle for the dark mood 
const darkMood = document.getElementById("themeToggle");
