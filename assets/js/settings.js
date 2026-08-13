document.addEventListener("DOMContentLoaded", function () {
  /* ==========================================
       SETTINGS NAVIGATION
    ========================================== */

  const navLinks = document.querySelectorAll(".settings-nav a[data-section]");

  const sections = document.querySelectorAll(".settings-section");

  function showSection(sectionId) {
    if (!sectionId) {
      return;
    }

    sections.forEach(function (section) {
      section.classList.remove("active");
    });

    navLinks.forEach(function (link) {
      link.classList.remove("active");
    });

    const targetSection = document.getElementById(sectionId);

    const activeLink = document.querySelector(
      '.settings-nav a[data-section="' + sectionId + '"]',
    );

    if (targetSection) {
      targetSection.classList.add("active");
    }

    if (activeLink) {
      activeLink.classList.add("active");
    }
  }

  navLinks.forEach(function (link) {
    link.addEventListener("click", function (event) {
      event.preventDefault();

      const sectionId = link.getAttribute("data-section");

      showSection(sectionId);

      window.history.replaceState(null, "", "#" + sectionId);
    });
  });

  const currentSection = window.location.hash.replace("#", "");

  if (currentSection && document.getElementById(currentSection)) {
    showSection(currentSection);
  } else {
    showSection("profile");
  }

  /* ==========================================
       PROFILE IMAGE PREVIEW
    ========================================== */

  const imageInput = document.getElementById("profileImageInput");

  const profilePreview = document.getElementById("profilePreview");

  if (imageInput && profilePreview) {
    imageInput.addEventListener("change", function (event) {
      const file = event.target.files[0];

      if (!file) {
        return;
      }

      const allowedTypes = ["image/jpeg", "image/png", "image/webp"];

      if (!allowedTypes.includes(file.type)) {
        alert("Please select a JPG, PNG or WebP image.");

        imageInput.value = "";

        return;
      }

      if (file.size > 5 * 1024 * 1024) {
        alert("Image must be smaller than 5MB.");

        imageInput.value = "";

        return;
      }

      const reader = new FileReader();

      reader.onload = function (event) {
        profilePreview.src = event.target.result;
      };

      reader.readAsDataURL(file);
    });
  }

  /* ==========================================
       PROFILE SAVE
    ========================================== */

  const saveProfile = document.getElementById("saveProfile");

  if (saveProfile) {
    saveProfile.addEventListener("click", function () {
      const fullNameElement = document.getElementById("fullName");

      const usernameElement = document.getElementById("username");

      const emailElement = document.getElementById("email");

      const phoneElement = document.getElementById("phone");

      const countryElement = document.getElementById("country");

      const cityElement = document.getElementById("city");

      const fullName = fullNameElement ? fullNameElement.value.trim() : "";

      const username = usernameElement ? usernameElement.value.trim() : "";

      const email = emailElement ? emailElement.value.trim() : "";

      const phone = phoneElement ? phoneElement.value.trim() : "";

      const country = countryElement ? countryElement.value.trim() : "";

      const city = cityElement ? cityElement.value.trim() : "";

      if (!fullName) {
        alert("Please enter your full name.");

        return;
      }

      if (!username) {
        alert("Please enter your username.");

        return;
      }

      if (!email) {
        alert("Please enter your email address.");

        return;
      }

      const profile = {
        fullName: fullName,
        username: username,
        email: email,
        phone: phone,
        country: country,
        city: city,
      };

      const originalText = saveProfile.innerHTML;

      saveProfile.disabled = true;

      saveProfile.innerHTML =
        '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

      localStorage.setItem("gabs_profile", JSON.stringify(profile));

      setTimeout(function () {
        saveProfile.innerHTML = '<i class="fa-solid fa-check"></i> Saved';

        setTimeout(function () {
          saveProfile.innerHTML = originalText;

          saveProfile.disabled = false;
        }, 1500);
      }, 700);
    });
  }

  /* ==========================================
       LOAD PROFILE
    ========================================== */

  const savedProfile = localStorage.getItem("gabs_profile");

  if (savedProfile) {
    try {
      const profile = JSON.parse(savedProfile);

      const fields = {
        fullName: profile.fullName,
        username: profile.username,
        email: profile.email,
        phone: profile.phone,
        country: profile.country,
        city: profile.city,
      };

      Object.keys(fields).forEach(function (id) {
        const element = document.getElementById(id);

        if (element) {
          element.value = fields[id] || "";
        }
      });
    } catch (error) {
      console.error("Unable to load saved profile:", error);
    }
  }

  /* ==========================================
       THEME
    ========================================== */

  const themeButtons = document.querySelectorAll(".theme-btn[data-theme]");

  function applyTheme(theme) {
    if (theme === "dark") {
      document.body.classList.add("dark-theme");
    } else if (theme === "light") {
      document.body.classList.remove("dark-theme");
    } else {
      const prefersDark = window.matchMedia(
        "(prefers-color-scheme: dark)",
      ).matches;

      document.body.classList.toggle("dark-theme", prefersDark);
    }
  }

  let savedTheme = localStorage.getItem("gabs_theme");

  if (!savedTheme) {
    savedTheme = "light";
  }

  applyTheme(savedTheme);

  themeButtons.forEach(function (button) {
    if (button.getAttribute("data-theme") === savedTheme) {
      button.classList.add("active");
    } else {
      button.classList.remove("active");
    }

    button.addEventListener("click", function () {
      const theme = button.getAttribute("data-theme");

      localStorage.setItem("gabs_theme", theme);

      themeButtons.forEach(function (btn) {
        btn.classList.remove("active");
      });

      button.classList.add("active");

      applyTheme(theme);
    });
  });

  /* ==========================================
       NOTIFICATIONS
    ========================================== */

  const notificationInputs = document.querySelectorAll(
    "#notifications input[type='checkbox']",
  );

  notificationInputs.forEach(function (input) {
    if (!input.id) {
      return;
    }

    const storageKey = "gabs_" + input.id;

    const saved = localStorage.getItem(storageKey);

    if (saved !== null) {
      input.checked = saved === "true";
    }

    input.addEventListener("change", function () {
      localStorage.setItem(storageKey, input.checked);
    });
  });

  /* ==========================================
       LANGUAGE / REGION
    ========================================== */

  const language = document.getElementById("languageSelect");

  const currency = document.getElementById("currencySelect");

  const timezone = document.getElementById("timezoneSelect");

  const saveRegion = document.getElementById("saveRegion");

  if (language) {
    const savedLanguage = localStorage.getItem("gabs_language");

    if (savedLanguage) {
      language.value = savedLanguage;
    }
  }

  if (currency) {
    const savedCurrency = localStorage.getItem("gabs_currency");

    if (savedCurrency) {
      currency.value = savedCurrency;
    }
  }

  if (timezone) {
    const savedTimezone = localStorage.getItem("gabs_timezone");

    if (savedTimezone) {
      timezone.value = savedTimezone;
    }
  }

  if (saveRegion) {
    saveRegion.addEventListener("click", function () {
      if (language) {
        localStorage.setItem("gabs_language", language.value);
      }

      if (currency) {
        localStorage.setItem("gabs_currency", currency.value);
      }

      if (timezone) {
        localStorage.setItem("gabs_timezone", timezone.value);
      }

      const originalText = saveRegion.innerHTML;

      saveRegion.innerHTML =
        '<i class="fa-solid fa-check"></i> Preferences Saved';

      setTimeout(function () {
        saveRegion.innerHTML = originalText;
      }, 1500);
    });
  }

  /* ==========================================
       CHANGE PASSWORD
    ========================================== */

  const changePassword = document.getElementById("changePasswordBtn");

  if (changePassword) {
    changePassword.addEventListener("click", function () {
      alert("Password change will be connected to the authentication API.");
    });
  }

  /* ==========================================
       TWO FACTOR AUTHENTICATION
    ========================================== */

  const twoFactor = document.getElementById("twoFactorBtn");

  if (twoFactor) {
    twoFactor.addEventListener("click", function () {
      alert("Two-factor authentication will be connected to the security API.");
    });
  }

  /* ==========================================
       ADD PAYMENT
    ========================================== */

  const addPayment = document.getElementById("addPayment");

  if (addPayment) {
    addPayment.addEventListener("click", function () {
      alert("Payment method integration will be connected later.");
    });
  }

  /* ==========================================
       REMOVE PAYMENT / OTHER REMOVE BUTTONS
    ========================================== */

  const removeButtons = document.querySelectorAll(".remove-btn");

  removeButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      const confirmed = confirm("Are you sure you want to remove this item?");

      if (!confirmed) {
        return;
      }

      const paymentBox = button.closest(".payment-box");

      if (paymentBox) {
        paymentBox.remove();

        return;
      }

      const apiKeyItem = button.closest(".api-key-item");

      if (apiKeyItem) {
        apiKeyItem.remove();

        return;
      }
    });
  });

  /* ==========================================
       DANGER ZONE
    ========================================== */

  const dangerButtons = document.querySelectorAll(".danger-btn");

  dangerButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      const buttonText = button.textContent.trim();

      if (buttonText.includes("Delete")) {
        const confirmed = confirm(
          "Are you sure you want to delete your account? This action cannot be undone.",
        );

        if (!confirmed) {
          return;
        }

        alert("Account deletion will be connected to the backend.");
      } else {
        const confirmed = confirm(
          "Are you sure you want to deactivate your account?",
        );

        if (!confirmed) {
          return;
        }

        alert("Account deactivation will be connected to the backend.");
      }
    });
  });
});
