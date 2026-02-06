// ============================================================================
// MULTI-PRODUCT PAGE – FILTERS, SORT, SIDEBAR, ACCORDION
// ============================================================================

document.addEventListener("DOMContentLoaded", function () {
    // ──────────────────────────────────────────────
    //  Mobile Filter Sidebar Controls
    // ──────────────────────────────────────────────
    const filterButton = document.querySelector("#open-filter");
    const sidebar = document.getElementById("filter-sidebar");
    const overlay = document.getElementById("filter-overlay");
    const clearButton = document.querySelector(".text-blue-600.hover\\:underline"); // "Clear all"

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
    if (overlay) overlay.addEventListener("click", closeSidebar);

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
            const decodedKey = decodeURIComponent(key);
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
        const form = document.getElementById("filter-form");
        const sortOption = document.querySelector('.sort-option.active');
        const filterOption = document.querySelector('.filter-option.active');
        const occasionOption = document.querySelector('.occasion-option.active');
        const collectionOption = document.querySelector('.collection-option.active');

        const sortValue = sortOption?.dataset.value || currentParams.sort || '';
        const filterValue = filterOption?.dataset.value || currentParams.filter || '';
        const occasionValue = occasionOption?.dataset.value || currentParams.occasion || '';
        const collectionValue = collectionOption?.dataset.value || currentParams.collection || '';

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

        // 2. Add dropdown values
        if (sortValue) finalParams.set('sort', sortValue);
        if (filterValue) finalParams.set('filter', filterValue);
        if (occasionValue) finalParams.set('occasion', occasionValue);
        if (collectionValue) finalParams.set('collection', collectionValue);

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

    // Debounced filter apply
    let filterTimeout;
    document.addEventListener('change', e => {
        if (e.target.classList.contains('filter-checkbox')) {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(applyFilters, 220);
        }
    });

    // ──────────────────────────────────────────────
    //  Track all open dropdowns
    // ──────────────────────────────────────────────
    let openDropdowns = [];

    function closeAllDropdowns(exceptId = null) {
        openDropdowns.forEach(dropdownId => {
            if (dropdownId !== exceptId) {
                const menu = document.getElementById(dropdownId);
                const button = document.querySelector(`[aria-controls="${dropdownId}"]`) || 
                               document.querySelector(`[aria-labelledby="${dropdownId}"]`)?.previousElementSibling;
                const chevron = button?.querySelector('.transition-transform');
                
                if (menu) {
                    menu.classList.add("hidden");
                }
                if (chevron) {
                    chevron.classList.remove("rotate-180");
                }
                if (button) {
                    button.setAttribute("aria-expanded", "false");
                }
            }
        });
        
        // Update openDropdowns array
        if (exceptId) {
            openDropdowns = [exceptId];
        } else {
            openDropdowns = [];
        }
    }

    // ──────────────────────────────────────────────
    //  Generic Dropdown Handler Function
    // ──────────────────────────────────────────────
    function setupDropdown(dropdownId, menuId, buttonId, chevronId, labelId, optionClass) {
        const dropdown = document.getElementById(dropdownId);
        const menu = document.getElementById(menuId);
        const button = document.getElementById(buttonId);
        const chevron = document.getElementById(chevronId);
        const label = document.getElementById(labelId);
        const options = document.querySelectorAll(`.${optionClass}`);

        // Set aria-controls for button to track dropdown
        if (button && menuId) {
            button.setAttribute('aria-controls', menuId);
        }

        // Set initial label from active option
        const initialActive = document.querySelector(`.${optionClass}.active`);
        if (initialActive && label) {
            label.textContent = initialActive.querySelector("span").textContent.trim();
        }

        // Toggle dropdown
        if (button) {
            button.addEventListener("click", e => {
                e.stopPropagation();
                const isCurrentlyOpen = !menu.classList.contains("hidden");
                
                // Close all other dropdowns first
                if (!isCurrentlyOpen) {
                    closeAllDropdowns(menuId);
                }
                
                // Toggle this dropdown
                const willBeOpen = menu.classList.toggle("hidden");
                if (chevron) chevron.classList.toggle("rotate-180", !willBeOpen);
                button.setAttribute("aria-expanded", !willBeOpen);
                
                // Update tracking
                if (!willBeOpen) {
                    // Adding to open dropdowns
                    if (!openDropdowns.includes(menuId)) {
                        openDropdowns.push(menuId);
                    }
                } else {
                    // Removing from open dropdowns
                    openDropdowns = openDropdowns.filter(id => id !== menuId);
                }
            });
        }

        // Click on option
        options.forEach(option => {
            option.addEventListener("click", () => {
                // Update active state
                options.forEach(opt => opt.classList.remove("active"));
                option.classList.add("active");

                // Update checkmarks
                option.parentElement.querySelectorAll(".checkmark").forEach(m => m.classList.add("opacity-0"));
                option.querySelector(".checkmark").classList.remove("opacity-0");

                // Update button label
                if (label) {
                    label.textContent = option.querySelector("span").textContent.trim();
                }

                // Close all dropdowns including this one
                closeAllDropdowns();

                // Apply filter
                applyFilters();
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", e => {
            if (!button?.contains(e.target) && !menu?.contains(e.target)) {
                menu.classList.add("hidden");
                if (chevron) chevron.classList.remove("rotate-180");
                button?.setAttribute("aria-expanded", "false");
                
                // Remove from open dropdowns
                openDropdowns = openDropdowns.filter(id => id !== menuId);
            }
        });

        // ESC key → close dropdown
        document.addEventListener("keydown", e => {
            if (e.key === "Escape" && !menu.classList.contains("hidden")) {
                menu.classList.add("hidden");
                if (chevron) chevron.classList.remove("rotate-180");
                button?.setAttribute("aria-expanded", "false");
                button?.focus();
                
                // Remove from open dropdowns
                openDropdowns = openDropdowns.filter(id => id !== menuId);
            }
        });
    }

    // ──────────────────────────────────────────────
    //  Initialize all dropdowns
    // ──────────────────────────────────────────────
    setupDropdown('filter-dropdown-button', 'filter-menu', 'filter-dropdown-button', 'filter-chevron', 'filter-label', 'filter-option');
    setupDropdown('occasion-dropdown-button', 'occasion-menu', 'occasion-dropdown-button', 'occasion-chevron', 'occasion-label', 'occasion-option');
    setupDropdown('collection-dropdown-button', 'collection-menu', 'collection-dropdown-button', 'collection-chevron', 'collection-label', 'collection-option');
    setupDropdown('sort-button', 'sort-menu', 'sort-button', 'chevron-icon', 'sort-label', 'sort-option');

    // ──────────────────────────────────────────────
    //  Close all dropdowns when clicking anywhere outside
    // ──────────────────────────────────────────────
    document.addEventListener('click', function(e) {
        // Check if click is outside any dropdown button or menu
        const isClickInsideDropdown = 
            e.target.closest('#filter-dropdown-button') ||
            e.target.closest('#filter-menu') ||
            e.target.closest('#occasion-dropdown-button') ||
            e.target.closest('#occasion-menu') ||
            e.target.closest('#collection-dropdown-button') ||
            e.target.closest('#collection-menu') ||
            e.target.closest('#sort-button') ||
            e.target.closest('#sort-menu');
        
        if (!isClickInsideDropdown) {
            closeAllDropdowns();
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
            const header = wrapper.querySelector(".flex.justify-between.items-center");
            const content = wrapper.querySelector(".accordion-content-block");
            const chevron = wrapper.querySelector(".accordion-chevron");
            const border = wrapper.querySelector(".line-border-block");

            content.style.transition = "max-height 0.4s ease, padding-top 0.3s ease, padding-bottom 0.3s ease";
            content.style.overflow = "hidden";
            border.style.transition = "width 0.3s ease-in-out";

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
                        const otherBorder = other.querySelector(".line-border-block");
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

    // Clear filters function for "No Products Found" section
    window.clearFilters = function () {
        document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = false);
        // Also reset dropdowns to "All"
        document.querySelectorAll('.filter-option, .occasion-option, .collection-option, .sort-option').forEach(opt => {
            opt.classList.remove('active');
            if (opt.dataset.value === 'all' || opt.dataset.value === 'new-arrival' || opt.dataset.value === 'date-desc') {
                opt.classList.add('active');
                opt.querySelector(".checkmark")?.classList.remove("opacity-0");
            } else {
                opt.querySelector(".checkmark")?.classList.add("opacity-0");
            }
        });
        window.location.href = window.location.pathname;
    };
});