@extends('Admin.layouts.master')
@section('source', 'Product')
@section('page-title', 'Add Product')

@section('title')
{{ config('app.name') }} - Add Product
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="cards p-4">
                <form id="productForm" action="{{ route('admin.products.store') }}" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            {{-- SKU --}}
                            <div class="form-group">
                                <label for="sku" class="text-uppercase text-secondary">Product Code <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="sku" name="sku"
                                    value="{{ old('sku') }}" maxlength="64" placeholder="Product code" required>
                                <div class="invalid-feedback">Product code can not be blank!</div>
                                @error('sku')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="product_name" class="text-uppercase text-secondary">Product Name <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="Product Name" required>
                                <div class="invalid-feedback">Product name can not be blank!</div>
                                @error('name')
                                <div>
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="text-uppercase text-secondary">Image</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                @error('image')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Brand --}}
                            <div class="form-group position-relative">
                                <label for="brandSearch" class="text-uppercase text-secondary">Brand <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" class="form-control @error('brand_id') is-invalid @enderror" id="brandSearch"
                                    placeholder="Search by brand name" autocomplete="off" required>
                                <input type="hidden" id="brand_id" name="brand_id" value="{{ old('brand_id') }}" required>
                                <div id="brandSearchResults" class="list-group mt-2 position-absolute w-100"></div>
                                <div class="invalid-feedback">Brand cannot be blank!</div>
                                @error('brand_id')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                                {{-- Category --}}
                                <div class="form-group position-relative">
                                    <label for="categorySearch" class="text-uppercase text-secondary">Category <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @error('category_id') is-invalid @enderror" id="categorySearch"
                                        placeholder="Search by category name" autocomplete="off" required>
                                    <input type="hidden" id="category_id" name="category_id" value="{{ old('category_id') }}" required>
                                    <div id="categorySearchResults" class="list-group mt-2 position-absolute w-100"></div>
                                    <div class="invalid-feedback">Category cannot be blank!</div>
                                    @error('category_id')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description" class="text-uppercase text-secondary">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- Unit --}}
                                <div class="form-group">
                                    <label class="text-uppercase text-secondary">Unit <sup class="text-danger">*</sup></label>
                                    <div class="input-group mb-2">
                                        <!-- Unit amount input -->
                                        <input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit') }}" placeholder="Unit Amount" style="height:43px;" required>
                                        
                                        <!-- Dropdown button -->
                                        <button class="btn btn-outline-secondary dropdown-toggle" 
                                                type="button" 
                                                id="unitDropdownButton" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false" style="width: 150px;">
                                            {{ old('unit_name', 'Select Unit') }}
                                        </button>
                                        
                                        <!-- Dropdown menu -->
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="unitDropdownButton">
                                            @isset($units)
                                                @foreach ($units as $unitRow)
                                                    <li>
                                                        <a class="dropdown-item unit-option" 
                                                           href="#" 
                                                           data-id="{{ $unitRow->id }}" 
                                                           data-name="{{ $unitRow->code }}">
                                                            {{ $unitRow->code }} ({{ $unitRow->name }})
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endisset
                                        </ul>
                                    </div>

                                <!-- Hidden input to store selected unit_id -->
                                <input type="hidden" id="unit_id" name="unit_id" value="{{ old('unit_id') }}" required>
                                <div class="invalid-feedback">Unit and amount cannot be blank!</div>
                                @error('unit_id')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                @error('unit')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- Active --}}
                            <div class="form-group form-check mt-2">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label text-uppercase text-secondary"
                                    for="is_active">Active</label>
                                @error('is_active')
                                <sup class="invalid-feedback d-block">{{ $message }}</sup>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    #brandSearchResults .list-group-item,
    #categorySearchResults .list-group-item {
        cursor: pointer;
    }

    #brandSearchResults .list-group-item:hover,
    #categorySearchResults .list-group-item:hover {
        background: #f6f9fc;
    }

    #brandSearchResults .list-group-item.active,
    #categorySearchResults .list-group-item.active {
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

    body .main-content .list-group {
        max-height: 500px;
        overflow-y: auto;
        z-index: 1;
    }

    .ps--active-x>.ps__rail-x,
    .ps--active-y>.ps__rail-y {
        background-color: transparent;
        height: auto !important;
        display: none !important;

    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Unit dropdown handling
        const unitOptions = document.querySelectorAll('.unit-option');
        const unitDropdownButton = document.getElementById('unitDropdownButton');
        const unitIdInput = document.getElementById('unit_id');

        unitOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const unitName = this.getAttribute('data-name');
                const unitId = this.getAttribute('data-id');
                unitDropdownButton.textContent = unitName;
                unitIdInput.value = unitId;
                unitIdInput.classList.remove('is-invalid');
                const feedback = unitIdInput.parentElement.querySelector('.invalid-feedback');
                if (feedback) feedback.style.display = 'none';
            });
        });

        // Form validation
        const form = document.getElementById('productForm');
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);

        // Brand search and selection
        const brands = JSON.parse('{!! addslashes(json_encode($brands)) !!}');
        const brandSearch = document.getElementById('brandSearch');
        const brandSearchResults = document.getElementById('brandSearchResults');
        const brandIdInput = document.getElementById('brand_id');
        let selectedBrand = {
            id: '',
            name: ''
        };
        let brandHighlightedIndex = -1;

        function filterBrands(term) {
            const t = term.trim().toLowerCase();
            if (!t || t.length < 3) return []; // Require at least 3 characters
            return brands.filter(b => b.name.toLowerCase().includes(t)).slice(0, 10);
        }

        function renderBrandSearch() {
    const term = brandSearch.value.trim();
    const results = filterBrands(term);
    brandSearchResults.innerHTML = '';
    brandHighlightedIndex = -1;

    // Show "No brand found" only when user types 3+ chars and no match
    if (term.length >= 3 && results.length === 0) {
        const noResult = document.createElement('div');
        noResult.className = 'list-group-item text-center text-muted small py-3';
        noResult.textContent = 'No brand found';
        brandSearchResults.appendChild(noResult);
    }

    // Only render results if there are matches
    if (results.length === 0) return;

    results.forEach(b => {
        const a = document.createElement('button');
        a.type = 'button';
        a.className = 'list-group-item list-group-item-action';
        a.setAttribute('data-id', String(b.id));
        a.innerHTML = `
            <div class="d-flex justify-content-between">
                <span>${b.name}</span>
            </div>
        `;
        a.addEventListener('click', () => {
            selectedBrand = {
                id: b.id,
                name: b.name
            };
            brandSearch.value = b.name;
            brandIdInput.value = b.id;
            brandSearchResults.innerHTML = '';
            brandSearch.classList.remove('is-invalid');
            const feedback = brandSearch.parentElement.querySelector('.invalid-feedback');
            if (feedback) feedback.style.display = 'none';
        });
        brandSearchResults.appendChild(a);
    });
}

        function highlightBrandResult() {
            const resultItems = brandSearchResults.querySelectorAll('.list-group-item');
            resultItems.forEach((item, index) => {
                if (index === brandHighlightedIndex) {
                    item.classList.add('active');
                    item.scrollIntoView({
                        block: 'nearest'
                    });
                } else {
                    item.classList.remove('active');
                }
            });
        }

        function firstBrandMatch() {
            const results = filterBrands(brandSearch.value || '');
            return results.length ? results[0] : null;
        }

        brandSearch.addEventListener('input', () => {
            renderBrandSearch();
        });

        brandSearch.addEventListener('keydown', (e) => {
            const resultItems = brandSearchResults.querySelectorAll('.list-group-item');
            if (resultItems.length === 0) {
                if (e.key === 'Enter') {
                    const m = firstBrandMatch();
                    if (m) {
                        selectedBrand = {
                            id: m.id,
                            name: m.name
                        };
                        brandSearch.value = m.name;
                        brandIdInput.value = m.id;
                        brandSearchResults.innerHTML = '';
                        brandSearch.classList.remove('is-invalid');
                        const feedback = brandSearch.parentElement.querySelector('.invalid-feedback');
                        if (feedback) feedback.style.display = 'none';
                    }
                }
                return;
            }

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                brandHighlightedIndex = (brandHighlightedIndex + 1) % resultItems.length;
                highlightBrandResult();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                brandHighlightedIndex = (brandHighlightedIndex - 1 + resultItems.length) % resultItems.length;
                highlightBrandResult();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (brandHighlightedIndex >= 0 && brandHighlightedIndex < resultItems.length) {
                    resultItems[brandHighlightedIndex].click();
                } else {
                    const m = firstBrandMatch();
                    if (m) {
                        selectedBrand = {
                            id: m.id,
                            name: m.name
                        };
                        brandSearch.value = m.name;
                        brandIdInput.value = m.id;
                        brandSearchResults.innerHTML = '';
                        brandSearch.classList.remove('is-invalid');
                        const feedback = brandSearch.parentElement.querySelector('.invalid-feedback');
                        if (feedback) feedback.style.display = 'none';
                    }
                }
            }
        });

        // Category search and selection
        const categories = JSON.parse('{!! addslashes(json_encode($categories)) !!}');
        const categorySearch = document.getElementById('categorySearch');
        const categorySearchResults = document.getElementById('categorySearchResults');
        const categoryIdInput = document.getElementById('category_id');
        let selectedCategory = {
            id: '',
            name: ''
        };
        let categoryHighlightedIndex = -1;

        function filterCategories(term) {
            const t = term.trim().toLowerCase();
            if (!t || t.length < 3) return []; // Require at least 3 characters
            return categories.filter(c => c.name.toLowerCase().includes(t)).slice(0, 10);
        }

        function renderCategorySearch() {
            const term = categorySearch.value.trim();
            const results = filterCategories(term);
            categorySearchResults.innerHTML = '';
            categoryHighlightedIndex = -1;

            // Show "No category found" only when user has typed 3+ chars and no match
            if (term.length >= 3 && results.length === 0) {
                const noResult = document.createElement('div');
                noResult.className = 'list-group-item text-center text-muted small py-3';
                noResult.textContent = 'No category found';
                categorySearchResults.appendChild(noResult);
                // Don't return here — allow empty results for short inputs
            }

            // Only show results if there are matches
            if (results.length === 0) return;

            results.forEach(c => {
                const a = document.createElement('button');
                a.type = 'button';
                a.className = 'list-group-item list-group-item-action';
                a.setAttribute('data-id', String(c.id));
                a.innerHTML = `
            <div class="d-flex justify-content-between">
                <span>${c.name}</span>
            </div>
        `;
                a.addEventListener('click', () => {
                    selectedCategory = {
                        id: c.id,
                        name: c.name
                    };
                    categorySearch.value = c.name;
                    categoryIdInput.value = c.id;
                    categorySearchResults.innerHTML = '';
                    categorySearch.classList.remove('is-invalid');
                    const feedback = categorySearch.parentElement.querySelector('.invalid-feedback');
                    if (feedback) feedback.style.display = 'none';
                });
                categorySearchResults.appendChild(a);
            });
        }

        function highlightCategoryResult() {
            const resultItems = categorySearchResults.querySelectorAll('.list-group-item');
            resultItems.forEach((item, index) => {
                if (index === categoryHighlightedIndex) {
                    item.classList.add('active');
                    item.scrollIntoView({
                        block: 'nearest'
                    });
                } else {
                    item.classList.remove('active');
                }
            });
        }

        function firstCategoryMatch() {
            const results = filterCategories(categorySearch.value || '');
            return results.length ? results[0] : null;
        }

        categorySearch.addEventListener('input', () => {
            renderCategorySearch();
        });

        categorySearch.addEventListener('keydown', (e) => {
            const resultItems = categorySearchResults.querySelectorAll('.list-group-item');
            if (resultItems.length === 0) {
                if (e.key === 'Enter') {
                    const m = firstCategoryMatch();
                    if (m) {
                        selectedCategory = {
                            id: m.id,
                            name: m.name
                        };
                        categorySearch.value = m.name;
                        categoryIdInput.value = m.id;
                        categorySearchResults.innerHTML = '';
                        categorySearch.classList.remove('is-invalid');
                        const feedback = categorySearch.parentElement.querySelector('.invalid-feedback');
                        if (feedback) feedback.style.display = 'none';
                    }
                }
                return;
            }

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                categoryHighlightedIndex = (categoryHighlightedIndex + 1) % resultItems.length;
                highlightCategoryResult();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                categoryHighlightedIndex = (categoryHighlightedIndex - 1 + resultItems.length) % resultItems.length;
                highlightCategoryResult();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (categoryHighlightedIndex >= 0 && categoryHighlightedIndex < resultItems.length) {
                    resultItems[categoryHighlightedIndex].click();
                } else {
                    const m = firstCategoryMatch();
                    if (m) {
                        selectedCategory = {
                            id: m.id,
                            name: m.name
                        };
                        categorySearch.value = m.name;
                        categoryIdInput.value = m.id;
                        categorySearchResults.innerHTML = '';
                        categorySearch.classList.remove('is-invalid');
                        const feedback = categorySearch.parentElement.querySelector('.invalid-feedback');
                        if (feedback) feedback.style.display = 'none';
                    }
                }
            }
        });

        // Restore previously selected brand and category if old input exists
        @if(old('brand_id'))
        const oldBrand = brands.find(b => b.id == '{{ old('
            brand_id ') }}');
        if (oldBrand) {
            brandSearch.value = oldBrand.name;
            brandIdInput.value = oldBrand.id;
            selectedBrand = {
                id: oldBrand.id,
                name: oldBrand.name
            };
        }
        @endif

        @if(old('category_id'))
        const oldCategory = categories.find(c => c.id == '{{ old('
            category_id ') }}');
        if (oldCategory) {
            categorySearch.value = oldCategory.name;
            categoryIdInput.value = oldCategory.id;
            selectedCategory = {
                id: oldCategory.id,
                name: oldCategory.name
            };
        }
        @endif
    });
</script>
@endpush
@endsection