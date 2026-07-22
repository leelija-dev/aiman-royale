document.addEventListener("DOMContentLoaded", function () {
    // DOM Elements
    const filterButton = document.querySelector("#open-filter");
    const sidebar = document.getElementById("filter-sidebar");
    const overlay = document.getElementById("filter-overlay");
    const sideCloseButton = document.getElementById("close-filter");
    const clearAllButton = document.getElementById("clear-all-filters");
    const productsContainer = document.getElementById("products-container");
    const loadingSpinner = document.getElementById("loading-spinner");
    const filterForm = document.getElementById("filter-form");

    // Current filters state
    let currentFilters = {
        categories: [],
        occasions: [],
        colors: [],
        sizes: [],
        price_ranges: [],
        sort: 'date-desc',
        filter: '',
        occasion: 'all',
        collection: 'all',
        search: '',
        has_offer: ''
    };

    // Get search parameter from URL on page load
    function getSearchFromURL() {
        const params = new URLSearchParams(window.location.search);
        return params.get('search') || '';
    }

    // Track if sidebar is open on mobile
    let isSidebarOpen = false;

    sideCloseButton.addEventListener("click", function() {
        closeSidebar();
    });

    // ──────────────────────────────────────────────
    //  Utility Functions
    // ──────────────────────────────────────────────
    function isMobile() {
        return window.innerWidth < 991;
    }

    function showLoading() {
        if (loadingSpinner) loadingSpinner.classList.remove('hidden');
        if (productsContainer) productsContainer.style.opacity = '0.5';
    }

    function hideLoading() {
        if (loadingSpinner) loadingSpinner.classList.add('hidden');
        if (productsContainer) productsContainer.style.opacity = '1';
    }

    // ──────────────────────────────────────────────
    //  Mobile Sidebar Functions
    // ──────────────────────────────────────────────
    function openSidebar() {
        if (!isMobile()) return;
        sidebar.classList.remove("translate-x-[-150%]");
        sidebar.classList.add("translate-x-0");
        overlay.classList.remove("hidden");
        document.body.style.overflow = "hidden";
        isSidebarOpen = true;
    }

    function closeSidebar() {
        if (!isMobile()) return;
        sidebar.classList.remove("translate-x-0");
        sidebar.classList.add("translate-x-[-150%]");
        overlay.classList.add("hidden");
        document.body.style.overflow = "";
        isSidebarOpen = false;
    }

    // Initialize sidebar position based on screen size
    function initSidebarPosition() {
        if (isMobile()) {
            sidebar.classList.add("fixed", "translate-x-[-150%]");
            sidebar.classList.remove("relative", "lgg:sticky", "translate-x-0");
            if (isSidebarOpen) {
                closeSidebar();
            } else {
                sidebar.classList.remove("translate-x-0");
                sidebar.classList.add("translate-x-[-150%]");
                overlay.classList.add("hidden");
                document.body.style.overflow = "";
            }
        } else {
            sidebar.classList.remove("fixed", "translate-x-[-150%]", "translate-x-0");
            sidebar.classList.add("relative", "lgg:sticky");
            overlay.classList.add("hidden");
            document.body.style.overflow = "";
            isSidebarOpen = false;
        }
    }

    if (filterButton) filterButton.addEventListener("click", openSidebar);
    if (overlay) overlay.addEventListener("click", closeSidebar);

    window.addEventListener("resize", function() {
        initSidebarPosition();
    });

    initSidebarPosition();

    // ──────────────────────────────────────────────
    //  API Functions
    // ──────────────────────────────────────────────
    async function fetchFilteredProducts() {
        try {
            showLoading();

            const params = new URLSearchParams();

            if (currentFilters.colors && currentFilters.colors.length > 0) {
                params.append('colors', currentFilters.colors.join(','));
            }

            if (currentFilters.sizes && currentFilters.sizes.length > 0) {
                params.append('sizes', currentFilters.sizes.join(','));
            }

            if (currentFilters.categories && currentFilters.categories.length > 0) {
                params.append('categories', currentFilters.categories.join(','));
            }

            if (currentFilters.occasions && currentFilters.occasions.length > 0) {
                if (!currentFilters.occasions.includes('all')) {
                    params.append('occasions', currentFilters.occasions.join(','));
                }
            }

            if (currentFilters.price_ranges && currentFilters.price_ranges.length > 0) {
                params.append('price_ranges', currentFilters.price_ranges.join(','));
            }

            if (currentFilters.sort && currentFilters.sort !== 'date-desc') {
                params.append('sort', currentFilters.sort);
            }

            if (currentFilters.filter && currentFilters.filter !== 'new-arrival') {
                params.append('filter', currentFilters.filter);
            }

            if (currentFilters.occasion && currentFilters.occasion !== 'all') {
                params.append('occasion', currentFilters.occasion);
            }

            if (currentFilters.collection && currentFilters.collection !== 'all') {
                params.append('collection', currentFilters.collection);
            }

            if (currentFilters.search && currentFilters.search.trim() !== '') {
                params.append('search', currentFilters.search);
            }

            if (currentFilters.has_offer && currentFilters.has_offer === '1') {
                params.append('has_offer', '1');
            }

            console.log('Sending filters to API:', params.toString());

            const url = `/api/products/filter${params.toString() ? '?' + params.toString() : ''}`;
            const response = await fetch(url);
            const data = await response.json();

            console.log('API Response:', data);

            if (data.success) {
                updateProductsGrid(data.data);
                updateSelectedTags();
            }
        } catch (error) {
            console.error('Error fetching products:', error);
        } finally {
            hideLoading();
        }
    }

    function updateProductsGrid(products) {
        if (!productsContainer) return;

        if (!products || products.length === 0) {
            productsContainer.innerHTML = `
            <div class="col-span-full flex flex-col items-center justify-center py-16">
                <div class="text-center">
                    <div class="mb-4">
                        <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No product found</h3>
                    <p class="text-gray-600 mb-6">We couldn't find any products matching your criteria.</p>
                    <button onclick="clearAllFilters()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Clear Filters
                    </button>
                </div>
            </div>
            `;
            return;
        }

        let html = '';
        products.forEach(product => {
            let imageUrl = '/assets/images/placeholder.jpg';

            if (product.images && Array.isArray(product.images) && product.images.length > 0) {
                const firstImage = product.images[0];
                if (firstImage && typeof firstImage === 'object') {
                    imageUrl = firstImage.image || imageUrl;
                } else if (typeof firstImage === 'string') {
                    imageUrl = firstImage;
                }
            } else if (product.image) {
                imageUrl = product.image;
            }

            if (imageUrl && !imageUrl.startsWith('/') && !imageUrl.startsWith('http')) {
                imageUrl = '/' + imageUrl;
            }

            let displayPrice = product.discount_price || product.price || 0;
            let originalPrice = product.price || 0;

            if (product.variants && Array.isArray(product.variants) && product.variants.length > 0) {
                const firstVariant = product.variants[0];
                if (firstVariant) {
                    displayPrice = firstVariant.discount_price || firstVariant.price || displayPrice;
                    originalPrice = firstVariant.price || originalPrice;
                }
            }

            const discountPercentage = displayPrice < originalPrice && originalPrice > 0
                ? Math.round(((originalPrice - displayPrice) / originalPrice) * 100)
                : 0;

            html += `
            <div class="item product-card">
                <a href="/products/${product.slug}" class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                    <div class="image-wrapper">
                        <img src="${imageUrl}" 
                             alt="${product.name || 'Product'}" 
                             class="product-img"
                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'200\' height=\'200\' viewBox=\'0 0 200 200\'%3E%3Crect width=\'200\' height=\'200\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-size=\'14\'%3ENo Image%3C/text%3E%3C/svg%3E'" />
                        
                        <div class="badge-container">
                            ${product.is_featured ? `
                                <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded discount-badge">Featured</span>
                            ` : ''}
                            ${discountPercentage > 0 ? `
                                <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded discount-badge">-${discountPercentage}%</span>
                            ` : ''}
                        </div>
                        
                        <button class="wishlist-btn absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-4 space-y-1">
                        <h3 class="text-[15px] font-semibold text-gray-900 truncate">${product.name || ''}</h3>
                        
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>${product.brand || 'Brand Name'}</span>
                        </div>
                        
                        <div class="flex items-center gap-2 mt-2 flex-wrap">
                            <span class="text-lg font-bold text-gray-900">Rs. ${parseFloat(displayPrice).toFixed(2)}</span>
                            ${displayPrice < originalPrice ? `
                                <span class="text-sm text-gray-400 line-through">Rs. ${parseFloat(originalPrice).toFixed(2)}</span>
                            ` : ''}
                        </div>
                    </div>
                </a>
            </div>
            `;
        });

        productsContainer.innerHTML = html;
    }

    function updateSelectedTags() {
        const container = document.getElementById('selected-tags-container');
        if (!container) return;

        let tags = [];

        Object.entries(currentFilters).forEach(([key, value]) => {
            if (Array.isArray(value) && value.length > 0) {
                value.forEach(v => {
                    let displayKey = key;
                    if (key === 'price_ranges') displayKey = 'price';
                    else if (key.endsWith('s')) displayKey = key.slice(0, -1);

                    tags.push({
                        type: displayKey,
                        value: v,
                        key: key
                    });
                });
            }
        });

        let tagsHtml = '';
        tags.forEach(tag => {
            tagsHtml += `
                <span class="flex items-center gap-1 px-3 py-1 text-sm bg-gray-100 rounded-full">
                    ${tag.type}: ${tag.value}
                    <span class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="removeFilter('${tag.key}', '${tag.value}')">×</span>
                </span>
            `;
        });

        container.innerHTML = tagsHtml;
    }

    // ──────────────────────────────────────────────
    //  Filter Update Functions
    // ──────────────────────────────────────────────
    function updateFilters() {
        if (!filterForm) return;
        
        const formData = new FormData(filterForm);

        const selectedCategories = formData.getAll('category[]');
        const selectedOccasions = formData.getAll('occasions[]');
        const selectedColors = formData.getAll('colors[]');
        const selectedSizes = formData.getAll('sizes[]');
        const selectedPriceRanges = formData.getAll('price_ranges[]');

        const finalOccasions = selectedOccasions.includes('all')
            ? []
            : selectedOccasions;

        currentFilters = {
            ...currentFilters,
            categories: selectedCategories,
            occasions: finalOccasions,
            colors: selectedColors,
            sizes: selectedSizes,
            price_ranges: selectedPriceRanges
        };

        console.log('Updated filters:', currentFilters);
        fetchFilteredProducts();
    }

    // Debounced filter update
    let filterTimeout;
    if (filterForm) {
        filterForm.addEventListener('change', function(e) {
            if (e.target && e.target.classList && e.target.classList.contains('filter-checkbox')) {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(updateFilters, 300);
            }
        });
    }

    // ──────────────────────────────────────────────
    //  Dropdown Management - Closes other dropdowns when opening
    // ──────────────────────────────────────────────
    let currentlyOpenDropdown = null;

    function closeDropdown(menuId, buttonId, chevronId) {
        const menu = document.getElementById(menuId);
        const button = document.getElementById(buttonId);
        const chevron = document.getElementById(chevronId);
        
        if (menu && !menu.classList.contains("hidden")) {
            menu.classList.add("hidden");
            if (chevron) chevron.classList.remove("rotate-180");
            if (button) button.setAttribute("aria-expanded", "false");
        }
    }

    function setupDropdown(dropdownId, menuId, buttonId, chevronId, labelId, optionClass) {
        const menu = document.getElementById(menuId);
        const button = document.getElementById(buttonId);
        const chevron = document.getElementById(chevronId);
        const label = document.getElementById(labelId);
        const options = document.querySelectorAll(`.${optionClass}`);

        if (!menu || !button) return;

        // Initialize dropdown state
        const initializeDropdown = () => {
            options.forEach(opt => {
                const checkmark = opt.querySelector(".checkmark");
                if (checkmark) checkmark.classList.add("opacity-0");
                opt.classList.remove("active");
            });

            const activeOption = Array.from(options).find(opt => opt.classList.contains("active"));
            
            if (activeOption) {
                const checkmark = activeOption.querySelector(".checkmark");
                if (checkmark) checkmark.classList.remove("opacity-0");
                if (label) {
                    label.textContent = activeOption.querySelector("span").textContent.trim();
                }
                const dataValue = activeOption.dataset.value;
                const optionType = optionClass.replace('-option', '');
                currentFilters[optionType] = dataValue;
            } else {
                const defaultOption = Array.from(options).find(opt => 
                    opt.dataset.value === 'all' || 
                    opt.dataset.value === '' || 
                    opt.dataset.value === 'date-desc'
                );
                
                if (defaultOption) {
                    defaultOption.classList.add("active");
                    const checkmark = defaultOption.querySelector(".checkmark");
                    if (checkmark) checkmark.classList.remove("opacity-0");
                    if (label) {
                        label.textContent = defaultOption.querySelector("span").textContent.trim();
                    }
                    const dataValue = defaultOption.dataset.value;
                    const optionType = optionClass.replace('-option', '');
                    currentFilters[optionType] = dataValue;
                }
            }
        };

        initializeDropdown();

        // Button click handler - closes other dropdowns
        button.addEventListener("click", (e) => {
            e.stopPropagation();
            
            // If there's another dropdown open, close it first
            if (currentlyOpenDropdown && currentlyOpenDropdown !== menuId) {
                // Close the other dropdown based on its ID
                if (currentlyOpenDropdown === 'filter-menu') {
                    closeDropdown('filter-menu', 'filter-dropdown-button', 'filter-chevron');
                } else if (currentlyOpenDropdown === 'occasion-menu') {
                    closeDropdown('occasion-menu', 'occasion-dropdown-button', 'occasion-chevron');
                } else if (currentlyOpenDropdown === 'collection-menu') {
                    closeDropdown('collection-menu', 'collection-dropdown-button', 'collection-chevron');
                } else if (currentlyOpenDropdown === 'sort-menu') {
                    closeDropdown('sort-menu', 'sort-button', 'chevron-icon');
                }
            }
            
            // Toggle current dropdown
            const isOpen = !menu.classList.contains("hidden");
            
            if (isOpen) {
                // Close current dropdown
                menu.classList.add("hidden");
                if (chevron) chevron.classList.remove("rotate-180");
                button.setAttribute("aria-expanded", "false");
                currentlyOpenDropdown = null;
            } else {
                // Open current dropdown
                menu.classList.remove("hidden");
                if (chevron) chevron.classList.add("rotate-180");
                button.setAttribute("aria-expanded", "true");
                currentlyOpenDropdown = menuId;
            }
        });

        // Option click handler
        options.forEach(option => {
            option.addEventListener("click", (e) => {
                e.stopPropagation();
                
                const optionType = optionClass.replace('-option', '');
                const dataValue = option.dataset.value;
                
                // Update active state
                options.forEach(opt => {
                    opt.classList.remove("active");
                    const checkmark = opt.querySelector(".checkmark");
                    if (checkmark) checkmark.classList.add("opacity-0");
                });
                
                option.classList.add("active");
                const selectedCheckmark = option.querySelector(".checkmark");
                if (selectedCheckmark) selectedCheckmark.classList.remove("opacity-0");

                // Update label
                if (label) {
                    label.textContent = option.querySelector("span").textContent.trim();
                }
                
                // Handle "all" selection for occasions
                if (dataValue === 'all' && optionType === 'occasion') {
                    document.querySelectorAll('input[name="occasions[]"]').forEach(cb => {
                        cb.checked = false;
                    });
                    currentFilters.occasions = [];
                    updateFilters();
                }
                
                // Update currentFilters
                currentFilters[optionType] = dataValue;

                // Close dropdown
                menu.classList.add("hidden");
                if (chevron) chevron.classList.remove("rotate-180");
                button.setAttribute("aria-expanded", "false");
                currentlyOpenDropdown = null;

                // Fetch filtered products
                fetchFilteredProducts();
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                if (!menu.classList.contains("hidden")) {
                    menu.classList.add("hidden");
                    if (chevron) chevron.classList.remove("rotate-180");
                    button.setAttribute("aria-expanded", "false");
                    if (currentlyOpenDropdown === menuId) {
                        currentlyOpenDropdown = null;
                    }
                }
            }
        });

        // Close dropdown on Escape key
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape" && !menu.classList.contains("hidden")) {
                menu.classList.add("hidden");
                if (chevron) chevron.classList.remove("rotate-180");
                button.setAttribute("aria-expanded", "false");
                button.focus();
                if (currentlyOpenDropdown === menuId) {
                    currentlyOpenDropdown = null;
                }
            }
        });
    }

    // Initialize all dropdowns
    setupDropdown('filter-dropdown-button', 'filter-menu', 'filter-dropdown-button', 'filter-chevron', 'filter-label', 'filter-option');
    setupDropdown('occasion-dropdown-button', 'occasion-menu', 'occasion-dropdown-button', 'occasion-chevron', 'occasion-label', 'occasion-option');
    setupDropdown('collection-dropdown-button', 'collection-menu', 'collection-dropdown-button', 'collection-chevron', 'collection-label', 'collection-option');
    setupDropdown('sort-button', 'sort-menu', 'sort-button', 'chevron-icon', 'sort-label', 'sort-option');

    // ──────────────────────────────────────────────
    //  Accordion Functionality
    // ──────────────────────────────────────────────
    setTimeout(() => {
        const accordions = document.querySelectorAll(".accordion-wrapper");

        function toggleContent(content, open) {
            if (!content) return;
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

            if (!header || !content || !chevron || !border) return;

            content.style.transition = "max-height 0.4s ease, padding-top 0.3s ease, padding-bottom 0.3s ease";
            content.style.overflow = "hidden";
            border.style.transition = "width 0.3s ease-in-out";

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

                accordions.forEach(other => {
                    if (other !== wrapper && other.classList.contains("active")) {
                        const otherContent = other.querySelector(".accordion-content-block");
                        const otherChevron = other.querySelector(".accordion-chevron");
                        const otherBorder = other.querySelector(".line-border-block");
                        if (otherContent && otherChevron && otherBorder) {
                            other.classList.remove("active");
                            toggleContent(otherContent, false);
                            otherContent.style.opacity = "0";
                            otherBorder.style.width = "0";
                            otherChevron.style.transform = "rotate(90deg)";
                        }
                    }
                });

                if (isActive) {
                    wrapper.classList.remove("active");
                    toggleContent(content, false);
                    content.style.opacity = "0";
                    border.style.width = "0";
                    chevron.style.transform = "rotate(90deg)";
                } else {
                    wrapper.classList.add("active");
                    content.style.opacity = "1";
                    border.style.width = "100%";
                    chevron.style.transform = "rotate(-90deg)";
                    toggleContent(content, true);
                }
            });
        });
    }, 300);

    // ──────────────────────────────────────────────
    //  Clear Filters Function
    // ──────────────────────────────────────────────
    window.clearAllFilters = function () {
        document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = false);

        document.querySelectorAll('.filter-option, .occasion-option, .collection-option, .sort-option').forEach(opt => {
            opt.classList.remove('active');
            if (opt.dataset.value === 'all' || opt.dataset.value === 'new-arrival' || opt.dataset.value === 'date-desc') {
                opt.classList.add('active');
                const checkmark = opt.querySelector(".checkmark");
                if (checkmark) checkmark.classList.remove("opacity-0");
            } else {
                const checkmark = opt.querySelector(".checkmark");
                if (checkmark) checkmark.classList.add("opacity-0");
            }
        });

        currentFilters = {
            categories: [],
            occasions: [],
            colors: [],
            sizes: [],
            price_ranges: [],
            sort: 'date-desc',
            filter: 'new-arrival',
            occasion: 'all',
            collection: 'all',
            search: '',
            has_offer: ''
        };

        const filterLabel = document.getElementById('filter-label');
        const occasionLabel = document.getElementById('occasion-label');
        const collectionLabel = document.getElementById('collection-label');
        const sortLabel = document.getElementById('sort-label');

        if (filterLabel) filterLabel.textContent = 'Filter';
        if (occasionLabel) occasionLabel.textContent = 'Occasion';
        if (collectionLabel) collectionLabel.textContent = 'Collection';
        if (sortLabel) sortLabel.textContent = 'Sort by';

        fetchFilteredProducts();
    };

    window.removeFilter = function (key, value) {
        document.querySelectorAll(`input[name="${key}[]"]`).forEach(cb => {
            if (cb.value == value) {
                cb.checked = false;
            }
        });
        updateFilters();
    };

    if (clearAllButton) {
        clearAllButton.addEventListener("click", (e) => {
            e.preventDefault();
            clearAllFilters();
        });
    }

    window.clearFilters = clearAllFilters;

    // Toggle offer filter
    window.toggleOfferFilter = function() {
        currentFilters.has_offer = currentFilters.has_offer === '1' ? '' : '1';
        updateFilters();
    };

    // Initialize search filter from URL
    currentFilters.search = getSearchFromURL();

    // Initial fetch
    fetchFilteredProducts();
});







// document.addEventListener("DOMContentLoaded", function () {
//     // DOM Elements
//     const filterButton = document.querySelector("#open-filter");
//     const sidebar = document.getElementById("filter-sidebar");
//     const overlay = document.getElementById("filter-overlay");
//     const clearAllButton = document.getElementById("clear-all-filters");
//     const productsContainer = document.getElementById("products-container");
//     const loadingSpinner = document.getElementById("loading-spinner");
//     const filterForm = document.getElementById("filter-form");

//     // Current filters state
//     let currentFilters = {
//         categories: [],
//         occasions: [],
//         colors: [],
//         sizes: [],
//         price_ranges: [],
//         sort: 'date-desc',
//         filter: 'new-arrival',
//         occasion: 'all',
//         collection: 'all'
//     };

//     // ──────────────────────────────────────────────
//     //  Utility Functions
//     // ──────────────────────────────────────────────
//     function isMobile() {
//         return window.innerWidth < 991;
//     }

//     function showLoading() {
//         if (loadingSpinner) loadingSpinner.classList.remove('hidden');
//     }

//     function hideLoading() {
//         if (loadingSpinner) loadingSpinner.classList.add('hidden');
//     }

//     // ──────────────────────────────────────────────
//     //  Mobile Sidebar Functions
//     // ──────────────────────────────────────────────
//     function openSidebar() {
//         if (!isMobile()) return;
//         sidebar.classList.remove("translate-x-[-150%]");
//         sidebar.classList.add("translate-x-0");
//         overlay.classList.remove("hidden");
//         document.body.style.overflow = "hidden";
//     }

//     function closeSidebar() {
//         if (!isMobile()) return;
//         sidebar.classList.remove("translate-x-0");
//         sidebar.classList.add("translate-x-[-150%]");
//         overlay.classList.add("hidden");
//         document.body.style.overflow = "";
//     }

//     if (filterButton) filterButton.addEventListener("click", openSidebar);
//     if (overlay) overlay.addEventListener("click", closeSidebar);

//     // Resize handling
//     window.addEventListener("resize", () => {
//         if (isMobile()) {
//             sidebar.classList.add("fixed", "translate-x-[-150%]");
//             sidebar.classList.remove("relative");
//         } else {
//             sidebar.classList.remove("fixed", "translate-x-[-150%]", "translate-x-0");
//             sidebar.classList.add("relative", "lgg:sticky");
//             overlay.classList.add("hidden");
//             document.body.style.overflow = "";
//         }
//     });

//     // ──────────────────────────────────────────────
//     //  API Functions
//     // ──────────────────────────────────────────────
//     async function fetchFilteredProducts() {
//         try {
//             showLoading();

//             // Build query parameters matching API expected format
//             const params = new URLSearchParams();

//             // Map frontend filter names to API expected names
//             // API expects: category_slug=mens-wear&occasion_slug=wedding&color=red&size=M&price_range=1000-5000

//             // Colors - API expects single color? Let's use first selected or comma-separated
//             if (currentFilters.colors && currentFilters.colors.length > 0) {
//                 // If multiple colors, join with commas or use first one
//                 params.append('color', currentFilters.colors.join(','));
//             }

//             // Sizes
//             if (currentFilters.sizes && currentFilters.sizes.length > 0) {
//                 params.append('size', currentFilters.sizes.join(','));
//             }

//             // Categories - API expects category_slug
//             if (currentFilters.categories && currentFilters.categories.length > 0) {
//                 // Convert category names to slugs (lowercase, replace spaces with hyphens)
//                 const categorySlugs = currentFilters.categories.map(cat =>
//                     cat.toLowerCase().replace(/\s+/g, '-')
//                 );
//                 params.append('category_slug', categorySlugs.join(','));
//             }

//             // Occasions - API expects occasion_slug
//             if (currentFilters.occasions && currentFilters.occasions.length > 0) {
//                 // If "all" is selected, don't send any occasion parameter
//                 if (!currentFilters.occasions.includes('all')) {
//                     const occasionSlugs = currentFilters.occasions.map(occ =>
//                         occ.toLowerCase().replace(/\s+/g, '-')
//                     );
//                     params.append('occasion_slug', occasionSlugs.join(','));
//                 }
//             }

//             // Price ranges - API expects price_range like "1000-5000"
//             if (currentFilters.price_ranges && currentFilters.price_ranges.length > 0) {
//                 // Use the first selected price range
//                 params.append('price_range', currentFilters.price_ranges[0]);
//             }

//             // Add dropdown values
//             if (currentFilters.sort && currentFilters.sort !== 'date-desc') {
//                 params.append('sort', currentFilters.sort);
//             }

//             if (currentFilters.filter && currentFilters.filter !== 'new-arrival') {
//                 params.append('filter', currentFilters.filter);
//             }

//             // Only add occasion from dropdown if not 'all'
//             if (currentFilters.occasion && currentFilters.occasion !== 'all') {
//                 const occasionSlug = currentFilters.occasion.toLowerCase().replace(/\s+/g, '-');
//                 params.append('occasion_slug', occasionSlug);
//             }

//             if (currentFilters.collection && currentFilters.collection !== 'all') {
//                 params.append('collection', currentFilters.collection);
//             }

//             console.log('Sending filters to API:', params.toString());

//             const response = await fetch(`/api/products/filter?${params.toString()}`);
//             const data = await response.json();

//             console.log('API Response:', data);

//             if (data.success) {
//                 updateProductsGrid(data.data);
//                 updateSelectedTags();
//             }
//         } catch (error) {
//             console.error('Error fetching products:', error);
//         } finally {
//             hideLoading();
//         }
//     }

//     function updateProductsGrid(products) {
//         if (!productsContainer) return;

//         if (!products || products.length === 0) {
//             productsContainer.innerHTML = `
//             <div class="col-span-full flex flex-col items-center justify-center py-16">
//                 <div class="text-center">
//                     <div class="mb-4">
//                         <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
//                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
//                         </svg>
//                     </div>
//                     <h3 class="text-xl font-semibold text-gray-900 mb-2">No product found</h3>
//                     <p class="text-gray-600 mb-6">We couldn't find any products matching your criteria.</p>
//                     <button onclick="clearAllFilters()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
//                         Clear Filters
//                     </button>
//                 </div>
//             </div>
//         `;
//             return;
//         }

//         let html = '';
//         products.forEach(product => {
//             // Handle image URL
//             let imageUrl = '/assets/images/placeholder.jpg';

//             if (product.images && Array.isArray(product.images) && product.images.length > 0) {
//                 const firstImage = product.images[0];
//                 if (firstImage && typeof firstImage === 'object') {
//                     imageUrl = firstImage.image || imageUrl;
//                 } else if (typeof firstImage === 'string') {
//                     imageUrl = firstImage;
//                 }
//             } else if (product.image) {
//                 imageUrl = product.image;
//             }

//             // Add leading slash if needed
//             if (imageUrl && !imageUrl.startsWith('/') && !imageUrl.startsWith('http')) {
//                 imageUrl = '/' + imageUrl;
//             }

//             // Handle price
//             let displayPrice = product.discount_price || product.price || 0;
//             let originalPrice = product.price || 0;

//             // Check variants
//             if (product.variants && Array.isArray(product.variants) && product.variants.length > 0) {
//                 const firstVariant = product.variants[0];
//                 if (firstVariant) {
//                     displayPrice = firstVariant.discount_price || firstVariant.price || displayPrice;
//                     originalPrice = firstVariant.price || originalPrice;
//                 }
//             }

//             // Calculate discount
//             const discountPercentage = displayPrice < originalPrice && originalPrice > 0
//                 ? Math.round(((originalPrice - displayPrice) / originalPrice) * 100)
//                 : 0;

//             html += `
//             <div class="item  product-card">
//                 <a href="/products/${product.slug}" class="group w-full bg-white xxs:max-w-full max-w-[300px] rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer product-card">
//                     <div class="image-wrapper">
//                         <img src="${imageUrl}" 
//                              alt="${product.name || 'Product'}" 
//                              class="product-img"
//                              onerror="this.src='/assets/images/placeholder.jpg'" />
                        
//                         <div class="badge-container">
//                             ${product.is_featured ? `
//                                 <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded discount-badge">Featured</span>
//                             ` : ''}
//                             ${discountPercentage > 0 ? `
//                                 <span class="bg-primary w-fit text-white text-xs font-semibold px-2 py-1 rounded discount-badge">-${discountPercentage}%</span>
//                             ` : ''}
//                         </div>
                        
//                         <button class="wishlist-btn absolute top-3 right-3 bg-white/80 hover:bg-white rounded-full p-2 shadow-md transition-all hover:scale-110">
//                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-5 h-5 text-red-500">
//                                 <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
//                             </svg>
//                         </button>
//                     </div>
                    
//                     <div class="p-4 space-y-1">
//                         <h3 class="text-[15px] font-semibold text-gray-900">${product.name || ''}</h3>
                        
//                         <div class="flex items-center gap-2 text-sm text-gray-600">
//                             <span>${product.brand || 'Brand Name'}</span>
//                             <span class="flex items-center gap-1 text-gray-700">
//                                 <span class="text-sm font-medium">4.4</span>
//                             </span>
//                         </div>
                        
//                         <div class="flex items-center gap-2 mt-2 flex-wrap">
//                             <span class="text-lg font-bold text-gray-900">Rs. ${parseFloat(displayPrice).toFixed(2)}</span>
//                             ${displayPrice < originalPrice ? `
//                                 <span class="text-sm text-gray-400 line-through">Rs. ${parseFloat(originalPrice).toFixed(2)}</span>
//                             ` : ''}
//                         </div>
                        
//                         <div class="lgg:hidden block">
//                             <button class="px-4 py-1 bg-white border-secondary border-[1px] rounded-md w-full">Add</button>
//                         </div>
//                     </div>
//                 </a>
//             </div>
//         `;
//         });

//         productsContainer.innerHTML = html;
//     }

//     function updateSelectedTags() {
//         const container = document.getElementById('selected-tags-container');
//         if (!container) return;

//         let tags = [];

//         // Collect all selected values
//         Object.entries(currentFilters).forEach(([key, value]) => {
//             if (Array.isArray(value) && value.length > 0) {
//                 value.forEach(v => {
//                     let displayKey = key;
//                     if (key === 'price_ranges') displayKey = 'price';
//                     else if (key.endsWith('s')) displayKey = key.slice(0, -1);

//                     tags.push({
//                         type: displayKey,
//                         value: v,
//                         key: key
//                     });
//                 });
//             }
//         });

//         // Generate HTML for tags
//         let tagsHtml = '';
//         tags.forEach(tag => {
//             tagsHtml += `
//                 <span class="flex items-center gap-1 px-3 py-1 text-sm bg-gray-100 rounded-full">
//                     ${tag.type}: ${tag.value}
//                     <span class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="removeFilter('${tag.key}', '${tag.value}')">×</span>
//                 </span>
//             `;
//         });

//         container.innerHTML = tagsHtml;
//     }

//     // ──────────────────────────────────────────────
//     //  Filter Update Functions
//     // ──────────────────────────────────────────────
//     function updateFilters() {
//         // Update currentFilters from form inputs
//         const formData = new FormData(filterForm);

//         // Get selected values
//         const selectedCategories = formData.getAll('category[]');
//         const selectedOccasions = formData.getAll('occasions[]');
//         const selectedColors = formData.getAll('colors[]');
//         const selectedSizes = formData.getAll('sizes[]');
//         const selectedPriceRanges = formData.getAll('price_ranges[]');

//         // If "all" is selected with other options, filter it out
//         // Usually "all" should be exclusive
//         const finalOccasions = selectedOccasions.includes('all')
//             ? [] // Send empty array when "all" is selected
//             : selectedOccasions;

//         currentFilters = {
//             ...currentFilters,
//             categories: selectedCategories,
//             occasions: finalOccasions,
//             colors: selectedColors,
//             sizes: selectedSizes,
//             price_ranges: selectedPriceRanges
//         };

//         console.log('Updated filters:', currentFilters);
//         fetchFilteredProducts();
//     }

//     // Debounced filter update
//     let filterTimeout;
//     if (filterForm) {
//         filterForm.addEventListener('change', e => {
//             if (e.target.classList.contains('filter-checkbox')) {
//                 clearTimeout(filterTimeout);
//                 filterTimeout = setTimeout(updateFilters, 300);
//             }
//         });
//     }

//     // ──────────────────────────────────────────────
//     //  Dropdown Management
//     // ──────────────────────────────────────────────
//     let openDropdowns = [];

//     function closeAllDropdowns(exceptId = null) {
//         openDropdowns.forEach(dropdownId => {
//             if (dropdownId !== exceptId) {
//                 const menu = document.getElementById(dropdownId);
//                 const button = document.querySelector(`[aria-controls="${dropdownId}"]`);
//                 const chevron = button?.querySelector('.transition-transform');

//                 if (menu) {
//                     menu.classList.add("hidden");
//                 }
//                 if (chevron) {
//                     chevron.classList.remove("rotate-180");
//                 }
//                 if (button) {
//                     button.setAttribute("aria-expanded", "false");
//                 }
//             }
//         });

//         openDropdowns = exceptId ? [exceptId] : [];
//     }

//   function setupDropdown(dropdownId, menuId, buttonId, chevronId, labelId, optionClass) {
//     const menu = document.getElementById(menuId);
//     const button = document.getElementById(buttonId);
//     const chevron = document.getElementById(chevronId);
//     const label = document.getElementById(labelId);
//     const options = document.querySelectorAll(`.${optionClass}`);

//     if (!menu || !button) return;

//     if (button && menuId) {
//         button.setAttribute('aria-controls', menuId);
//     }

//     // Initialize - ensure only one active option has checkmark visible
//     const initializeDropdown = () => {
//         // First, hide all checkmarks
//         options.forEach(opt => {
//             const checkmark = opt.querySelector(".checkmark");
//             if (checkmark) checkmark.classList.add("opacity-0");
//             opt.classList.remove("active");
//         });

//         // Find the active option (should be only one)
//         const activeOption = Array.from(options).find(opt => opt.classList.contains("active"));
        
//         if (activeOption) {
//             // Show checkmark for active option
//             const checkmark = activeOption.querySelector(".checkmark");
//             if (checkmark) checkmark.classList.remove("opacity-0");
            
//             // Update label
//             if (label) {
//                 label.textContent = activeOption.querySelector("span").textContent.trim();
//             }
            
//             // Update currentFilters
//             const dataValue = activeOption.dataset.value;
//             const optionType = optionClass.replace('-option', '');
//             currentFilters[optionType] = dataValue;
//         } else {
//             // If no active option, set default based on option type
//             const defaultOption = Array.from(options).find(opt => 
//                 opt.dataset.value === 'all' || 
//                 opt.dataset.value === 'new-arrival' || 
//                 opt.dataset.value === 'date-desc'
//             );
            
//             if (defaultOption) {
//                 defaultOption.classList.add("active");
//                 const checkmark = defaultOption.querySelector(".checkmark");
//                 if (checkmark) checkmark.classList.remove("opacity-0");
                
//                 if (label) {
//                     label.textContent = defaultOption.querySelector("span").textContent.trim();
//                 }
                
//                 const dataValue = defaultOption.dataset.value;
//                 const optionType = optionClass.replace('-option', '');
//                 currentFilters[optionType] = dataValue;
//             }
//         }
//     };

//     // Run initialization
//     initializeDropdown();

//     button.addEventListener("click", e => {
//         e.stopPropagation();
//         const isCurrentlyOpen = !menu.classList.contains("hidden");
        
//         if (!isCurrentlyOpen) {
//             closeAllDropdowns(menuId);
//         }
        
//         const willBeOpen = menu.classList.toggle("hidden");
//         if (chevron) chevron.classList.toggle("rotate-180", !willBeOpen);
//         button.setAttribute("aria-expanded", !willBeOpen);
        
//         if (!willBeOpen && !openDropdowns.includes(menuId)) {
//             openDropdowns.push(menuId);
//         } else {
//             openDropdowns = openDropdowns.filter(id => id !== menuId);
//         }
//     });

//     options.forEach(option => {
//         option.addEventListener("click", (e) => {
//             e.stopPropagation();
            
//             // Get the option type
//             const optionType = optionClass.replace('-option', '');
//             const dataValue = option.dataset.value;
            
//             // Remove active class and hide checkmark from ALL options in this dropdown
//             options.forEach(opt => {
//                 opt.classList.remove("active");
//                 const checkmark = opt.querySelector(".checkmark");
//                 if (checkmark) checkmark.classList.add("opacity-0");
//             });
            
//             // Add active class to selected option
//             option.classList.add("active");
            
//             // Show checkmark for selected option
//             const selectedCheckmark = option.querySelector(".checkmark");
//             if (selectedCheckmark) selectedCheckmark.classList.remove("opacity-0");

//             // Update button label
//             if (label) {
//                 label.textContent = option.querySelector("span").textContent.trim();
//             }
            
//             // If selecting "all", clear checkbox selections for that category
//             if (dataValue === 'all') {
//                 if (optionType === 'occasion') {
//                     // Uncheck all occasion checkboxes
//                     document.querySelectorAll('input[name="occasions[]"]').forEach(cb => {
//                         cb.checked = false;
//                     });
//                     currentFilters.occasions = [];
//                 } else if (optionType === 'collection') {
//                     // Handle collection if needed
//                 }
//             }
            
//             // Update currentFilters
//             currentFilters[optionType] = dataValue;

//             // Close this specific dropdown
//             menu.classList.add("hidden");
//             if (chevron) chevron.classList.remove("rotate-180");
//             button.setAttribute("aria-expanded", "false");
            
//             // Remove from open dropdowns
//             openDropdowns = openDropdowns.filter(id => id !== menuId);

//             // Fetch filtered products
//             fetchFilteredProducts();
//         });
//     });

//     // Close dropdown when clicking outside
//     document.addEventListener("click", (e) => {
//         if (!button.contains(e.target) && !menu.contains(e.target)) {
//             menu.classList.add("hidden");
//             if (chevron) chevron.classList.remove("rotate-180");
//             button.setAttribute("aria-expanded", "false");
//             openDropdowns = openDropdowns.filter(id => id !== menuId);
//         }
//     });

//     // Close dropdown on Escape key
//     document.addEventListener("keydown", (e) => {
//         if (e.key === "Escape" && !menu.classList.contains("hidden")) {
//             menu.classList.add("hidden");
//             if (chevron) chevron.classList.remove("rotate-180");
//             button.setAttribute("aria-expanded", "false");
//             button.focus();
//             openDropdowns = openDropdowns.filter(id => id !== menuId);
//         }
//     });
// }

//     // Initialize dropdowns
//     setupDropdown('filter-dropdown-button', 'filter-menu', 'filter-dropdown-button', 'filter-chevron', 'filter-label', 'filter-option');
//     setupDropdown('occasion-dropdown-button', 'occasion-menu', 'occasion-dropdown-button', 'occasion-chevron', 'occasion-label', 'occasion-option');
//     setupDropdown('collection-dropdown-button', 'collection-menu', 'collection-dropdown-button', 'collection-chevron', 'collection-label', 'collection-option');
//     setupDropdown('sort-button', 'sort-menu', 'sort-button', 'chevron-icon', 'sort-label', 'sort-option');

//     // ──────────────────────────────────────────────
//     //  Accordion Functionality
//     // ──────────────────────────────────────────────
//     setTimeout(() => {
//         const accordions = document.querySelectorAll(".accordion-wrapper");

//         function toggleContent(content, open) {
//             if (!content) return;
//             if (open) {
//                 const height = content.scrollHeight + 32;
//                 content.style.maxHeight = height + "px";
//                 content.style.paddingTop = "1rem";
//                 content.style.paddingBottom = "1rem";
//             } else {
//                 content.style.maxHeight = "0px";
//                 content.style.paddingTop = "0px";
//                 content.style.paddingBottom = "0px";
//             }
//         }

//         accordions.forEach((wrapper, index) => {
//             const header = wrapper.querySelector(".flex.justify-between.items-center");
//             const content = wrapper.querySelector(".accordion-content-block");
//             const chevron = wrapper.querySelector(".accordion-chevron");
//             const border = wrapper.querySelector(".line-border-block");

//             if (!header || !content || !chevron || !border) return;

//             content.style.transition = "max-height 0.4s ease, padding-top 0.3s ease, padding-bottom 0.3s ease";
//             content.style.overflow = "hidden";
//             border.style.transition = "width 0.3s ease-in-out";

//             if (index === 0) {
//                 wrapper.classList.add("active");
//                 content.style.opacity = "1";
//                 border.style.width = "100%";
//                 chevron.style.transform = "rotate(-90deg)";
//                 toggleContent(content, true);
//             } else {
//                 toggleContent(content, false);
//                 content.style.opacity = "0";
//                 border.style.width = "0";
//             }

//             header.addEventListener("click", () => {
//                 const isActive = wrapper.classList.contains("active");

//                 accordions.forEach(other => {
//                     if (other !== wrapper && other.classList.contains("active")) {
//                         const otherContent = other.querySelector(".accordion-content-block");
//                         const otherChevron = other.querySelector(".accordion-chevron");
//                         const otherBorder = other.querySelector(".line-border-block");
//                         if (otherContent && otherChevron && otherBorder) {
//                             other.classList.remove("active");
//                             toggleContent(otherContent, false);
//                             otherContent.style.opacity = "0";
//                             otherBorder.style.width = "0";
//                             otherChevron.style.transform = "rotate(90deg)";
//                         }
//                     }
//                 });

//                 if (isActive) {
//                     wrapper.classList.remove("active");
//                     toggleContent(content, false);
//                     content.style.opacity = "0";
//                     border.style.width = "0";
//                     chevron.style.transform = "rotate(90deg)";
//                 } else {
//                     wrapper.classList.add("active");
//                     content.style.opacity = "1";
//                     border.style.width = "100%";
//                     chevron.style.transform = "rotate(-90deg)";
//                     toggleContent(content, true);
//                 }
//             });
//         });
//     }, 300);

//     // ──────────────────────────────────────────────
//     //  Clear Filters Function
//     // ──────────────────────────────────────────────
//     window.clearAllFilters = function () {
//         // Uncheck all checkboxes
//         document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = false);

//         // Reset dropdowns to defaults
//         document.querySelectorAll('.filter-option, .occasion-option, .collection-option, .sort-option').forEach(opt => {
//             opt.classList.remove('active');
//             if (opt.dataset.value === 'all' || opt.dataset.value === 'new-arrival' || opt.dataset.value === 'date-desc') {
//                 opt.classList.add('active');
//                 const checkmark = opt.querySelector(".checkmark");
//                 if (checkmark) checkmark.classList.remove("opacity-0");
//             } else {
//                 const checkmark = opt.querySelector(".checkmark");
//                 if (checkmark) checkmark.classList.add("opacity-0");
//             }
//         });

//         // Reset currentFilters
//         currentFilters = {
//             categories: [],
//             occasions: [], // Empty array instead of ['all']
//             colors: [],
//             sizes: [],
//             price_ranges: [],
//             sort: 'date-desc',
//             filter: 'new-arrival',
//             occasion: 'all',
//             collection: 'all'
//         };

//         // Update labels
//         const filterLabel = document.getElementById('filter-label');
//         const occasionLabel = document.getElementById('occasion-label');
//         const collectionLabel = document.getElementById('collection-label');
//         const sortLabel = document.getElementById('sort-label');

//         if (filterLabel) filterLabel.textContent = 'Filter';
//         if (occasionLabel) occasionLabel.textContent = 'Occasion';
//         if (collectionLabel) collectionLabel.textContent = 'Collection';
//         if (sortLabel) sortLabel.textContent = 'Sort by';

//         fetchFilteredProducts();
//     };

//     window.removeFilter = function (key, value) {
//         // Find and uncheck the corresponding checkbox
//         document.querySelectorAll(`input[name="${key}[]"]`).forEach(cb => {
//             if (cb.value === value) {
//                 cb.checked = false;
//             }
//         });

//         updateFilters();
//     };

//     if (clearAllButton) {
//         clearAllButton.addEventListener("click", (e) => {
//             e.preventDefault();
//             clearAllFilters();
//         });
//     }

//     // Make functions globally available
//     window.clearFilters = clearAllFilters;

//     // Initial fetch to ensure filters are applied
//     fetchFilteredProducts();
// });