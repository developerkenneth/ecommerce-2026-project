document.addEventListener("DOMContentLoaded", () => {
  const profileTrigger = document.getElementById("profileTrigger");

  const profileMenu = document.getElementById("profileMenu");

  const mobileMenuBtn = document.getElementById("mobileMenuBtn");

  const sellerSidebar = document.getElementById("sellerSidebar");

  const mobileOverlay = document.getElementById("mobileOverlay");

  if (profileTrigger && profileMenu) {
    profileTrigger.addEventListener("click", (event) => {
      event.stopPropagation();

      profileMenu.classList.toggle("open");
    });

    document.addEventListener("click", (event) => {
      if (
        !profileMenu.contains(event.target) &&
        !profileTrigger.contains(event.target)
      ) {
        profileMenu.classList.remove("open");
      }
    });
  }

  function closeSidebar() {
    if (sellerSidebar) {
      sellerSidebar.classList.remove("mobile-open");
    }

    if (mobileOverlay) {
      mobileOverlay.classList.remove("open");
    }
  }

  if (mobileMenuBtn && sellerSidebar) {
    mobileMenuBtn.addEventListener("click", () => {
      sellerSidebar.classList.toggle("mobile-open");

      if (mobileOverlay) {
        mobileOverlay.classList.toggle("open");
      }
    });
  }

  if (mobileOverlay) {
    mobileOverlay.addEventListener("click", closeSidebar);
  }

  if (sellerSidebar) {
    sellerSidebar.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", closeSidebar);
    });
  }

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      if (profileMenu) {
        profileMenu.classList.remove("open");
      }

      closeSidebar();
    }
  });
});
