document.addEventListener("DOMContentLoaded", function () {
  const mainImage = document.getElementById("main-image");
  const thumbnails = document.querySelectorAll(".thumbnail");
  const colorOptions = document.querySelectorAll(".color-option");
  const sizeButtons = document.querySelectorAll(".size-btn");
  const zoomContainer = document.querySelector(".zoom-container");
  const zoomModal = document.getElementById("zoom-modal");
  const zoomModalImage = document.getElementById("zoom-modal-image");
  const fullscreenBtn = document.getElementById("fullscreen-btn");
  const closeZoom = document.getElementById("close-zoom");
  const wishlistBtn = document.getElementById("wishlist-btn");
  const addToCartBtn = document.getElementById("add-to-cart");

  let currentLargeSrc = "./assets/images/Home-image/pic-7.avif";
  let isWishlisted = false;
  let isCurrentlyMobile = null;

  // Update image function
  function updateImage(displaySrc, largeSrc) {
    mainImage.src = displaySrc;
    currentLargeSrc = largeSrc;
    zoomModalImage.src = largeSrc;
  }

  // Thumbnails
  thumbnails.forEach((thumb) => {
    thumb.addEventListener("click", function () {
      thumbnails.forEach((t) => t.classList.remove("selected"));
      this.classList.add("selected");
      updateImage(this.dataset.display, this.dataset.large);
    });
  });

  // Colors
  colorOptions.forEach((opt, index) => {
    opt.addEventListener("click", function () {
      colorOptions.forEach((o) => o.classList.remove("selected-color"));
      this.classList.add("selected-color");
      updateImage(this.dataset.display, this.dataset.large);

      thumbnails.forEach((t) => t.classList.remove("selected"));
      if (thumbnails[index]) {
        thumbnails[index].classList.add("selected");
      }
    });
  });

  // Sizes
  sizeButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      sizeButtons.forEach((b) => {
        b.classList.remove("bg-secondary", "text-white");
      });
      this.classList.add("bg-secondary", "text-white");
    });
  });

  // === MODAL OPEN/CLOSE WITH WISHLIST COLOR CHANGE ===

  // Open modal
  fullscreenBtn.addEventListener("click", () => {
    zoomModalImage.src = currentLargeSrc;
    zoomModal.classList.remove("hidden");
    document.body.style.overflow = "hidden";

    // Change wishlist button color to white when modal opens
    wishlistBtn.classList.remove("text-black");
    wishlistBtn.classList.add("text-white");
  });

  // Close modal function
  function closeModal() {
    zoomModal.classList.add("hidden");
    document.body.style.overflow = "";

    // Restore wishlist button color to black when modal closes
    wishlistBtn.classList.remove("text-white");
    wishlistBtn.classList.add("text-black");
  }

  closeZoom.addEventListener("click", closeModal);
  zoomModal.addEventListener("click", (e) => {
    if (e.target === zoomModal) closeModal();
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !zoomModal.classList.contains("hidden")) {
      closeModal();
    }
  });

  // Wishlist toggle
  wishlistBtn.addEventListener("click", () => {
    const icon = wishlistBtn.querySelector("i");
    if (isWishlisted) {
      icon.classList.replace("fas", "far");
      icon.classList.remove("text-red-500");
    } else {
      icon.classList.replace("far", "fas");
      icon.classList.add("text-red-500");
    }
    isWishlisted = !isWishlisted;
  });

  // Add to Cart
  addToCartBtn.addEventListener("click", () => {
    addToCartBtn.innerHTML = '<i class="fas fa-check mr-2"></i> Added!';
    addToCartBtn.classList.replace("bg-blue-900", "bg-green-600");

    setTimeout(() => {
      addToCartBtn.innerHTML =
        '<i class="fas fa-shopping-cart mr-2"></i> Add to Cart';
      addToCartBtn.classList.replace("bg-green-600", "bg-blue-900");
    }, 2000);
  });

  // === DYNAMIC ZOOM BEHAVIOR ===

  const handleMouseMove = function (e) {
    const rect = zoomContainer.getBoundingClientRect();
    const x = ((e.clientX - rect.left) / rect.width) * 100;
    const y = ((e.clientY - rect.top) / rect.height) * 100;
    mainImage.style.transformOrigin = `${x}% ${y}%`;
  };

  const handleMouseEnter = function () {
    mainImage.style.transform = "scale(2)";
    mainImage.style.transition = "transform 0.3s ease";
  };

  const handleMouseLeave = function () {
    mainImage.style.transform = "scale(1)";
    mainImage.style.transformOrigin = "50% 50%";
  };

  function enableDesktopZoom() {
    zoomContainer.addEventListener("mousemove", handleMouseMove);
    zoomContainer.addEventListener("mouseenter", handleMouseEnter);
    zoomContainer.addEventListener("mouseleave", handleMouseLeave);
    mainImage.style.transition = "transform 0.3s ease";
  }

  function disableDesktopZoom() {
    zoomContainer.removeEventListener("mousemove", handleMouseMove);
    zoomContainer.removeEventListener("mouseenter", handleMouseEnter);
    zoomContainer.removeEventListener("mouseleave", handleMouseLeave);
    mainImage.style.transform = "scale(1)";
    mainImage.style.transition = "none";
    mainImage.style.transformOrigin = "50% 50%";
  }

  function updateZoomBehavior() {
    const currentlyMobile = window.innerWidth < 992;

    if (currentlyMobile !== isCurrentlyMobile) {
      if (currentlyMobile) {
        disableDesktopZoom();
      } else {
        enableDesktopZoom();
      }
      isCurrentlyMobile = currentlyMobile;
    }
  }

  // Initial setup
  updateZoomBehavior();

  // Update on resize/orientation change
  window.addEventListener("resize", updateZoomBehavior);
  window.addEventListener("orientationchange", updateZoomBehavior);
});



// Desktop Tabs
const tabButtons = document.querySelectorAll(".tab-btn");
const tabContents = document.querySelectorAll(".tab-content");

// Set initial active state (first tab)
tabButtons[0].classList.add("border-black", "text-black");
tabButtons[0].classList.remove("text-gray-500", "border-transparent");

tabButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
    // Deactivate all buttons
    tabButtons.forEach((b) => {
      b.classList.remove("border-black", "text-black");
      b.classList.add("text-gray-500", "border-transparent");
    });

    // Activate clicked button
    btn.classList.remove("text-gray-500", "border-transparent");
    btn.classList.add("border-black", "text-black");

    // Deactivate all content
    tabContents.forEach((c) => c.classList.remove("active"));

    // Activate corresponding content
    const target = document.getElementById(btn.dataset.tab);
    if (target) {
      target.classList.add("active");
    }
  });
});


// accordian code 
document.addEventListener("DOMContentLoaded", function () {
  setTimeout(function () {
    const e = document.querySelectorAll(".accordion-wrapper");
    let t;
    function o(e, t) {
      if (t) {
        const t = e.scrollHeight;
        (e.style.maxHeight = "0px"),
          (e.style.paddingTop = "0px"),
          (e.style.paddingBottom = "0px"),
          requestAnimationFrame(() => {
            (e.style.maxHeight = t + 32 + "px"),
              (e.style.paddingTop = "1rem"),
              (e.style.paddingBottom = "1rem");
          });
      } else (e.style.maxHeight = "0px"), (e.style.paddingTop = "0px"), (e.style.paddingBottom = "0px");
    }
    function n() {
      e.forEach((e) => {
        if (e.classList.contains("active")) {
          o(e.querySelector(".accordion-content-block"), !0);
        }
      });
    }
    function i(t) {
      const n = t.querySelector(".flex.justify-between.items-center"),
        i = t.querySelector(".accordion-content-block"),
        s = t.querySelector(".accordion-chevron"),
        r = t.querySelector(".line-border-block");
      n.addEventListener("click", function () {
        const n = t.classList.contains("active");
        var l;
        (l = t),
          e.forEach((e) => {
            if (e !== l && e.classList.contains("active")) {
              const t = e.querySelector(".accordion-content-block"),
                n = e.querySelector(".accordion-chevron"),
                i = e.querySelector(".line-border-block");
              o(t, !1),
                (t.style.opacity = "0"),
                (i.style.width = "0"),
                (n.style.transform = "rotate(90deg)"),
                e.classList.remove("active");
            }
          }),
          n
            ? (o(i, !1),
              (i.style.opacity = "0"),
              (r.style.width = "0"),
              (s.style.transform = "rotate(90deg)"),
              t.classList.remove("active"))
            : ((i.style.opacity = "1"),
              (r.style.width = "100%"),
              (s.style.transform = "rotate(-90deg)"),
              t.classList.add("active"),
              o(i, !0),
              setTimeout(() => {
                o(i, !0);
              }, 50));
      });
    }
    e.forEach((e, t) => {
      const n = e.querySelector(".accordion-content-block"),
        s = e.querySelector(".line-border-block");
      (n.style.transition =
        "max-height 0.4s ease, opacity 0.3s ease, padding-top 0.3s ease, padding-bottom 0.3s ease"),
        (n.style.overflow = "hidden"),
        (s.style.transition = "width 0.3s ease-in-out"),
        0 === t
          ? ((n.style.opacity = "1"),
            (n.style.paddingTop = "1rem"),
            (n.style.paddingBottom = "1rem"),
            (s.style.width = "100%"),
            (e.querySelector(".accordion-chevron").style.transform =
              "rotate(-90deg)"),
            e.classList.add("active"),
            o(n, !0),
            setTimeout(() => {
              o(n, !0);
            }, 50))
          : (o(n, !1),
            (n.style.opacity = "0"),
            (n.style.paddingTop = "0px"),
            (n.style.paddingBottom = "0px"),
            (s.style.width = "0")),
        i(e);
    }),
      window.addEventListener("resize", function () {
        clearTimeout(t),
          (t = setTimeout(function () {
            n();
          }, 250));
      }),
      window.addEventListener("scroll", function () {
        clearTimeout(t),
          (t = setTimeout(function () {
            n();
          }, 100));
      }),
      setTimeout(() => {
        n();
      }, 50);
  }, 2000);
});