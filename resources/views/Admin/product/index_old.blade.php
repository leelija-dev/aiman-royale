@extends('Admin.layouts.master')
@section('source', 'Products')
@section('page-title', 'Products')
@section('title')
    {{ config('app.name') }} - Products
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('admin.products') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50 ">
                            <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                                <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;" placeholder="Search by product name" value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1" style="height:40px;">Search</button>
                                <a href="{{ route('admin.products') }}" class="btn btn-danger mb-sm-3 mb-1" style="height:40px;">Reset</a>
                            </div>
                        </form>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                            <a href="{{ route('admin.products-trashed') }}" class="btn btn-outline-secondary w-100 w-sm-auto mb-sm-3 mb-1">
                                <i class="fas fa-trash"></i> View Trashed Products
                            </a>
                            <a href="{{ route('admin.add-product') }}" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                                <i class="fas fa-plus"></i> Add New Product
                            </a>
                        </div>
                    </div>

                    <div class="px-3 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Product Id</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Image</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Product Code</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Product Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Unit</th>
                                        <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @if ($data->isNotEmpty())
                                        @foreach ($data as $product)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="text-xs font-weight-bold mb-0">
                                                            {{ ($data->currentPage() - 1) * $data->perPage() + $product->id }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        @php $firstImage = $product->images->first(); @endphp
                                                        @if ($firstImage)
                                                            <img src="{{ asset('upload_image/' . $firstImage->image) }}"
                                                                width="40" height="40" class="rounded-circle none" alt="Product image">
                                                        @else
                                                            <span class="badge bg-secondary">No image</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-xs font-weight-bold mb-0">
                                                        {{ $product->sku }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-xs font-weight-bold mb-0">
                                                        {{ $product->name }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-xs font-weight-bold mb-0">
                                                        {{ $product->unit_amount }}
                                                        {{ optional($units->firstWhere('id', $product->unit_id))->code }}
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="#" class="text-secondary font-weight-bold text-xs me-4"
                                                       data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $product->id }}"
                                                       title="Edit product">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $product->id }}"
                                                          action="{{ route('admin.products.destroy', $product->id) }}"
                                                          method="POST" style="display:none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a href="javascript:void(0);"
                                                       onclick="confirmDelete({{ $product->id }})">
                                                        <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editStatusModal{{ $product->id }}"
                                                 tabindex="-1" aria-labelledby="editStatusModalLabel{{ $product->id }}"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editStatusModalLabel{{ $product->id }}">
                                                                Update Product <span style="color:gray">{{ $product->sku }}</span>
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="userUpdateForm{{ $product->id }}"
                                                              action="{{ route('admin.products.update', $product->id ?? 0) }}"
                                                              method="POST" enctype="multipart/form-data" novalidate>
                                                            @csrf
                                                            <div class="modal-body text-start">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control" id="sku"
                                                                                   name="sku" value="{{ $product->sku }}"
                                                                                   maxlength="64" hidden>
                                                                            <div class="invalid-feedback">Product code cannot be blank!</div>
                                                                            @error('sku')
                                                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="product_name" class="text-uppercase text-secondary">
                                                                                Product Name <sup class="text-danger">*</sup>
                                                                            </label>
                                                                            <input type="text" class="form-control" id="name"
                                                                                   name="name" value="{{ $product->name }}" required>
                                                                            <div class="invalid-feedback">Product name cannot be blank!</div>
                                                                            @error('name')
                                                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="text-uppercase text-secondary">Image</label>
                                                                            <input type="file" name="image" class="form-control" accept="image/*">
                                                                            @error('image')
                                                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group position-relative">
                                                                            <label class="text-uppercase text-secondary">
                                                                                Brand <sup class="text-danger">*</sup>
                                                                            </label>
                                                                            <input type="text" class="form-control @error('brand_id') is-invalid @enderror"
                                                                                   id="brandSearch{{ $product->id }}"
                                                                                   placeholder="Search by brand name" autocomplete="off" required>
                                                                            <input type="hidden" id="brand_id_{{ $product->id }}"
                                                                                   name="brand_id" value="{{ old('brand_id', $product->brand_id) }}" required>
                                                                            <div id="brandSearchResults{{ $product->id }}"
                                                                                 class="list-group mt-2 position-absolute w-100"></div>
                                                                            <div class="invalid-feedback">Brand cannot be blank!</div>
                                                                            @error('brand_id')
                                                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group position-relative">
                                                                            <label class="text-uppercase text-secondary">
                                                                                Category <sup class="text-danger">*</sup>
                                                                            </label>
                                                                            <input type="text" class="form-control @error('category_id') is-invalid @enderror"
                                                                                   id="categorySearch{{ $product->id }}"
                                                                                   placeholder="Search by category name" autocomplete="off" required>
                                                                            <input type="hidden" id="category_id_{{ $product->id }}"
                                                                                   name="category_id" value="{{ old('category_id', $product->category_id) }}" required>
                                                                            <div id="categorySearchResults{{ $product->id }}"
                                                                                 class="list-group mt-2 position-absolute w-100"></div>
                                                                            <div class="invalid-feedback">Category cannot be blank!</div>
                                                                            @error('category_id')
                                                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="description" class="text-uppercase text-secondary">Description</label>
                                                                            <textarea id="description" name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                                                                            @error('description')
                                                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label class="text-uppercase text-secondary">Unit <sup class="text-danger">*</sup></label>
                                                                            <div class="input-group mb-2">
                                                                                <input type="text" class="form-control" id="unit_{{ $product->id }}"
                                                                                       name="unit" value="{{ $product->unit_amount }}"
                                                                                       placeholder="Unit Amount" style="height:43px;" required>
                                                                                <button class="btn btn-outline-secondary dropdown-toggle"
                                                                                        type="button" id="unitDropdownButton_{{ $product->id }}"
                                                                                        data-bs-toggle="dropdown" aria-expanded="false"
                                                                                        style="width: 150px; text-transform:none;">
                                                                                    {{ old('unit_name', optional($product->unit)->code ?? 'Select Unit') }}
                                                                                </button>
                                                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="unitDropdownButton_{{ $product->id }}">
                                                                                    @isset($units)
                                                                                        @foreach ($units as $unitRow)
                                                                                            <li>
                                                                                                <a class="dropdown-item unit-option"
                                                                                                   href="#" data-id="{{ $unitRow->id }}"
                                                                                                   data-name="{{ $unitRow->code }}"
                                                                                                   data-target="{{ $product->id }}">
                                                                                                    {{ $unitRow->code }} ({{ $unitRow->name }})
                                                                                                </a>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    @endisset
                                                                                </ul>
                                                                            </div>
                                                                            <input type="hidden" id="unit_id_{{ $product->id }}"
                                                                                   name="unit_id" value="{{ old('unit_id', $product->unit_id) }}" required>
                                                                            <div class="invalid-feedback">Unit and amount cannot be blank!</div>
                                                                            @error('unit_id')
                                                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                                            @enderror
                                                                            @error('unit')
                                                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group form-check mt-2">
                                                                            <input type="hidden" name="is_active" value="0">
                                                                            <input type="checkbox" class="form-check-input"
                                                                                   id="is_active" name="is_active" value="1"
                                                                                   {{ $product->is_active == 1 ? 'checked' : '' }}>
                                                                            <label class="form-check-label text-uppercase text-secondary"
                                                                                   for="is_active">Active</label>
                                                                            @error('is_active')
                                                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-dark"
                                                                        data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <tr class="text-center text-primary fw-bold">
                                            <td colspan="6">Products not available!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                            {{ $data->links('pagination::bootstrap-5') }}
                    </div>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                showClass: { popup: '' },
                hideClass: { popup: '' },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        </script>
    @endif

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Form validation
                const forms = document.querySelectorAll('form[id^="userUpdateForm"]');
                forms.forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });

                // Unit dropdown handling
                document.querySelectorAll('.unit-option').forEach(option => {
                    option.addEventListener('click', function (e) {
                        e.preventDefault();
                        const productId = this.getAttribute('data-target');
                        const unitName = this.getAttribute('data-name');
                        const unitId = this.getAttribute('data-id');
                        const unitDropdownButton = document.getElementById('unitDropdownButton_' + productId);
                        const unitIdInput = document.getElementById('unit_id_' + productId);
                        if (unitDropdownButton && unitIdInput) {
                            unitDropdownButton.textContent = unitName;
                            unitIdInput.value = unitId;
                            unitIdInput.classList.remove('is-invalid');
                            const feedback = unitIdInput.parentElement.querySelector('.invalid-feedback');
                            if (feedback) feedback.style.display = 'none';
                        }
                    });
                });

                // Brand and Category search handling
                const brands = JSON.parse('{!! addslashes(json_encode($brands)) !!}');
                const categories = JSON.parse('{!! addslashes(json_encode($categories)) !!}');

                @foreach ($data as $product)
                    // Brand search for product {{ $product->id }}
                    const brandSearch{{ $product->id }} = document.getElementById('brandSearch{{ $product->id }}');
                    const brandSearchResults{{ $product->id }} = document.getElementById('brandSearchResults{{ $product->id }}');
                    const brandIdInput{{ $product->id }} = document.getElementById('brand_id_{{ $product->id }}');
                    let selectedBrand{{ $product->id }} = { id: '', name: '' };
                    let brandHighlightedIndex{{ $product->id }} = -1;

                    function filterBrands{{ $product->id }}(term) {
                        const t = term.trim().toLowerCase();
                        if (!t || t.length < 3) return [];
                        return brands.filter(b => b.name.toLowerCase().includes(t)).slice(0, 10);
                    }

                    function renderBrandSearch{{ $product->id }}() {
                        const term = brandSearch{{ $product->id }}.value.trim();
                        const results = filterBrands{{ $product->id }}(term);
                        brandSearchResults{{ $product->id }}.innerHTML = '';
                        brandHighlightedIndex{{ $product->id }} = -1;
                                        
                        // Show "No brand found" only when user has typed 3+ chars and no match
                        if (term.length >= 3 && results.length === 0) {
                            const noResult = document.createElement('div');
                            noResult.className = 'list-group-item text-center text-muted small py-3';
                            noResult.textContent = 'No brand found';
                            brandSearchResults{{ $product->id }}.appendChild(noResult);
                            return;
                        }
                    
                        // Only show results if there are matches
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
                                selectedBrand{{ $product->id }} = { id: b.id, name: b.name };
                                brandSearch{{ $product->id }}.value = b.name;
                                brandIdInput{{ $product->id }}.value = b.id;
                                brandSearchResults{{ $product->id }}.innerHTML = '';
                                brandSearch{{ $product->id }}.classList.remove('is-invalid');
                                const feedback = brandSearch{{ $product->id }}.parentElement.querySelector('.invalid-feedback');
                                if (feedback) feedback.style.display = 'none';
                            });
                            brandSearchResults{{ $product->id }}.appendChild(a);
                        });
                    }

                    function highlightBrandResult{{ $product->id }}() {
                        const resultItems = brandSearchResults{{ $product->id }}.querySelectorAll('.list-group-item');
                        resultItems.forEach((item, index) => {
                            if (index === brandHighlightedIndex{{ $product->id }}) {
                                item.classList.add('active');
                                item.scrollIntoView({ block: 'nearest' });
                            } else {
                                item.classList.remove('active');
                            }
                        });
                    }

                    function firstBrandMatch{{ $product->id }}() {
                        const results = filterBrands{{ $product->id }}(brandSearch{{ $product->id }}.value || '');
                        return results.length ? results[0] : null;
                    }

                    brandSearch{{ $product->id }}.addEventListener('input', () => {
                        renderBrandSearch{{ $product->id }}();
                    });

                    brandSearch{{ $product->id }}.addEventListener('keydown', (e) => {
                        const resultItems = brandSearchResults{{ $product->id }}.querySelectorAll('.list-group-item');
                        if (resultItems.length === 0) {
                            if (e.key === 'Enter') {
                                const m = firstBrandMatch{{ $product->id }}();
                                if (m) {
                                    selectedBrand{{ $product->id }} = { id: m.id, name: m.name };
                                    brandSearch{{ $product->id }}.value = m.name;
                                    brandIdInput{{ $product->id }}.value = m.id;
                                    brandSearchResults{{ $product->id }}.innerHTML = '';
                                    brandSearch{{ $product->id }}.classList.remove('is-invalid');
                                    const feedback = brandSearch{{ $product->id }}.parentElement.querySelector('.invalid-feedback');
                                    if (feedback) feedback.style.display = 'none';
                                }
                            }
                            return;
                        }

                        if (e.key === 'ArrowDown') {
                            e.preventDefault();
                            brandHighlightedIndex{{ $product->id }} = (brandHighlightedIndex{{ $product->id }} + 1) % resultItems.length;
                            highlightBrandResult{{ $product->id }}();
                        } else if (e.key === 'ArrowUp') {
                            e.preventDefault();
                            brandHighlightedIndex{{ $product->id }} = (brandHighlightedIndex{{ $product->id }} - 1 + resultItems.length) % resultItems.length;
                            highlightBrandResult{{ $product->id }}();
                        } else if (e.key === 'Enter') {
                            e.preventDefault();
                            if (brandHighlightedIndex{{ $product->id }} >= 0 && brandHighlightedIndex{{ $product->id }} < resultItems.length) {
                                resultItems[brandHighlightedIndex{{ $product->id }}].click();
                            } else {
                                const m = firstBrandMatch{{ $product->id }}();
                                if (m) {
                                    selectedBrand{{ $product->id }} = { id: m.id, name: m.name };
                                    brandSearch{{ $product->id }}.value = m.name;
                                    brandIdInput{{ $product->id }}.value = m.id;
                                    brandSearchResults{{ $product->id }}.innerHTML = '';
                                    brandSearch{{ $product->id }}.classList.remove('is-invalid');
                                    const feedback = brandSearch{{ $product->id }}.parentElement.querySelector('.invalid-feedback');
                                    if (feedback) feedback.style.display = 'none';
                                }
                            }
                        }
                    });

                    // Category search for product {{ $product->id }}
                    const categorySearch{{ $product->id }} = document.getElementById('categorySearch{{ $product->id }}');
                    const categorySearchResults{{ $product->id }} = document.getElementById('categorySearchResults{{ $product->id }}');
                    const categoryIdInput{{ $product->id }} = document.getElementById('category_id_{{ $product->id }}');
                    let selectedCategory{{ $product->id }} = { id: '', name: '' };
                    let categoryHighlightedIndex{{ $product->id }} = -1;

                    function filterCategories{{ $product->id }}(term) {
                        const t = term.trim().toLowerCase();
                        if (!t || t.length < 3) return [];
                        return categories.filter(c => c.name.toLowerCase().includes(t)).slice(0, 10);
                    }

                    function renderCategorySearch{{ $product->id }}() {
                        const term = categorySearch{{ $product->id }}.value.trim();
                        const results = filterCategories{{ $product->id }}(term);
                        categorySearchResults{{ $product->id }}.innerHTML = '';
                        categoryHighlightedIndex{{ $product->id }} = -1;

                        // Show "No category found" only when 3+ chars and no match
                        if (term.length >= 3 && results.length === 0) {
                            const noResult = document.createElement('div');
                            noResult.className = 'list-group-item text-center text-muted small py-3';
                            noResult.textContent = 'No category found';
                            categorySearchResults{{ $product->id }}.appendChild(noResult);
                        }
                    
                        // Only render results if there are matches
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
                                selectedCategory{{ $product->id }} = { id: c.id, name: c.name };
                                categorySearch{{ $product->id }}.value = c.name;
                                categoryIdInput{{ $product->id }}.value = c.id;
                                categorySearchResults{{ $product->id }}.innerHTML = '';
                                categorySearch{{ $product->id }}.classList.remove('is-invalid');
                                const feedback = categorySearch{{ $product->id }}.parentElement.querySelector('.invalid-feedback');
                                if (feedback) feedback.style.display = 'none';
                            });
                            categorySearchResults{{ $product->id }}.appendChild(a);
                        });
                    }

                    function highlightCategoryResult{{ $product->id }}() {
                        const resultItems = categorySearchResults{{ $product->id }}.querySelectorAll('.list-group-item');
                        resultItems.forEach((item, index) => {
                            if (index === categoryHighlightedIndex{{ $product->id }}) {
                                item.classList.add('active');
                                item.scrollIntoView({ block: 'nearest' });
                            } else {
                                item.classList.remove('active');
                            }
                        });
                    }

                    function firstCategoryMatch{{ $product->id }}() {
                        const results = filterCategories{{ $product->id }}(categorySearch{{ $product->id }}.value || '');
                        return results.length ? results[0] : null;
                    }

                    categorySearch{{ $product->id }}.addEventListener('input', () => {
                        renderCategorySearch{{ $product->id }}();
                    });

                    categorySearch{{ $product->id }}.addEventListener('keydown', (e) => {
                        const resultItems = categorySearchResults{{ $product->id }}.querySelectorAll('.list-group-item');
                        if (resultItems.length === 0) {
                            if (e.key === 'Enter') {
                                const m = firstCategoryMatch{{ $product->id }}();
                                if (m) {
                                    selectedCategory{{ $product->id }} = { id: m.id, name: m.name };
                                    categorySearch{{ $product->id }}.value = m.name;
                                    categoryIdInput{{ $product->id }}.value = m.id;
                                    categorySearchResults{{ $product->id }}.innerHTML = '';
                                    categorySearch{{ $product->id }}.classList.remove('is-invalid');
                                    const feedback = categorySearch{{ $product->id }}.parentElement.querySelector('.invalid-feedback');
                                    if (feedback) feedback.style.display = 'none';
                                }
                            }
                            return;
                        }

                        if (e.key === 'ArrowDown') {
                            e.preventDefault();
                            categoryHighlightedIndex{{ $product->id }} = (categoryHighlightedIndex{{ $product->id }} + 1) % resultItems.length;
                            highlightCategoryResult{{ $product->id }}();
                        } else if (e.key === 'ArrowUp') {
                            e.preventDefault();
                            categoryHighlightedIndex{{ $product->id }} = (categoryHighlightedIndex{{ $product->id }} - 1 + resultItems.length) % resultItems.length;
                            highlightCategoryResult{{ $product->id }}();
                        } else if (e.key === 'Enter') {
                            e.preventDefault();
                            if (categoryHighlightedIndex{{ $product->id }} >= 0 && categoryHighlightedIndex{{ $product->id }} < resultItems.length) {
                                resultItems[categoryHighlightedIndex{{ $product->id }}].click();
                            } else {
                                const m = firstCategoryMatch{{ $product->id }}();
                                if (m) {
                                    selectedCategory{{ $product->id }} = { id: m.id, name: m.name };
                                    categorySearch{{ $product->id }}.value = m.name;
                                    categoryIdInput{{ $product->id }}.value = m.id;
                                    categorySearchResults{{ $product->id }}.innerHTML = '';
                                    categorySearch{{ $product->id }}.classList.remove('is-invalid');
                                    const feedback = categorySearch{{ $product->id }}.parentElement.querySelector('.invalid-feedback');
                                    if (feedback) feedback.style.display = 'none';
                                }
                            }
                        }
                    });

                    // Restore previously selected brand and category
                    @if(old('product_id') == $product->id)
                        const oldBrand{{ $product->id }} = brands.find(b => b.id == '{{ old('brand_id', $product->brand_id) }}');
                        if (oldBrand{{ $product->id }}) {
                            brandSearch{{ $product->id }}.value = oldBrand{{ $product->id }}.name;
                            brandIdInput{{ $product->id }}.value = oldBrand{{ $product->id }}.id;
                            selectedBrand{{ $product->id }} = { id: oldBrand{{ $product->id }}.id, name: oldBrand{{ $product->id }}.name };
                        }

                        const oldCategory{{ $product->id }} = categories.find(c => c.id == '{{ old('category_id', $product->category_id) }}');
                        if (oldCategory{{ $product->id }}) {
                            categorySearch{{ $product->id }}.value = oldCategory{{ $product->id }}.name;
                            categoryIdInput{{ $product->id }}.value = oldCategory{{ $product->id }}.id;
                            selectedCategory{{ $product->id }} = { id: oldCategory{{ $product->id }}.id, name: oldCategory{{ $product->id }}.name };
                        }
                    @else
                        const currentBrand{{ $product->id }} = brands.find(b => b.id == '{{ $product->brand_id }}');
                        if (currentBrand{{ $product->id }}) {
                            brandSearch{{ $product->id }}.value = currentBrand{{ $product->id }}.name;
                            brandIdInput{{ $product->id }}.value = currentBrand{{ $product->id }}.id;
                            selectedBrand{{ $product->id }} = { id: currentBrand{{ $product->id }}.id, name: currentBrand{{ $product->id }}.name };
                        }

                        const currentCategory{{ $product->id }} = categories.find(c => c.id == '{{ $product->category_id }}');
                        if (currentCategory{{ $product->id }}) {
                            categorySearch{{ $product->id }}.value = currentCategory{{ $product->id }}.name;
                            categoryIdInput{{ $product->id }}.value = currentCategory{{ $product->id }}.id;
                            selectedCategory{{ $product->id }} = { id: currentCategory{{ $product->id }}.id, name: currentCategory{{ $product->id }}.name };
                        }
                    @endif
                @endforeach
            });
        </script>
    @endpush

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const firstModal = document.querySelector('.modal.show, .modal.fade.show');
                if (!firstModal) {
                    @foreach ($data as $product)
                        @if (old('product_id') == $product->id)
                            const modalId = '#editStatusModal{{ $product->id }}';
                            const myModal = new bootstrap.Modal(document.querySelector(modalId));
                            myModal.show();
                        @endif
                    @endforeach
                }
            });
        </script>
    @endif
@endsection