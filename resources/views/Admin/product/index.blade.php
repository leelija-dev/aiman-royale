@extends('Admin.layouts.master')
@section('source', 'Product')
@section('page-title', 'Products')

@section('title')
{{ config('app.name') }} - Products
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.products') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50 ">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;" placeholder="Search by product name, design no, or brand" value="{{ request('search') }}">
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
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Design No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Brand</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $product)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @if($product->images->count() > 0)
                                                <img src="{{ asset('uploads/products/' . $product->images->first()->image) }}" 
                                                     class="avatar avatar-sm me-3" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('assets/img/placeholder.png') }}" 
                                                     class="avatar avatar-sm me-3" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $product->design_no }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $product->name }}</h6>
                                            @if($product->fabric)
                                            <p class="text-xs text-secondary mb-0">{{ $product->fabric }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $product->brand ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $product->category ? $product->category->name : 'N/A' }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">${{ number_format($product->price, 2) }}</h6>
                                            @if($product->discount_price)
                                            <p class="text-xs text-success mb-0">${{ number_format($product->discount_price, 2) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $product->stock }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->status }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" class="text-secondary font-weight-bold text-xs me-4"
                                       data-bs-toggle="modal" data-bs-target="#editModal{{ $product->id }}"
                                       title="Edit product">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form id="delete-form-{{ $product->id }}"
                                          action="{{ route('admin.products.delete', $product->id) }}"
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
                            <div class="modal fade" id="editModal{{ $product->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $product->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $product->id }}">Edit Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="editForm{{ $product->id }}"
                                              action="{{ route('admin.products.update', $product->id) }}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-start">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="edit_design_no_{{ $product->id }}" class="form-label">Design Number <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="edit_design_no_{{ $product->id }}" name="design_no" 
                                                                   value="{{ $product->design_no }}" maxlength="40" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_name_{{ $product->id }}" class="form-label">Product Name <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="edit_name_{{ $product->id }}" name="name" 
                                                                   value="{{ $product->name }}" maxlength="200" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_brand_{{ $product->id }}" class="form-label">Brand</label>
                                                            <input type="text" class="form-control" id="edit_brand_{{ $product->id }}" name="brand" 
                                                                   value="{{ $product->brand }}" maxlength="100">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_fabric_{{ $product->id }}" class="form-label">Fabric</label>
                                                            <input type="text" class="form-control" id="edit_fabric_{{ $product->id }}" name="fabric" 
                                                                   value="{{ $product->fabric }}" maxlength="100">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_fit_{{ $product->id }}" class="form-label">Fit</label>
                                                            <select class="form-control" id="edit_fit_{{ $product->id }}" name="fit">
                                                                <option value="">Select Fit</option>
                                                                <option value="Slim" {{ $product->fit == 'Slim' ? 'selected' : '' }}>Slim</option>
                                                                <option value="Regular" {{ $product->fit == 'Regular' ? 'selected' : '' }}>Regular</option>
                                                                <option value="A-line" {{ $product->fit == 'A-line' ? 'selected' : '' }}>A-line</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="edit_category_id_{{ $product->id }}" class="form-label">Category <span class="text-danger">*</span></label>
                                                            <select class="form-control" id="edit_category_id_{{ $product->id }}" name="category_id" required>
                                                                <option value="">Select Category</option>
                                                                @foreach($categories as $category)
                                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_occasion_id_{{ $product->id }}" class="form-label">Occasion</label>
                                                            <select class="form-control" id="edit_occasion_id_{{ $product->id }}" name="occasion_id">
                                                                <option value="">Select Occasion</option>
                                                                @foreach($occasions as $occasion)
                                                                <option value="{{ $occasion->id }}" {{ $product->occasion_id == $occasion->id ? 'selected' : '' }}>
                                                                    {{ $occasion->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_price_{{ $product->id }}" class="form-label">Price <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="edit_price_{{ $product->id }}" name="price" 
                                                                   value="{{ $product->price }}" step="0.01" min="0" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_discount_price_{{ $product->id }}" class="form-label">Discount Price</label>
                                                            <input type="number" class="form-control" id="edit_discount_price_{{ $product->id }}" name="discount_price" 
                                                                   value="{{ $product->discount_price }}" step="0.01" min="0">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_stock_{{ $product->id }}" class="form-label">Stock <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="edit_stock_{{ $product->id }}" name="stock" 
                                                                   value="{{ $product->stock }}" min="0" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_status_{{ $product->id }}" class="form-label">Status <span class="text-danger">*</span></label>
                                                            <select class="form-control" id="edit_status_{{ $product->id }}" name="status" required>
                                                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_image_{{ $product->id }}" class="form-label">Product Image</label>
                                                            <input type="file" class="form-control" id="edit_image_{{ $product->id }}" name="image" accept="image/*">
                                                            @if($product->images->count() > 0)
                                                            <small class="text-muted">Current: {{ $product->images->first()->image }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="edit_description_{{ $product->id }}" class="form-label">Description</label>
                                                            <textarea class="form-control" id="edit_description_{{ $product->id }}" name="description" rows="3">{{ $product->description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <p class="text-muted">No products found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
                    </div>
                    <div>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        document.getElementById('delete-form-' + productId).submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Form validation for edit modals
    document.querySelectorAll('form[id^="editForm"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const productId = this.id.replace('editForm', '');
            const designNo = document.getElementById('edit_design_no_' + productId);
            const name = document.getElementById('edit_name_' + productId);
            const categoryId = document.getElementById('edit_category_id_' + productId);
            const price = document.getElementById('edit_price_' + productId);
            const stock = document.getElementById('edit_stock_' + productId);
            const status = document.getElementById('edit_status_' + productId);

            let isValid = true;

            // Reset validation states
            this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            // Validate required fields
            if (!designNo.value.trim()) {
                designNo.classList.add('is-invalid');
                isValid = false;
            }

            if (!name.value.trim()) {
                name.classList.add('is-invalid');
                isValid = false;
            }

            if (!categoryId.value) {
                categoryId.classList.add('is-invalid');
                isValid = false;
            }

            if (!price.value || price.value < 0) {
                price.classList.add('is-invalid');
                isValid = false;
            }

            if (!stock.value || stock.value < 0) {
                stock.classList.add('is-invalid');
                isValid = false;
            }

            if (!status.value) {
                status.classList.add('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly.');
            }
        });
    });
});
</script>
@endsection
