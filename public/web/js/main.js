// $(document).ready(function () {
//   var secondOwl;
//   var mainOwl;
//   var bannerOwl; // New variable for banner carousel

//   function initCarousels() {
//     var width = $(window).width();

//     // Initialize or re-initialize banner carousel (for screens < 992px)
//     if ($(".banner-carousel").length) {
//       if (bannerOwl) {
//         $(".banner-carousel")
//           .trigger("destroy.owl.carousel")
//           .removeClass("owl-loaded")
//           .find(".owl-stage-outer")
//           .children()
//           .unwrap();
//       }

//       // Only initialize if screen width is less than 992px
//       if (width < 992) {
//         bannerOwl = $(".banner-carousel").owlCarousel({
//           loop: true,
//           margin: 10,
//           nav: true,
//           navText: [
//             '<i class="fas fa-chevron-left"></i>',
//             '<i class="fas fa-chevron-right"></i>',
//           ],
//           dots: true,
//           autoplay: true,
//           autoplayTimeout: 4000,
//           autoplayHoverPause: true,
//           items: 1,
//           responsive: {
//             0: { items: 1, margin: 10 },
//             768: { items: 1, margin: 20 },
//           },
//         });
//       } else {
//         // Destroy if exists and screen is desktop
//         if (bannerOwl) {
//           $(".banner-carousel")
//             .trigger("destroy.owl.carousel")
//             .removeClass("owl-loaded")
//             .find(".owl-stage-outer")
//             .children()
//             .unwrap();
//           bannerOwl = null;
//         }
//       }
//     }

//     // Initialize or re-initialize .second-owl (dots always true in your current setup)
//     if ($(".second-owl").length) {
//       if (secondOwl) {
//         $(".second-owl")
//           .trigger("destroy.owl.carousel")
//           .removeClass("owl-loaded")
//           .find(".owl-stage-outer")
//           .children()
//           .unwrap();
//       }
//       secondOwl = $(".second-owl").owlCarousel({
//         loop: true,
//         margin: 24,
//         navText: [
//           '<i class="fas fa-chevron-left"></i>',
//           '<i class="fas fa-chevron-right"></i>',
//         ],
//         dots: true,
//         autoplay: true,
//         autoplayTimeout: 3000,
//         autoplayHoverPause: true,
//         responsive: {
//           0: { items: 1 },
//           550: { items: 2 },
//           1000: { items: 2 },
//           1200: { items: 3 },
//         },
//       });
//     }

//     // Initialize or re-initialize .main-owl (nav always true in your current setup)
//     if ($(".main-owl").length) {
//       if (mainOwl) {
//         $(".main-owl")
//           .trigger("destroy.owl.carousel")
//           .removeClass("owl-loaded")
//           .find(".owl-stage-outer")
//           .children()
//           .unwrap();
//       }
//       mainOwl = $(".main-owl").owlCarousel({
//         loop: true,
//         margin: 24,
//         nav: true,
//         navText: [
//           '<i class="fas fa-chevron-left"></i>',
//           '<i class="fas fa-chevron-right"></i>',
//         ],
//         dots: false,
//         autoplay: true,
//         autoplayTimeout: 3000,
//         autoplayHoverPause: true,
//         responsive: {
//           0: { items: 1, margin: 10 },
//           450: { items: 2, margin: 16 },
//           768: { items: 3, margin: 20 },
//           1024: { items: 4 },
//           1280: { items: 5 },
//         },
//       });
//     }
//   }

//   // Initial initialization
//   initCarousels();

//   // Re-initialize on window resize (with debounce to avoid too many calls)
//   var resizeTimer;
//   $(window).on("resize", function () {
//     clearTimeout(resizeTimer);
//     resizeTimer = setTimeout(initCarousels, 300);
//   });
// });

//  with lazy load 

// $(document).ready(function () {
//   // Common configuration presets
//   const carouselPresets = {
//     autoplay: {
//       autoplay: true,
//       autoplayTimeout: 4000,
//       autoplayHoverPause: true,
//       autoplaySpeed: 800,
//       smartSpeed: 500,
//       fluidSpeed: 500
//     },
//     navigation: {
//       nav: true,
//       navText: [
//         '<i class="fas fa-chevron-left"></i>',
//         '<i class="fas fa-chevron-right"></i>'
//       ],
//       navSpeed: 500
//     }
//   };

//   // All carousel configurations
//   const carouselConfigs = [
//     {
//       selector: "#categories-carousel",
//       options: {
//         loop: true,
//         margin: 20,
//         nav: false,
//         dots: false,
//         lazyLoad: true,  // ✅ Enable lazy loading
//         lazyLoadEager: 1, // ✅ Load 1 adjacent image
//         ...carouselPresets.autoplay,
//         autoplayTimeout: 5000,
//         responsive: {
//           0: { items: 1, margin: 10 },
//           450: { items: 2, margin: 10 },
//           640: { items: 2, margin: 10 },
//           768: { items: 3, margin: 10 },
//           1024: { items: 4, margin: 10 },
//           1280: { items: 5, margin: 10 },
//           1366: { items: 6, margin: 10 }
//         }
//       },
//       customNav: {
//         prev: '.custom-nav .owl-prev',
//         next: '.custom-nav .owl-next'
//       }
//     },
//     {
//       selector: ".main-owl",
//       options: {
//         loop: true,
//         margin: 24,
//         dots: false,
//         lazyLoad: true,
//         ...carouselPresets.navigation,
//         ...carouselPresets.autoplay,
//         responsive: {
//           0: { items: 1, margin: 10 },
//           450: { items: 2, margin: 16 },
//           768: { items: 3, margin: 20 },
//           1024: { items: 4 },
//           1280: { items: 5 }
//         }
//       }
//     },
//     {
//       selector: ".banner-carousel",
//       options: {
//         loop: true,
//         margin: 10,
//         items: 1,
//         dots: true,
//         lazyLoad: true,
//         ...carouselPresets.navigation,
//         ...carouselPresets.autoplay,
//         responsive: {
//           0: { items: 1, margin: 10 },
//           768: { items: 1, margin: 20 }
//         }
//       }
//     },
//     {
//       selector: ".second-owl",
//       options: {
//         loop: true,
//         margin: 24,
//         dots: true,
//         lazyLoad: true,
//         ...carouselPresets.autoplay,
//         nav: true,
//         navText: carouselPresets.navigation.navText,
//         responsive: {
//           0: { items: 1 },
//           550: { items: 2 },
//           1000: { items: 2 },
//           1200: { items: 3 }
//         }
//       }
//     },
//     {
//       selector: "#designer-thoughts",
//       options: {
//         loop: true,
//         margin: 20,
//         nav: false,
//         dots: true,
//         lazyLoad: true,
//         ...carouselPresets.autoplay,
//         responsive: {
//           0: { items: 1, dots: true },
//           640: { items: 1, dots: true },
//           768: { items: 1, dots: true },
//           1024: { items: 1, dots: true },
//           1280: { items: 1, dots: true }
//         }
//       },
//       customNav: {
//         prev: '.thoughts-nav .custom-prev-btn',
//         next: '.thoughts-nav .custom-next-btn'
//       }
//     }
//   ];

//   // Track initialized carousels
//   const initializedCarousels = new Set();

//   // Function to check if element is in viewport
//   function isInViewport(element) {
//     const rect = element.getBoundingClientRect();
//     return (
//       rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 1.5 &&
//       rect.bottom >= -100
//     );
//   }

//   // Initialize single carousel with optimization
//   function initCarousel(config) {
//     const $carousel = $(config.selector);

//     if (!$carousel.length || initializedCarousels.has(config.selector)) {
//       return;
//     }

//     // Check if carousel should be initialized (in viewport or near)
//     if (!isInViewport($carousel[0])) {
//       return;
//     }

//     try {
//       // Initialize the carousel
//       $carousel.owlCarousel(config.options);
//       initializedCarousels.add(config.selector);

//       // Setup custom navigation with event delegation
//       if (config.customNav) {
//         // Use event delegation instead of direct binding
//         $(document).off(`click.${config.selector}-prev`).on(`click.${config.selector}-prev`, config.customNav.prev, function(e) {
//           e.preventDefault();
//           $carousel.trigger('prev.owl.carousel');
//         });

//         $(document).off(`click.${config.selector}-next`).on(`click.${config.selector}-next`, config.customNav.next, function(e) {
//           e.preventDefault();
//           $carousel.trigger('next.owl.carousel');
//         });
//       }

//       // Add performance optimization
//       $carousel.on('changed.owl.carousel', function() {
//         // Pause animations when not in viewport
//         if (!isInViewport(this)) {
//           $carousel.trigger('stop.owl.autoplay');
//         }
//       });

//       console.log(`Initialized: ${config.selector}`);
//     } catch (error) {
//       console.error(`Failed to initialize ${config.selector}:`, error);
//     }
//   }

//   // Initialize carousels on scroll (lazy initialization)
//   function lazyInitCarousels() {
//     carouselConfigs.forEach(config => {
//       if (!initializedCarousels.has(config.selector)) {
//         initCarousel(config);
//       }
//     });
//   }

//   // Initialize immediately visible carousels
//   lazyInitCarousels();

//   // Lazy initialize on scroll with debounce
//   let scrollTimeout;
//   $(window).on('scroll', function() {
//     clearTimeout(scrollTimeout);
//     scrollTimeout = setTimeout(lazyInitCarousels, 100);
//   });

//   // Also initialize on resize (for responsive changes)
//   let resizeTimeout;
//   $(window).on('resize', function() {
//     clearTimeout(resizeTimeout);
//     resizeTimeout = setTimeout(lazyInitCarousels, 200);
//   });

//   // Cleanup on page unload
//   $(window).on('beforeunload', function() {
//     carouselConfigs.forEach(config => {
//       if (config.customNav) {
//         $(document).off(`click.${config.selector}-prev`);
//         $(document).off(`click.${config.selector}-next`);
//       }
//     });
//   });
// });



// without lazy load 



$(document).ready(function () {
  // Common configuration presets
  const carouselPresets = {
    autoplay: {
      autoplay: true,
      autoplayTimeout: 4000,
      autoplayHoverPause: true,
      autoplaySpeed: 800,
      smartSpeed: 500,
      fluidSpeed: 500
    },
    navigation: {
      nav: true,
      navText: [
        '<i class="fas fa-chevron-left"></i>',
        '<i class="fas fa-chevron-right"></i>'
      ],
      navSpeed: 500
    }
  };

  // All carousel configurations
  const carouselConfigs = [
    {
      selector: "#categories-carousel",
      options: {
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        // ❌ Lazy loading removed
        ...carouselPresets.autoplay,
        autoplayTimeout: 5000,
        responsive: {
          0: { items: 1, margin: 10 },
          450: { items: 2, margin: 10 },
          640: { items: 2, margin: 10 },
          768: { items: 3, margin: 10 },
          1024: { items: 4, margin: 10 },
          1280: { items: 5, margin: 10 },
          1366: { items: 6, margin: 10 }
        }
      },
      customNav: {
        prev: '.custom-nav .owl-prev',
        next: '.custom-nav .owl-next'
      }
    },
    {
      selector: ".main-owl",
      options: {
        loop: true,
        margin: 24,
        dots: false,
        // ❌ Lazy loading removed
        ...carouselPresets.navigation,
        ...carouselPresets.autoplay,
        responsive: {
          0: { items: 1, margin: 10 },
          450: { items: 2, margin: 16 },
          768: { items: 3, margin: 20 },
          1024: { items: 4, margin: 30 },
          1280: { items: 4 ,margin: 35 },
          1500: { items: 5 ,margin: 35 }
        }
      }
    },
    {
      selector: ".banner-carousel",
      options: {
        loop: true,
        margin: 10,
        items: 1,
        dots: true,
        // ❌ Lazy loading removed
        ...carouselPresets.navigation,
        ...carouselPresets.autoplay,
        responsive: {
          0: { items: 1, margin: 10 },
          768: { items: 1, margin: 20 }
        }
      }
    },
    {
      selector: ".second-owl",
      options: {
        loop: true,
        margin: 24,
        dots: true,
        // ❌ Lazy loading removed
        ...carouselPresets.autoplay,
        nav: true,
        navText: carouselPresets.navigation.navText,
        responsive: {
          0: { items: 1 },
          550: { items: 2 },
          1000: { items: 2 },
          1200: { items: 3 }
        }
      }
    },
    {
      selector: "#designer-thoughts",
      options: {
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        // ❌ Lazy loading removed
        ...carouselPresets.autoplay,
        responsive: {
          0: { items: 1, dots: true },
          640: { items: 1, dots: true },
          768: { items: 1, dots: true },
          1024: { items: 1, dots: true },
          1280: { items: 1, dots: true }
        }
      },
      customNav: {
        prev: '.thoughts-nav .custom-prev-btn',
        next: '.thoughts-nav .custom-next-btn'
      }
    }
  ];

  // Track initialized carousels
  const initializedCarousels = new Set();

  // Function to check if element is in viewport
  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 1.5 &&
      rect.bottom >= -100
    );
  }

  // Initialize single carousel with optimization
  function initCarousel(config) {
    const $carousel = $(config.selector);
    
    if (!$carousel.length || initializedCarousels.has(config.selector)) {
      return;
    }

    // Check if carousel should be initialized (in viewport or near)
    if (!isInViewport($carousel[0])) {
      return;
    }

    try {
      // Initialize the carousel
      $carousel.owlCarousel(config.options);
      initializedCarousels.add(config.selector);

      // Setup custom navigation with event delegation
      if (config.customNav) {
        // Use event delegation instead of direct binding
        $(document).off(`click.${config.selector}-prev`).on(`click.${config.selector}-prev`, config.customNav.prev, function(e) {
          e.preventDefault();
          $carousel.trigger('prev.owl.carousel');
        });

        $(document).off(`click.${config.selector}-next`).on(`click.${config.selector}-next`, config.customNav.next, function(e) {
          e.preventDefault();
          $carousel.trigger('next.owl.carousel');
        });
      }

      // Add performance optimization
      $carousel.on('changed.owl.carousel', function() {
        // Pause animations when not in viewport
        if (!isInViewport(this)) {
          $carousel.trigger('stop.owl.autoplay');
        }
      });

      console.log(`Initialized: ${config.selector}`);
    } catch (error) {
      console.error(`Failed to initialize ${config.selector}:`, error);
    }
  }

  // Initialize carousels on scroll (lazy initialization)
  function lazyInitCarousels() {
    carouselConfigs.forEach(config => {
      if (!initializedCarousels.has(config.selector)) {
        initCarousel(config);
      }
    });
  }

  // Initialize immediately visible carousels
  lazyInitCarousels();

  // Lazy initialize on scroll with debounce
  let scrollTimeout;
  $(window).on('scroll', function() {
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(lazyInitCarousels, 100);
  });

  // Also initialize on resize (for responsive changes)
  let resizeTimeout;
  $(window).on('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(lazyInitCarousels, 200);
  });

  // Cleanup on page unload
  $(window).on('beforeunload', function() {
    carouselConfigs.forEach(config => {
      if (config.customNav) {
        $(document).off(`click.${config.selector}-prev`);
        $(document).off(`click.${config.selector}-next`);
      }
    });
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




