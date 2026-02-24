@extends('layout.web.main-layout')

@section('content')
<section class="px-4 lg:pb-12 pb-6 lg:pt-6 pt-4">
  <div class="container mx-auto">
    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Filters Sidebar -->
      <div class="lg:w-1/4 w-full">
        <div class="bg-white rounded-xl shadow-sm p-6 sticky top-4">
          <h2 class="text-xl font-bold text-gray-900 mb-4">Filters</h2>
          
           <!-- Occasion Filter -->
          @if(isset($occasions) && $occasions->isNotEmpty())
          <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Occasion</h3>
            <div class="space-y-2">
              @foreach($occasions as $occasion)
              <label class="flex items-center space-x-2 cursor-pointer">
                <input 
                  type="checkbox" 
                  name="occasion[]" 
                  value="{{ $occasion->id }}"
                  class="occasion-filter rounded border-gray-300 text-primary focus:ring-primary filter-checkbox"
                >
                <span class="text-sm text-gray-700">{{ $occasion->name }}</span>
              </label>
              @endforeach
            </div>
          </div>
          @endif

          <!-- Custom Price Range Slider (Optional - can keep or remove) -->
          {{-- <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Custom Price Range</h3>
            <div class="space-y-3">
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Rs. <span id="min-price-display">{{ number_format($priceRange['min']) }}</span></span>
                <span class="text-sm text-gray-600">Rs. <span id="max-price-display">{{ number_format($priceRange['max']) }}</span></span>
              </div>
              <input 
                type="range" 
                id="min-price" 
                min="{{ $priceRange['min'] }}" 
                max="{{ $priceRange['max'] }}" 
                value="{{ $priceRange['min'] }}"
                class="w-full accent-primary"
              >
              <input 
                type="range" 
                id="max-price" 
                min="{{ $priceRange['min'] }}" 
                max="{{ $priceRange['max'] }}" 
                value="{{ $priceRange['max'] }}"
                class="w-full accent-primary"
              >
            </div>
          </div> --}}

          <!-- Size Filter -->
          @if(isset($sizes) && $sizes->isNotEmpty())
          <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Size</h3>
            <div class="space-y-2">
              @foreach($sizes as $size)
              
              @php
                $sizeId = is_object($size) ? $size->id : $size;
                $sizeName = is_object($size) ? $size->name : $size;
                $sizeCode = is_object($size) && isset($size->code) ? $size->code : '';
                $displayText = $sizeCode ? "$sizeCode" : $sizeName;
              @endphp
              <label class="flex items-center space-x-2 cursor-pointer">
                <input 
                  type="checkbox" 
                  name="size[]" 
                  value="{{ $displayText }}"
                  class="size-filter rounded border-gray-300 text-primary focus:ring-primary filter-checkbox"
                >
                <span class="text-sm text-gray-700">{{ $displayText }}</span>
              </label>
              @endforeach
            </div>
          </div>
          @endif

          <!-- Color Filter -->
          @if(isset($colors) && $colors->isNotEmpty())
          <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Color</h3>
            <div class="space-y-2">
              @foreach($colors as $color)
              @php
                $colorId = is_object($color) ? $color->id : $color;
                $colorName = is_object($color) ? $color->name : $color;
              @endphp
              <label class="flex items-center space-x-2 cursor-pointer">
                <input 
                  type="checkbox" 
                  name="color[]" 
                  value="{{ $colorId }}"
                  class="color-filter rounded border-gray-300 text-primary focus:ring-primary filter-checkbox"
                >
                <span class="text-sm text-gray-700">{{ $colorName }}</span>
              </label>
              @endforeach
            </div>
          </div>
          @endif

         
          <!-- Price Range Filter - Dynamic from Product Variants -->
          <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Price</h3>
            <div class="space-y-2">
              @foreach($priceRanges as $range)
              <label class="flex items-center space-x-2 cursor-pointer">
                <input 
                  type="checkbox" 
                  name="price_range[]" 
                  value="{{ $range['value'] }}"
                  class="price-range-filter rounded border-gray-300 text-primary focus:ring-primary filter-checkbox"
                >
                <span class="text-sm text-gray-700">{{ $range['label'] }}</span>
              </label>
              @endforeach
            </div>
          </div>

          <!-- Active Filters Display -->
          <div id="active-filters" class="mb-4 hidden">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Active Filters:</h4>
            <div id="filter-tags" class="flex flex-wrap gap-2"></div>
          </div>

          <!-- Filter Actions -->
          <div class="flex gap-2 mt-4">
            <button 
              id="clear-filters" 
              class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors"
            >
              Clear Filters
            </button>
          </div>
        </div>
      </div>

      <!-- Products Grid -->
      <div class="lg:w-3/4 w-full">
        <!-- Category Header -->
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">
            {{ $category->name ?? 'Products' }}
          </h1>
          @if(isset($category->description))
            <p class="text-gray-600">{{ $category->description }}</p>
          @endif
        </div>

        <!-- Products Count -->
        {{-- <div id="products-count" class="mb-4 text-sm text-gray-600">
          Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
        </div> --}}

        <!-- Products Container -->
        <div id="products-container" class="w-full grid xl:grid-cols-3 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-6">
          @include('web.partials.category-grid', ['products' => $products])
        </div>

        <!-- Loading Spinner -->
        <div id="loading-spinner" class="hidden text-center py-8">
          <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-primary border-t-transparent"></div>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="mt-8">
          {{ $products->links() }}
        </div>
        @endif
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize filters
    let currentFilters = {
        priceRanges: [],
        customPrice: { min: {{ $priceRange['min'] }}, max: {{ $priceRange['max'] }} },
        sizes: [],
        colors: [],
        occasions: []
    };

    let filterTimeout;
    let isLoading = false;

    // DOM Elements
    const productsContainer = document.getElementById('products-container');
    const loadingSpinner = document.getElementById('loading-spinner');
    const productsCountDiv = document.getElementById('products-count');
    
    // Price range elements
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    const minPriceDisplay = document.getElementById('min-price-display');
    const maxPriceDisplay = document.getElementById('max-price-display');

    // Update price displays
    function updatePriceDisplay() {
        minPriceDisplay.textContent = Number(minPriceInput.value).toLocaleString();
        maxPriceDisplay.textContent = Number(maxPriceInput.value).toLocaleString();
        currentFilters.customPrice.min = parseInt(minPriceInput.value);
        currentFilters.customPrice.max = parseInt(maxPriceInput.value);
    }

    // Ensure min doesn't exceed max and vice versa
    if (minPriceInput && maxPriceInput) {
        minPriceInput.addEventListener('input', function() {
            if (parseInt(this.value) > parseInt(maxPriceInput.value)) {
                this.value = maxPriceInput.value;
            }
            updatePriceDisplay();
            debouncedFilter();
        });

        maxPriceInput.addEventListener('input', function() {
            if (parseInt(this.value) < parseInt(minPriceInput.value)) {
                this.value = minPriceInput.value;
            }
            updatePriceDisplay();
            debouncedFilter();
        });
    }

    // Collect filter values
    function collectFilters() {
        // Price ranges
        currentFilters.priceRanges = Array.from(document.querySelectorAll('.price-range-filter:checked')).map(cb => cb.value);
        
        // Sizes
        currentFilters.sizes = Array.from(document.querySelectorAll('.size-filter:checked')).map(cb => cb.value);
        
        // Colors
        currentFilters.colors = Array.from(document.querySelectorAll('.color-filter:checked')).map(cb => cb.value);
        
        // Occasions
        currentFilters.occasions = Array.from(document.querySelectorAll('.occasion-filter:checked')).map(cb => cb.value);
    }

    // Convert price range to min/max values (now handles dynamic ranges)
    function getPriceRangeValues(range) {
        // Handle dynamic range format (min-max)
        if (range.includes('-')) {
            const [min, max] = range.split('-').map(Number);
            return { min, max };
        }
        
        // Fallback for old hardcoded ranges
        switch(range) {
            case 'below-200':
                return { min: 0, max: 200 };
            case '200-300':
                return { min: 200, max: 300 };
            case '300-400':
                return { min: 300, max: 400 };
            case '400-500':
                return { min: 400, max: 500 };
            case '500-600':
                return { min: 500, max: 600 };
            case '600-above':
                return { min: 600, max: 999999 };
            default:
                return null;
        }
    }

    // Update active filters display
    function updateActiveFiltersDisplay() {
        const activeFiltersDiv = document.getElementById('active-filters');
        const filterTagsDiv = document.getElementById('filter-tags');
        
        const activeFilters = [];
        
        // Add price range filters
        document.querySelectorAll('.price-range-filter:checked').forEach(cb => {
            const label = cb.closest('label').querySelector('span').textContent;
            activeFilters.push({
                type: 'price',
                text: label,
                value: cb.value
            });
        });
        
        // Add custom price if different from default
        if (currentFilters.customPrice.min > {{ $priceRange['min'] }} || currentFilters.customPrice.max < {{ $priceRange['max'] }}) {
            activeFilters.push({
                type: 'custom-price',
                text: `Rs. ${currentFilters.customPrice.min} - Rs. ${currentFilters.customPrice.max}`
            });
        }
        
        // Add size filters
        document.querySelectorAll('.size-filter:checked').forEach(cb => {
            const label = cb.closest('label').querySelector('span').textContent;
            activeFilters.push({
                type: 'size',
                text: label,
                value: cb.value
            });
        });
        
        // Add color filters
        document.querySelectorAll('.color-filter:checked').forEach(cb => {
            const label = cb.closest('label').querySelector('span').textContent;
            activeFilters.push({
                type: 'color',
                text: label,
                value: cb.value
            });
        });
        
        // Add occasion filters
        document.querySelectorAll('.occasion-filter:checked').forEach(cb => {
            const label = cb.closest('label').querySelector('span').textContent;
            activeFilters.push({
                type: 'occasion',
                text: label,
                value: cb.value
            });
        });
        
        if (activeFilters.length > 0) {
            activeFiltersDiv.classList.remove('hidden');
            filterTagsDiv.innerHTML = activeFilters.map(filter => `
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-primary/10 text-primary text-xs rounded-full">
                    ${filter.text}
                    <button onclick="removeFilter('${filter.type}', '${filter.value || ''}')" class="hover:text-primary-dark">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
            `).join('');
        } else {
            activeFiltersDiv.classList.add('hidden');
        }
    }

    // Remove individual filter
    window.removeFilter = function(type, value) {
        if (type === 'price' || type === 'custom-price') {
            if (type === 'custom-price') {
                if (minPriceInput && maxPriceInput) {
                    minPriceInput.value = {{ $priceRange['min'] }};
                    maxPriceInput.value = {{ $priceRange['max'] }};
                    updatePriceDisplay();
                }
            } else {
                document.querySelectorAll(`.price-range-filter[value="${value}"]`).forEach(cb => cb.checked = false);
            }
        } else if (type === 'size') {
            document.querySelectorAll(`.size-filter[value="${value}"]`).forEach(cb => cb.checked = false);
        } else if (type === 'color') {
            document.querySelectorAll(`.color-filter[value="${value}"]`).forEach(cb => cb.checked = false);
        } else if (type === 'occasion') {
            document.querySelectorAll(`.occasion-filter[value="${value}"]`).forEach(cb => cb.checked = false);
        }
        
        applyFilters();
    };

    // Debounced filter function
    function debouncedFilter() {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(() => {
            applyFilters();
        }, 500);
    }

    // Apply filters
    async function applyFilters() {
        if (isLoading) return;
        
        collectFilters();
        updateActiveFiltersDisplay();
        
        // Show loading
        isLoading = true;
        loadingSpinner.classList.remove('hidden');
        productsContainer.style.opacity = '0.5';

        // Build query string
        const params = new URLSearchParams({
            price_ranges: JSON.stringify(currentFilters.priceRanges),
            custom_min_price: currentFilters.customPrice.min,
            custom_max_price: currentFilters.customPrice.max,
            sizes: JSON.stringify(currentFilters.sizes),
            colors: JSON.stringify(currentFilters.colors),
            occasions: JSON.stringify(currentFilters.occasions)
        });

        try {
            const response = await fetch(`/category/{{ $category->slug }}/filter?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                productsContainer.innerHTML = data.html;
                
                // Update products count
                if (productsCountDiv) {
                    productsCountDiv.innerHTML = `Showing ${data.firstItem} - ${data.lastItem} of ${data.total} products`;
                }

                // Re-attach product card handlers
                attachProductCardHandlers();
            }
        } catch (error) {
            console.error('Filter error:', error);
        } finally {
            isLoading = false;
            loadingSpinner.classList.add('hidden');
            productsContainer.style.opacity = '1';
        }
    }

    // Attach product card click handlers
    function attachProductCardHandlers() {
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.closest('button') || e.target.closest('a')) {
                    return;
                }
                const productSlug = this.getAttribute('data-product-slug');
                if (productSlug) {
                    window.location.href = `/products/${productSlug}`;
                }
            });
        });
    }

    // Add event listeners to all checkboxes for instant filtering
    document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            applyFilters();
        });
    });

    // Clear all filters button
    document.getElementById('clear-filters').addEventListener('click', function() {
        // Uncheck all checkboxes
        document.querySelectorAll('.price-range-filter, .size-filter, .color-filter, .occasion-filter').forEach(cb => {
            cb.checked = false;
        });
        
        // Reset price ranges
        if (minPriceInput && maxPriceInput) {
            minPriceInput.value = {{ $priceRange['min'] }};
            maxPriceInput.value = {{ $priceRange['max'] }};
            updatePriceDisplay();
        }
        
        // Apply filters with cleared values
        applyFilters();
    });

    // Initial attachment of product card handlers
    attachProductCardHandlers();
});

// Wishlist toggle function
function toggleWishlist(productId, button, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    if (!productId) {
        alert('Product ID not found');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const isInWishlist = button.classList.contains('text-red-500');
    const url = isInWishlist ? '/wishlist/remove' : '/wishlist/add';

    // Show loading
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (isInWishlist) {
                button.classList.remove('text-red-500');
                button.innerHTML = '<i class="far fa-heart"></i>';
            } else {
                button.classList.add('text-red-500');
                button.innerHTML = '<i class="fas fa-heart"></i>';
            }
        } else {
            button.classList.add('text-red-500');
            button.innerHTML = '<i class="fas fa-heart"></i>';
        }
    })
    .catch(error => {
        console.error(error);
    })
    .finally(() => {
        button.disabled = false;
    });
}
</script>
@endsection