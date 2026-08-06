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

// toggle for the dark mood
const themeButton = document.getElementById("themeToggle");

const savedTheme = localStorage.getItem("admin-theme");

if (savedTheme === "dark") {
  document.body.classList.add("dark-theme");
}

themeButton.addEventListener("click", () => {
  document.body.classList.toggle("dark-theme");

  const darkMode = document.body.classList.contains("dark-theme");

  localStorage.setItem("admin-theme", darkMode ? "dark" : "light");

  themeButton.innerHTML = darkMode
    ? '<i class="fa-solid fa-sun"></i>'
    : '<i class="fa-solid fa-moon"></i>';
});

//  this is for the chart box

const revenueChart = document.getElementById("revenueChart");

if (revenueChart) {
  new Chart(revenueChart, {
    type: "line",

    data: {
      labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],

      datasets: [
        {
          label: "Revenue",

          data: [
            3200000, 4100000, 5000000, 6300000, 7200000, 6800000, 8100000,
            9300000, 10100000, 11000000, 11800000, 12800000,
          ],

          borderColor: "#ff6b00",

          backgroundColor: "rgba(255,107,0,.12)",

          fill: true,

          borderWidth: 4,

          pointRadius: 5,

          pointHoverRadius: 8,

          tension: 0.4,
        },
      ],
    },

    options: {
      responsive: true,

      maintainAspectRatio: false,

      plugins: {
        legend: {
          display: false,
        },
      },

      interaction: {
        intersect: false,
        mode: "index",
      },

      scales: {
        y: {
          beginAtZero: true,

          ticks: {
            callback: function (value) {
              return "₦" + value / 1000000 + "M";
            },
          },
        },
      },
    },
  });
}
