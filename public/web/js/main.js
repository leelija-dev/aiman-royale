$(document).ready(function () {
  var secondOwl;
  var mainOwl;
  var bannerOwl; // New variable for banner carousel

  function initCarousels() {
    var width = $(window).width();

    // Initialize or re-initialize banner carousel (for screens < 992px)
    if ($(".banner-carousel").length) {
      if (bannerOwl) {
        $(".banner-carousel")
          .trigger("destroy.owl.carousel")
          .removeClass("owl-loaded")
          .find(".owl-stage-outer")
          .children()
          .unwrap();
      }

      // Only initialize if screen width is less than 992px
      if (width < 992) {
        bannerOwl = $(".banner-carousel").owlCarousel({
          loop: true,
          margin: 10,
          nav: true,
          navText: [
            '<i class="fas fa-chevron-left"></i>',
            '<i class="fas fa-chevron-right"></i>',
          ],
          dots: true,
          autoplay: true,
          autoplayTimeout: 4000,
          autoplayHoverPause: true,
          items: 1,
          responsive: {
            0: { items: 1, margin: 10 },
            768: { items: 1, margin: 20 },
          },
        });
      } else {
        // Destroy if exists and screen is desktop
        if (bannerOwl) {
          $(".banner-carousel")
            .trigger("destroy.owl.carousel")
            .removeClass("owl-loaded")
            .find(".owl-stage-outer")
            .children()
            .unwrap();
          bannerOwl = null;
        }
      }
    }

    // Initialize or re-initialize .second-owl (dots always true in your current setup)
    if ($(".second-owl").length) {
      if (secondOwl) {
        $(".second-owl")
          .trigger("destroy.owl.carousel")
          .removeClass("owl-loaded")
          .find(".owl-stage-outer")
          .children()
          .unwrap();
      }
      secondOwl = $(".second-owl").owlCarousel({
        loop: true,
        margin: 24,
        navText: [
          '<i class="fas fa-chevron-left"></i>',
          '<i class="fas fa-chevron-right"></i>',
        ],
        dots: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
          0: { items: 1 },
          550: { items: 2 },
          1000: { items: 2 },
          1200: { items: 3 },
        },
      });
    }

    // Initialize or re-initialize .main-owl (nav always true in your current setup)
    if ($(".main-owl").length) {
      if (mainOwl) {
        $(".main-owl")
          .trigger("destroy.owl.carousel")
          .removeClass("owl-loaded")
          .find(".owl-stage-outer")
          .children()
          .unwrap();
      }
      mainOwl = $(".main-owl").owlCarousel({
        loop: true,
        margin: 24,
        nav: true,
        navText: [
          '<i class="fas fa-chevron-left"></i>',
          '<i class="fas fa-chevron-right"></i>',
        ],
        dots: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
          0: { items: 1, margin: 10 },
          450: { items: 2, margin: 16 },
          768: { items: 3, margin: 20 },
          1024: { items: 4 },
          1280: { items: 5 },
        },
      });
    }
  }

  // Initial initialization
  initCarousels();

  // Re-initialize on window resize (with debounce to avoid too many calls)
  var resizeTimer;
  $(window).on("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(initCarousels, 300);
  });
});

// Mobile menu toggle
const mobileMenuBtn = document.getElementById("mobile-menu-btn");
const closeSidebarBtn = document.getElementById("close-sidebar-btn");
const sidebar = document.getElementById("mobile-sidebar");
const overlay = document.getElementById("sidebar-overlay");

mobileMenuBtn.addEventListener("click", () => {
  sidebar.classList.remove("-translate-x-full");
  overlay.classList.remove("hidden");
});

closeSidebarBtn.addEventListener("click", () => {
  sidebar.classList.add("-translate-x-full");
  overlay.classList.add("hidden");
});

overlay.addEventListener("click", () => {
  sidebar.classList.add("-translate-x-full");
  overlay.classList.add("hidden");
});

// Account dropdown toggle
const profileBtn = document.getElementById("profile-btn");
const dropdown = document.getElementById("account-dropdown");

profileBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  dropdown.classList.toggle("hidden");
});

// Close dropdown when clicking outside
document.addEventListener("click", () => {
  dropdown.classList.add("hidden");
});
