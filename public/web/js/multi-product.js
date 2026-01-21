document.addEventListener("DOMContentLoaded", function () {
  const filterButton = document.querySelector("#open-filter");
  const sidebar = document.getElementById("filter-sidebar");
  const closeButton = document.getElementById("close-filter");
  const overlay = document.getElementById("filter-overlay");

  // Only apply mobile behavior if screen < 991px
  function isMobile() {
    return window.innerWidth < 991;
  }

  function openSidebar() {
    if (!isMobile()) return;

    sidebar.classList.remove("translate-x-[-150%]");
    sidebar.classList.add("translate-x-0");
    overlay.classList.remove("hidden");
    document.body.style.overflow = "hidden"; // prevent background scroll
  }

  function closeSidebar() {
    if (!isMobile()) return;

    sidebar.classList.remove("translate-x-0");
    sidebar.classList.add("translate-x-[-150%]");
    overlay.classList.add("hidden");
    document.body.style.overflow = "";
  }

  // Initial setup: hide sidebar off-screen on mobile
  if (isMobile()) {
    sidebar.classList.add(
      "transition-transform",
      "duration-300",
      "ease-in-out",
      "fixed",
      "z-50",
      "h-full",
      "overflow-y-auto"
    );
    sidebar.classList.remove("relative");
    sidebar.classList.add("translate-x-[-150%]"); // start hidden
  }

  // Event Listeners
  if (filterButton) {
    filterButton.addEventListener("click", openSidebar);
  }

  if (closeButton) {
    closeButton.addEventListener("click", closeSidebar);
  }

  if (overlay) {
    overlay.addEventListener("click", closeSidebar);
  }

  // Handle window resize
  window.addEventListener("resize", function () {
    if (isMobile()) {
      // Ensure correct state on mobile
      sidebar.classList.add("fixed", "translate-x-[-150%]");
      sidebar.classList.remove("relative");
    } else {
      // On desktop: restore normal layout
      sidebar.classList.remove("fixed", "translate-x-[-150%]", "translate-x-0");
      sidebar.classList.add("relative");
      overlay.classList.add("hidden");
      document.body.style.overflow = "";
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

// sort dropdown code
document.addEventListener("DOMContentLoaded", () => {
  const button = document.getElementById("sort-button");
  const menu = document.getElementById("sort-menu");
  const label = document.getElementById("sort-label");
  const chevron = document.getElementById("chevron-icon");
  const options = document.querySelectorAll(".sort-option");

  // Default label
  let currentLabel = "Sort by";
  let currentValue = "";

  // Set initial active state (Date newest first as example)
  const initialOption = menu.querySelector(".sort-option.active");
  if (initialOption) {
    currentLabel = initialOption.querySelector("span").textContent.trim();
    currentValue = initialOption.dataset.value;
    label.textContent = currentLabel;
  }

  // Toggle dropdown
  button.addEventListener("click", (e) => {
    e.stopPropagation();
    const isOpen = !menu.classList.contains("hidden");
    menu.classList.toggle("hidden");
    chevron.classList.toggle("rotate-180", !isOpen);
    button.setAttribute("aria-expanded", !isOpen);
  });

  // Select option
  options.forEach((option) => {
    option.addEventListener("click", () => {
      // Update active state
      menu
        .querySelectorAll(".sort-option")
        .forEach((opt) => opt.classList.remove("active"));
      option.classList.add("active");

      // Update checkmarks
      menu
        .querySelectorAll(".checkmark")
        .forEach((mark) => mark.classList.add("opacity-0"));
      option.querySelector(".checkmark").classList.remove("opacity-0");

      // Update button label
      currentLabel = option.querySelector("span").textContent.trim();
      currentValue = option.dataset.value;
      label.textContent = currentLabel;

      // Close menu
      menu.classList.add("hidden");
      chevron.classList.remove("rotate-180");
      button.setAttribute("aria-expanded", "false");

      // Here you can trigger your actual sorting logic
      // console.log('Sort by:', currentValue);
      // Example: sortData(currentValue);
    });
  });

  // Close when clicking outside
  document.addEventListener("click", (e) => {
    if (!button.contains(e.target) && !menu.contains(e.target)) {
      menu.classList.add("hidden");
      chevron.classList.remove("rotate-180");
      button.setAttribute("aria-expanded", "false");
    }
  });

  // Keyboard accessibility (ESC to close)
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !menu.classList.contains("hidden")) {
      menu.classList.add("hidden");
      chevron.classList.remove("rotate-180");
      button.setAttribute("aria-expanded", "false");
      button.focus();
    }
  });
});
