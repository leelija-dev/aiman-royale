// ============================================================================
// MULTI-PRODUCT PAGE – FILTERS, SORT, SIDEBAR, ACCORDION
// ============================================================================

document.addEventListener("DOMContentLoaded", function () {

    // ──────────────────────────────────────────────
    //  Mobile Filter Sidebar Controls
    // ──────────────────────────────────────────────
    const filterButton = document.querySelector("#open-filter");
    const sidebar      = document.getElementById("filter-sidebar");
    const overlay      = document.getElementById("filter-overlay");
    const clearButton  = document.querySelector(".text-blue-600.hover\\:underline"); // "Clear all"

    function isMobile() {
        return window.innerWidth < 991;
    }

    function openSidebar() {
        if (!isMobile()) return;
        sidebar.classList.remove("translate-x-[-150%]");
        sidebar.classList.add("translate-x-0");
        overlay.classList.remove("hidden");
        document.body.style.overflow = "hidden";
    }

    function closeSidebar() {
        if (!isMobile()) return;
        sidebar.classList.remove("translate-x-0");
        sidebar.classList.add("translate-x-[-150%]");
        overlay.classList.add("hidden");
        document.body.style.overflow = "";
    }

    if (filterButton) filterButton.addEventListener("click", openSidebar);
    if (overlay)      overlay.addEventListener("click", closeSidebar);

    // Resize handling for sidebar behavior
    window.addEventListener("resize", () => {
        if (isMobile()) {
            sidebar.classList.add("fixed", "translate-x-[-150%]");
            sidebar.classList.remove("relative");
        } else {
            sidebar.classList.remove("fixed", "translate-x-[-150%]", "translate-x-0");
            sidebar.classList.add("relative", "lgg:sticky");
            overlay.classList.add("hidden");
            document.body.style.overflow = "";
        }
    });

    // ──────────────────────────────────────────────
    //  Helper: Parse current URL query params (supports arrays)
    // ──────────────────────────────────────────────
    function getCurrentQueryParams() {
        const params = {};
        const search = window.location.search.substring(1);
        if (!search) return params;

        search.split('&').forEach(pair => {
            const [key, val] = pair.split('=');
            if (!key) return;
            const decodedKey   = decodeURIComponent(key);
            const decodedValue = decodeURIComponent(val || '');

            if (decodedKey.endsWith('[]')) {
                const cleanKey = decodedKey.replace('[]', '');
                if (!params[cleanKey]) params[cleanKey] = [];
                params[cleanKey].push(decodedValue);
            } else {
                params[decodedKey] = decodedValue;
            }
        });
        return params;
    }

    // ──────────────────────────────────────────────
    //  Build URL that combines current filters + sort + page
    // ──────────────────────────────────────────────
    function buildFilterURL() {
        const currentParams = getCurrentQueryParams();
        const form         = document.getElementById("filter-form");
        const sortOption   = document.querySelector('.sort-option.active');
        const sortValue    = sortOption?.dataset.value || currentParams.sort || '';

        const finalParams = new URLSearchParams();

        // 1. Add all checked filters from form
        if (form) {
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                if (value) {
                    finalParams.append(key, value);
                }
            }
        }

        // 2. Keep / set sort
        if (sortValue) {
            finalParams.set('sort', sortValue);
        }

        // 3. Preserve page (if you add pagination later)
        if (currentParams.page) {
            finalParams.set('page', currentParams.page);
        }

        const query = finalParams.toString();
        return query ? `${window.location.pathname}?${query}` : window.location.pathname;
    }

    // ──────────────────────────────────────────────
    //  Apply filters → page reload with correct params
    // ──────────────────────────────────────────────
    function applyFilters() {
        window.location.href = buildFilterURL();
    }

    // Debounced filter apply (prevents too many reloads when clicking fast)
    let filterTimeout;
    document.addEventListener('change', e => {
        if (e.target.classList.contains('filter-checkbox')) {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(applyFilters, 220);
        }
    });

    // ──────────────────────────────────────────────
    //  Sort Dropdown Logic
    // ──────────────────────────────────────────────
    const sortButton = document.getElementById("sort-button");
    const sortMenu   = document.getElementById("sort-menu");
    const sortLabel  = document.getElementById("sort-label");
    const chevron    = document.getElementById("chevron-icon");
    const sortOptions = document.querySelectorAll(".sort-option");

    // Set initial label from active option (if any)
    const initialActive = document.querySelector(".sort-option.active");
    if (initialActive) {
        sortLabel.textContent = initialActive.querySelector("span").textContent.trim();
    }

    // Toggle dropdown
    if (sortButton) {
        sortButton.addEventListener("click", e => {
            e.stopPropagation();
            const willBeOpen = sortMenu.classList.toggle("hidden");
            chevron.classList.toggle("rotate-180", !willBeOpen);
            sortButton.setAttribute("aria-expanded", !willBeOpen);
        });
    }

    // Click on sort option
    sortOptions.forEach(option => {
        option.addEventListener("click", () => {
            // Update active state
            sortOptions.forEach(opt => opt.classList.remove("active"));
            option.classList.add("active");

            // Update checkmarks
            document.querySelectorAll(".checkmark").forEach(m => m.classList.add("opacity-0"));
            option.querySelector(".checkmark").classList.remove("opacity-0");

            // Update button label
            sortLabel.textContent = option.querySelector("span").textContent.trim();

            // Close menu
            sortMenu.classList.add("hidden");
            chevron.classList.remove("rotate-180");
            sortButton.setAttribute("aria-expanded", "false");

            // Apply sort + keep existing filters
            applyFilters();
        });
    });

    // Close sort dropdown when clicking outside
    document.addEventListener("click", e => {
        if (!sortButton?.contains(e.target) && !sortMenu?.contains(e.target)) {
            sortMenu.classList.add("hidden");
            chevron.classList.remove("rotate-180");
            sortButton?.setAttribute("aria-expanded", "false");
        }
    });

    // ESC key → close sort
    document.addEventListener("keydown", e => {
        if (e.key === "Escape" && !sortMenu.classList.contains("hidden")) {
            sortMenu.classList.add("hidden");
            chevron.classList.remove("rotate-180");
            sortButton?.setAttribute("aria-expanded", "false");
            sortButton?.focus();
        }
    });

    // ──────────────────────────────────────────────
    //  Accordion (your original logic – slightly cleaned)
    // ──────────────────────────────────────────────
    setTimeout(() => {
        const accordions = document.querySelectorAll(".accordion-wrapper");

        function toggleContent(content, open) {
            if (open) {
                const height = content.scrollHeight + 32;
                content.style.maxHeight = height + "px";
                content.style.paddingTop = "1rem";
                content.style.paddingBottom = "1rem";
            } else {
                content.style.maxHeight = "0px";
                content.style.paddingTop = "0px";
                content.style.paddingBottom = "0px";
            }
        }

        accordions.forEach((wrapper, index) => {
            const header  = wrapper.querySelector(".flex.justify-between.items-center");
            const content = wrapper.querySelector(".accordion-content-block");
            const chevron = wrapper.querySelector(".accordion-chevron");
            const border  = wrapper.querySelector(".line-border-block");

            content.style.transition = "max-height 0.4s ease, padding-top 0.3s ease, padding-bottom 0.3s ease";
            content.style.overflow   = "hidden";
            border.style.transition  = "width 0.3s ease-in-out";

            // First accordion open by default
            if (index === 0) {
                wrapper.classList.add("active");
                content.style.opacity = "1";
                border.style.width = "100%";
                chevron.style.transform = "rotate(-90deg)";
                toggleContent(content, true);
            } else {
                toggleContent(content, false);
                content.style.opacity = "0";
                border.style.width = "0";
            }

            header.addEventListener("click", () => {
                const isActive = wrapper.classList.contains("active");

                // Close others (accordion group behavior)
                accordions.forEach(other => {
                    if (other !== wrapper && other.classList.contains("active")) {
                        const otherContent = other.querySelector(".accordion-content-block");
                        const otherChevron = other.querySelector(".accordion-chevron");
                        const otherBorder  = other.querySelector(".line-border-block");
                        other.classList.remove("active");
                        toggleContent(otherContent, false);
                        otherContent.style.opacity = "0";
                        otherBorder.style.width = "0";
                        otherChevron.style.transform = "rotate(90deg)";
                    }
                });

                if (isActive) {
                    // Close this one
                    wrapper.classList.remove("active");
                    toggleContent(content, false);
                    content.style.opacity = "0";
                    border.style.width = "0";
                    chevron.style.transform = "rotate(90deg)";
                } else {
                    // Open this one
                    wrapper.classList.add("active");
                    content.style.opacity = "1";
                    border.style.width = "100%";
                    chevron.style.transform = "rotate(-90deg)";
                    toggleContent(content, true);
                }
            });
        });
    }, 300); // small delay to make sure DOM is ready

    // Optional: Clear all filters button
    if (clearButton) {
        clearButton.addEventListener("click", e => {
            e.preventDefault();
            document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = false);
            window.location.href = window.location.pathname;
        });
    }

});