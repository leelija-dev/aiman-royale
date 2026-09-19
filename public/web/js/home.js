// resources/js/home.js

/* ============================================================
   HOME PAGE SCRIPT
   Only loaded on the home page (see Step 2).
   ============================================================ */

// -------------------- Confetti lazy loader --------------------
export function loadConfetti(callback) {
    if (window.confetti) {
        callback();
        return;
    }
    const script = document.createElement('script');
    script.src =
        'https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js';
    script.onload = callback;
    document.body.appendChild(script);
}

// -------------------- Helpers --------------------
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white transform transition-transform duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => notification.classList.remove('translate-x-full'), 100);
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

function updateWishlistCount(count) {
    const button = document.querySelector('a[href*="wishlist"] button');
    let badge = document.getElementById('wishlist-counter');

    if (count > 0) {
        if (!badge && button) {
            badge = document.createElement('span');
            badge.id = 'wishlist-counter';
            badge.className =
                'wishlist-count absolute -top-1 -right-1 w-5 h-5 bg-red-700 text-white text-xs rounded-full flex items-center justify-center';
            button.appendChild(badge);
        }
        if (badge) badge.innerHTML = count;
    } else if (badge) {
        badge.remove();
    }

    document.querySelectorAll('.wishlist-count').forEach((item) => {
        item.innerHTML = count;
        item.style.display = count > 0 ? 'flex' : 'none';
    });
}

function updateCartCount(count) {
    document.querySelectorAll('.cart-count').forEach((el) => {
        el.textContent = count;
    });
}

// -------------------- Wishlist (home cards) --------------------
export function toggleHomeWishlist(productId, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    if (!productId) {
        alert('Product ID not found');
        return;
    }

    const heartIcon = document.getElementById(`wishlist-heart-${productId}`);
    if (!heartIcon) return;

    const isSVG = heartIcon.tagName.toLowerCase() === 'svg';
    const isInWishlist = isSVG ? false : heartIcon.classList.contains('fas');
    const url = isInWishlist ? '/wishlist/remove' : '/wishlist/add';
    const originalContent = heartIcon.innerHTML;

    heartIcon.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
        },
        body: JSON.stringify({ product_id: productId }),
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                showNotification(data.message, 'success');
                heartIcon.innerHTML = isInWishlist
                    ? '<i class="far fa-heart text-red-500"></i>'
                    : '<i class="fas fa-heart text-red-500"></i>';
                if (data.wishlist_count !== undefined) {
                    updateWishlistCount(data.wishlist_count);
                }
            } else if (data.message?.includes('already in wishlist')) {
                showNotification('Product is already in wishlist!', 'info');
                if (isSVG && !isInWishlist) {
                    heartIcon.innerHTML = '<i class="fas fa-heart text-red-500"></i>';
                }
            } else {
                showNotification(data.message || 'Failed to update wishlist', 'error');
            }
        })
        .catch((err) => {
            console.error('Wishlist error:', err);
            showNotification('An error occurred while updating wishlist', 'error');
        })
        .finally(() => {
            if (heartIcon.innerHTML.includes('fa-spinner')) {
                heartIcon.innerHTML = originalContent;
            }
        });
}

export function checkHomeProductWishlist(productId) {
    const heartIcon = document.getElementById(`wishlist-heart-${productId}`);
    if (!heartIcon) return;

    fetch('/wishlist/check', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
        },
        body: JSON.stringify({ product_id: productId }),
    })
        .then((r) => r.json())
        .then((data) => {
            heartIcon.innerHTML = data.in_wishlist
                ? '<i class="fas fa-heart text-red-500"></i>'
                : '<i class="far fa-heart text-red-500"></i>';
        })
        .catch((err) => console.error('Wishlist check error:', err));
}

// -------------------- Parallax (guarded + rAF-throttled) --------------------
function initParallax() {
    const bg = document.querySelector('.parallax-bg');
    if (!bg) return;

    const section = bg.closest('section');
    if (!section) return;

    let ticking = false;

    function update() {
        const rect = section.getBoundingClientRect();
        const windowHeight = window.innerHeight;

        if (rect.bottom > 0 && rect.top < windowHeight) {
            const scrollProgress = rect.top / windowHeight;
            const movement = scrollProgress * -500;
            bg.style.transform = `translateY(${movement}px) scale(1.2)`;
        }

        ticking = false;
    }

    function requestUpdate() {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    }

    window.addEventListener('scroll', requestUpdate, { passive: true });
    window.addEventListener('resize', requestUpdate);
    update();
}

// -------------------- Category slider (multi-position) --------------------
function initCategorySlider() {
    const sliders = [
        { className: 'slide-left', linkId: 'leftSliderLink' },
        { className: 'slide-top', linkId: 'topSliderLink' },
        { className: 'slide-center', linkId: 'centerSliderLink' },
        { className: 'slide-right', linkId: 'rightSliderLink' },
        { className: 'slide-bottom', linkId: 'bottomSliderLink' },
    ];

    // If none of the slider wrappers exist on this page, skip
    const anyExists = sliders.some((s) => document.querySelector('.' + s.className));
    if (!anyExists) return;

    let currentIndex = 0;
    let timerId = null;

    function updateSlider(slider) {
        const slides = document.querySelectorAll('.' + slider.className);
        if (slides.length === 0) return;

        const link = document.getElementById(slider.linkId);
        const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
        const activeIndex = currentIndex % slides.length;

        slides.forEach((slide) => {
            slide.classList.remove('opacity-100', 'z-10', 'fade-out', 'fade-in');
            slide.classList.add('opacity-0', 'z-0');
        });

        slides[prevIndex].classList.remove('opacity-0', 'z-0');
        slides[prevIndex].classList.add('opacity-100', 'z-10', 'fade-out');

        slides[activeIndex].classList.remove('opacity-0', 'z-0');
        slides[activeIndex].classList.add('fade-in', 'z-10');

        if (link) link.href = slides[activeIndex].dataset.link || '#';

        const prefix = slider.className.replace('slide-', '');
        const title = document.getElementById(prefix + 'TitleText');
        const shortText = document.getElementById(prefix + 'ShortText');
        const offerText = document.getElementById(prefix + 'OfferText');
        const shopBtn = document.getElementById(prefix + 'ShopBtn');

        if (title) title.innerText = slides[activeIndex].dataset.title || '';
        if (shortText) shortText.innerText = slides[activeIndex].dataset.short || '';
        if (shopBtn) shopBtn.href = slides[activeIndex].dataset.link || '#';

        if (offerText) {
            const offer = slides[activeIndex].dataset.offer;
            if (offer) {
                offerText.innerHTML = `
                    <span class="inline-flex items-center gap-1 bg-black/20 backdrop-blur-md py-1 px-3 rounded-[50px] shadow-lg">
                        <span class="text-xl font-bold text-white">${offer}</span>
                        <span class="text-lg uppercase tracking-[6px] text-white font-semibold">% OFF</span>
                    </span>`;
                offerText.style.display = 'inline-flex';
                offerText.style.alignItems = 'center';
            } else {
                offerText.style.display = 'none';
            }
        }
    }

    function tick() {
        currentIndex++;
        sliders.forEach(updateSlider);
    }

    sliders.forEach(updateSlider);
    timerId = setInterval(tick, 4000);

    // Pause when tab is hidden
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            clearInterval(timerId);
            timerId = null;
        } else if (!timerId) {
            timerId = setInterval(tick, 4000);
        }
    });
}

// -------------------- Countdown timer --------------------
function initCountdown() {
    const el = document.getElementById('countdown-timer');
    if (!el) return;

    const targetRaw = el.dataset.target;
    if (!targetRaw) return;

    const TARGET_DATE = new Date(targetRaw);
    if (isNaN(TARGET_DATE.getTime())) return;

    const daysBox = document.getElementById('daysBox');
    const hoursBox = document.getElementById('hoursBox');
    const minutesBox = document.getElementById('minutesBox');
    const secondsBox = document.getElementById('secondsBox');
    const daysLabel = document.getElementById('daysLabel');

    const pad = (n) => String(n).padStart(2, '0');

    function update() {
        const diff = Math.max(0, TARGET_DATE.getTime() - Date.now());
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);

        if (daysLabel) daysLabel.textContent = days;
        if (daysBox) daysBox.textContent = days;
        if (hoursBox) hoursBox.textContent = pad(hours);
        if (minutesBox) minutesBox.textContent = pad(minutes);
        if (secondsBox) secondsBox.textContent = pad(seconds);
    }

    update();
    const id = setInterval(update, 1000);

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) clearInterval(id);
    });
}

// -------------------- Owl Carousels --------------------
function initHeroCarousel() {
    if (typeof window.$ === 'undefined' || typeof window.$.fn.owlCarousel === 'undefined') {
        return false;
    }
    const $el = window.$('.hero-carousel');
    if (!$el.length) return true;

    $el.owlCarousel({
        items: 1,
        loop: true,
        margin: 0,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5500,
        autoplayHoverPause: true,
        stopOnHover: true,
        smartSpeed: 900,
        navText: ['', ''],
        responsive: {
            0: { nav: true, dots: true },
            768: { nav: true, dots: true },
        },
    });
    return true;
}

function initCategoriesTagCarousel() {
    if (typeof window.$ === 'undefined' || typeof window.$.fn.owlCarousel === 'undefined') {
        return false;
    }
    const $el = window.$('#categories-tag-carousel');
    if (!$el.length) return true;

    $el.owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        smartSpeed: 500,
        responsive: {
            0: { items: 1.5, margin: 15 },
            480: { items: 2.5, margin: 15 },
            640: { items: 3.5, margin: 15 },
            768: { items: 4.5, margin: 20 },
            1024: { items: 6.5, margin: 20 },
            1280: { items: 8.5, margin: 25 },
        },
    });
    return true;
}

// Owl Carousel needs jQuery + Owl loaded first (deferred scripts).
// Retry until available, with a hard cap so we don't loop forever.
function waitForOwl(retries = 20, delay = 250) {
    if (typeof window.$ !== 'undefined' && window.$.fn.owlCarousel) {
        initHeroCarousel();
        initCategoriesTagCarousel();
        return;
    }
    if (retries <= 0) return;
    setTimeout(() => waitForOwl(retries - 1, delay), delay);
}

// -------------------- Main init --------------------
export function initHomePage() {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            initParallax();
            initCategorySlider();
            initCountdown();
            waitForOwl();
        });
    } else {
        initParallax();
        initCategorySlider();
        initCountdown();
        waitForOwl();
    }
}