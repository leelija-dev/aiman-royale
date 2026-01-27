@extends('Admin.layouts.master')
@section('source', 'Stocks')
@section('page-title', 'Add Stocks')

@section('title')
{{ config('app.name') }} - Add Stocks
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Add New Stock</h4>
                </div>
                <div class=" px-3 py-2">
                    <form action="{{ route('stocks.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 position-relative">
                                    <label for="productSearch" class="form-label">Product <span class="text-danger">*</span></label>
                                    <input id="productSearch" type="text" class="form-control @error('product_id') is-invalid @enderror"
                                        placeholder="Search by product name or product code " autocomplete="off" required>
                                    <input type="hidden" id="product_id" name="product_id" value="{{ old('product_id') }}" required>
                                    <div id="productSearchResults" class="list-group mt-2 position-absolute w-100"></div>
                                    @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_package_quantity" class="form-label">
                                        Package <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group">
                                        <!-- Package quantity input -->
                                        <input type="number"
                                            class="form-control @error('product_package_quantity') is-invalid @enderror"
                                            id="product_package_quantity"
                                            name="product_package_quantity"
                                            value="{{ old('product_package_quantity', 1) }}"
                                            min="1"
                                            placeholder="Enter Quantity"
                                            style="height:43px;"
                                            required>

                                        @error('product_package_quantity')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                        <!-- Dropdown button -->
                                        <button class="btn btn-outline-secondary dropdown-toggle"
                                            type="button"
                                            id="packageDropdownButton"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="width: 180px; text-transform:none;">
                                            {{ old('package_name', 'Select Package Type') }}
                                        </button>

                                        <!-- Dropdown menu -->
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="packageDropdownButton">
                                            @foreach($units as $unit)
                                            <li>
                                                <a class="dropdown-item package-option"
                                                    href="#"
                                                    data-id="{{ $unit->id }}"
                                                    data-name="{{ $unit->code }}">
                                                    {{ $unit->code }} ({{ $unit->name }})
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <!-- Hidden input for package id -->
                                    <input type="hidden"
                                        id="product_package_id"
                                        name="product_package_id"
                                        value="{{ old('product_package_id') }}"
                                        required>

                                    @error('product_package_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="purchase_price" class="form-label">Purchase Price (per unit) <span class="text-danger">*</span></label>
                                    <div class="input-group @error('purchase_price') has-validation @enderror">
                                        <span class="input-group-text">{{ config('app.rupees') }}</span>
                                        <input type="number"
                                            step="0.01"
                                            class="form-control @error('purchase_price') is-invalid @enderror"
                                            id="purchase_price"
                                            name="purchase_price"
                                            value="{{ old('purchase_price') }}"
                                            min="0"
                                            required>
                                        @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="selling_price" class="form-label">Selling Price (MRP) <span class="text-danger">*</span></label>
                                    <div class="input-group @error('selling_price') has-validation @enderror">
                                        <span class="input-group-text">{{ config('app.rupees') }}</span>
                                        <input type="number"
                                            step="0.01"
                                            class="form-control @error('selling_price') is-invalid @enderror"
                                            id="selling_price"
                                            name="selling_price"
                                            value="{{ old('selling_price') }}"
                                            min="0"
                                            required>
                                        @error('selling_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Stock
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #productSearchResults .list-group-item {
        cursor: pointer;
    }

    #productSearchResults .list-group-item:hover {
        background: #f6f9fc;
    }

    #productSearchResults .list-group-item.active {
        background: #fffafa;
        border: 1px solid #777676;
        color: #666464;
        font-weight: bold;
    }
    body .main-content {
        overflow: visible !important;
  height: auto !important;
  max-height: 100% !important;
  
    }

    body .main-content .list-group{
        max-height: 500px;
        overflow-y:auto;
         z-index: 1;
    }
    .ps--active-x>.ps__rail-x,
    .ps--active-y>.ps__rail-y {
        background-color: transparent;
        height: auto !important;
        display: none !important;
       
    }
    
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Package dropdown handling
        document.querySelectorAll('.package-option').forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const packageName = this.getAttribute('data-name');
                const packageId = this.getAttribute('data-id');

                // Update dropdown button text and hidden input
                const button = document.getElementById('packageDropdownButton');
                const hiddenInput = document.getElementById('product_package_id');

                button.textContent = packageName;
                hiddenInput.value = packageId;
            });
        });

        // Product search and selection
        //const products = JSON.parse('{!! addslashes(json_encode($products)) !!}');
        
        const products = {!! json_encode(
            $products->map(function($p) use ($units,$brands,$category) {
                $unit = $units->firstWhere('id', $p->unit_id);
                $brand=$brands->firstWhere('id', $p->brand_id);
                $category=$category->firstWhere('id', $p->category_id);
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'sku' => $p->sku,
                    'company' => $p->company,
                    'unit_amount' => $p->unit_amount,
                    'unit' => $unit->code ?? 'pcs',
                    'brand' => $brand->name ?? 'Other',
                    'category' => $category->name,

                ];
            })
        ) !!};


        const productSearch = document.getElementById('productSearch');
        const productSearchResults = document.getElementById('productSearchResults');
        const productIdInput = document.getElementById('product_id');
        let selectedProduct = {
            id: '',
            name: '',
            sku: '',

        };
        let highlightedIndex = -1;

        function filterProducts(term) {
            const t = term.trim().toLowerCase();
            if (!t || t.length < 3) return []; // Require at least 3 characters
            return products.filter(p =>
                p.name.toLowerCase().includes(t) ||
                p.sku.toLowerCase().includes(t)
            ).slice(0, 10);
        }
        console.log(products);

        function renderProductSearch() {
    const term = productSearch.value.trim();          // <-- trim to avoid spaces-only issues
    const results = filterProducts(term);             // your existing filter function
    productSearchResults.innerHTML = '';
    highlightedIndex = -1;

    // ---- NEW: “No product found” only when searching ----
    if (term.length >= 3 && results.length === 0) {
        const noResult = document.createElement('div');
        noResult.className = 'list-group-item text-center text-muted small py-3';
        noResult.textContent = 'No product found';
        productSearchResults.appendChild(noResult);
        return;   // stop here – don’t render any items
    }
    // -----------------------------------------------------

    // Render matching products (unchanged)
    results.forEach(p => {
        const a = document.createElement('button');
        a.type = 'button';
        a.className = 'list-group-item list-group-item-action';
        a.setAttribute('data-id', String(p.id));
        a.innerHTML = `
            <div class="d-flex justify-content-between">
                <span>${p.name} - ${p.sku}</span>
                <span class="text-muted">${p.brand || '—'}</span>
            </div>
            <div class="text-muted small">
                ${p.unit_amount || 1} ${p.unit || 'pcs'} | ${p.category || '—'}
            </div>
        `;
        a.addEventListener('click', () => {
            selectedProduct = {
                id: p.id,
                name: p.name,
                sku: p.sku
            };
            productSearch.value = `${p.name} (${p.sku})`;
            productIdInput.value = p.id;
            productSearchResults.innerHTML = '';
            productSearch.classList.remove('is-invalid');
            const feedback = productSearch.parentElement.querySelector('.invalid-feedback');
            if (feedback) feedback.style.display = 'none';
        });
        productSearchResults.appendChild(a);
    });
}

        function highlightProductResult() {
            const resultItems = productSearchResults.querySelectorAll('.list-group-item');
            resultItems.forEach((item, index) => {
                if (index === highlightedIndex) {
                    item.classList.add('active');
                    item.scrollIntoView({
                        block: 'nearest'
                    });
                } else {
                    item.classList.remove('active');
                }
            });
        }

        function firstProductMatch() {
            const results = filterProducts(productSearch.value || '');
            return results.length ? results[0] : null;
        }

        productSearch.addEventListener('input', () => {
            renderProductSearch();
        });

        productSearch.addEventListener('keydown', (e) => {
            const resultItems = productSearchResults.querySelectorAll('.list-group-item');
            if (resultItems.length === 0) {
                if (e.key === 'Enter') {
                    const m = firstProductMatch();
                    if (m) {
                        selectedProduct = {
                            id: m.id,
                            name: m.name,
                            sku: m.sku
                        };
                        productSearch.value = `${m.name} (${m.sku})`;
                        productIdInput.value = m.id;
                        productSearchResults.innerHTML = '';
                        productSearch.classList.remove('is-invalid');
                        const feedback = productSearch.parentElement.querySelector('.invalid-feedback');
                        if (feedback) feedback.style.display = 'none';
                    }
                }
                return;
            }

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                highlightedIndex = (highlightedIndex + 1) % resultItems.length;
                highlightProductResult();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                highlightedIndex = (highlightedIndex - 1 + resultItems.length) % resultItems.length;
                highlightProductResult();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (highlightedIndex >= 0 && highlightedIndex < resultItems.length) {
                    resultItems[highlightedIndex].click();
                } else {
                    const m = firstProductMatch();
                    if (m) {
                        selectedProduct = {
                            id: m.id,
                            name: m.name,
                            sku: m.sku
                        };
                        productSearch.value = `${m.name} (${m.sku})`;
                        productIdInput.value = m.id;
                        productSearchResults.innerHTML = '';
                        productSearch.classList.remove('is-invalid');
                        const feedback = productSearch.parentElement.querySelector('.invalid-feedback');
                        if (feedback) feedback.style.display = 'none';
                    }
                }
            }
        });

        // Restore previously selected product if old input exists
        @if(old('product_id'))
        const oldProduct = products.find(p => p.id == '{{ old('product_id ') }}');
        if (oldProduct) {
            productSearch.value = `${oldProduct.name} (${oldProduct.sku})`;
            productIdInput.value = oldProduct.id;
            selectedProduct = {
                id: oldProduct.id,
                name: oldProduct.name,
                sku: oldProduct.sku

            };
        }
        @endif

        // Form validation for selling price
        const purchaseInput = document.getElementById('purchase_price');
        const sellingInput = document.getElementById('selling_price');
        const form = purchaseInput.closest('form');

        form.addEventListener('submit', function(e) {
            const purchasePrice = parseFloat(purchaseInput.value) || 0;
            const sellingPrice = parseFloat(sellingInput.value) || 0;

            // Check validation
            if (sellingPrice <= purchasePrice) {
                e.preventDefault(); // Stop form submission

                // Show Bootstrap validation message
                sellingInput.classList.add('is-invalid');

                // Add or update invalid-feedback
                let feedback = sellingInput.parentElement.parentElement.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.classList.add('invalid-feedback');
                    sellingInput.parentElement.parentElement.appendChild(feedback);
                }
                feedback.textContent = 'Selling price cannot be less than purchase price.';
                feedback.style.display = 'block';

                // Focus on selling price
                sellingInput.focus();
            } else {
                // Remove error state if valid
                sellingInput.classList.remove('is-invalid');
                const feedback = sellingInput.parentElement.parentElement.querySelector('.invalid-feedback');
                if (feedback) feedback.style.display = 'none';
            }
        });
    });
</script>
@endpush