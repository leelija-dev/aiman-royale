@extends('Admin.layouts.master')
@section('source', 'Product Variant')
@section('page-title', 'Product Variants')

@section('title')
{{ config('app.name') }} - Product Variants
@endsection
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">

@endsection

<style>
 /* Dropzone container */
.dropzone {
    display: flex !important;
    flex-wrap: wrap;
    gap: 12px;
    padding: 10px;
}

/* Each preview box */
.dropzone .dz-preview {
    width: calc(33.333% - 12px) !important; /* 3 per row */
    margin: 0 !important;
    position: relative;
}

/* Thumbnail image */
.dropzone .dz-image {
    width: 100%;
    height: 140px;
    border-radius: 8px;
    overflow: hidden;
}

.dropzone .dz-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* File name */
.dropzone .dz-details {
    text-align: center;
    font-size: 12px;
}

/* Remove button style */
.dropzone .dz-remove {
    display: block;
    text-align: center;
    color: red;
    font-size: 12px;
    margin-top: 4px;
}

/* Success / Error icons positioning */
.dropzone .dz-success-mark,
.dropzone .dz-error-mark {
    position: absolute;
    top: 6px;
    right: 6px;
}

/* Hide big default icons */
.dropzone .dz-progress {
    display: none;
}
/* Hide dropzone message when files exist */
.dropzone.dz-started .dz-message {
    display: none !important;
}


</style>
@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.product-variants') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;" placeholder="Search by SKU, size, color, or product name" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1" style="height:40px;">Search</button>
                        <a href="{{ route('admin.product-variants') }}" class="btn btn-danger mb-sm-3 mb-1" style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Button -->
                <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-lg-50">
                    <a href="{{ route('admin.product-variants.create') }}" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-plus"></i> Add New Variant
                    </a>
                </div>
            </div>
            <div class="card px-4 pt-2 pb-2">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <form method="GET" action="{{ route('admin.product-variants') }}">
                            <label for="product_id" class="form-label">Filter by Product</label>
                            <select name="product_id" class="form-control" onchange="this.form.submit()">
                                <option value="">All Products</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name ?? '' }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form method="GET" action="{{ route('admin.product-variants') }}">
                            <label for="color" class="form-label">Filter by Color</label>
                            <select name="color" class="form-control" onchange="this.form.submit()">
                                <option value="">All Colors</option>
                                @foreach($colors as $color)
                                <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>
                                    {{ $color }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form method="GET" action="{{ route('admin.product-variants') }}">
                            <label for="size" class="form-label">Filter by Size</label>
                            <select name="size" class="form-control" onchange="this.form.submit()">
                                <option value="">All Sizes</option>
                                @foreach($sizes as $size)
                                <option value="{{ $size->code }}" {{ request('size') == $size->code ? 'selected' : '' }}>
                                    {{ $size->code }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SKU</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Color</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Size</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $variant)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $variant->product->name ?? '' }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-sm">{{ $variant->sku }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            @if($variant->color)
                                                <span class="text-sm">{{ $variant->color }}</span>
                                                @if($variant->colorModel)
                                                    <div class="color-preview" style="width: 16px; height: 16px; background-color: {{ $variant->colorModel->code }}; border: 1px solid #ddd; border-radius: 2px;"></div>
                                                @endif
                                            @else
                                                <span class="text-sm text-muted">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-sm">{{ $variant->size ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">${{ number_format($variant->effective_price, 2) }}</h6>
                                            @if($variant->discount_price)
                                            <p class="text-xs text-success mb-0">${{ number_format($variant->price, 2) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="badge {{ $variant->stock > 0 ? 'bg-success' : 'bg-danger' }} text-white">
                                                {{ $variant->stock }} in stock
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="#" class="text-secondary font-weight-bold text-xs me-4"
                                           data-bs-toggle="modal" data-bs-target="#editModal{{ $variant->id }}"
                                           title="Edit variant">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="javascript:void(0);" 
                                           onclick="openStockModal({{ $variant->id }}, '{{ $variant->sku }}', {{ $variant->stock }})"
                                           class="text-info font-weight-bold text-xs me-4"
                                           title="Add Stock">
                                            <i class="fa-solid fa-warehouse"></i>
                                        </a>
                                        <form id="delete-form-{{ $variant->id }}"
                                              action="{{ route('admin.product-variants.destroy', $variant->id) }}"
                                              method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="javascript:void(0);"
                                           onclick="confirmDelete({{ $variant->id }})">
                                            <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $variant->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $variant->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $variant->id }}">Edit Product Variant</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="editForm{{ $variant->id }}"
                                              action="{{ route('admin.product-variants.update', $variant->id) }}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-start">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="edit_product_id_{{ $variant->id }}" class="form-label">Product <span class="text-danger">*</span></label>
                                                            <select class="form-control" id="edit_product_id_{{ $variant->id }}" name="product_id" required>
                                                                <option value="">Select Product</option>
                                                                @foreach($products as $product)
                                                                <option value="{{ $product->id }}" {{ $variant->product_id == $product->id ? 'selected' : '' }}>
                                                                    {{ $product->name ?? '' }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_sku_{{ $variant->id }}" class="form-label">SKU <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="edit_sku_{{ $variant->id }}" name="sku" 
                                                                   value="{{ $variant->sku }}" maxlength="100" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_price_{{ $variant->id }}" class="form-label">Price <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="edit_price_{{ $variant->id }}" name="price" 
                                                                   value="{{ $variant->price }}" step="0.01" min="0" required>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <label class="form-label">Variant Images</label>

                                                            <div id="dropzone-{{ $variant->id }}" 
                                                                class="dropzone border rounded p-2">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="removed_images" id="removed_images_{{ $variant->id }}">

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="edit_color_{{ $variant->id }}" class="form-label">Color</label>
                                                            <select class="form-control" id="edit_color_{{ $variant->id }}" name="color">
                                                                <option value="">No Color</option>
                                                                @foreach($colors as $color)
                                                                <option value="{{ $color }}" {{ $variant->color == $color ? 'selected' : '' }}>
                                                                    {{ $color }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_size_{{ $variant->id }}" class="form-label">Size</label>
                                                            <select class="form-control" id="edit_size_{{ $variant->id }}" name="size">
                                                                <option value="" selected hidden>Select Size</option>
                                                                @foreach($sizes as $size)
                                                                <option value="{{ $size->code }}" {{ $variant->size == $size->code ? 'selected' : '' }}>
                                                                    {{ $size->name }}({{$size->code}})
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @error('size')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_discount_{{ $variant->id }}" class="form-label">Discount (%)</label>
                                                            <input type="number" class="form-control" id="edit_discount_{{ $variant->id }}" name="discount" 
                                                                   value="{{ $variant->discount }}" step="0.01" min="0">
                                                            @error('discount')
                                                            <div class="text-danger small">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_stock_{{ $variant->id }}" class="form-label">Stock <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="edit_stock_{{ $variant->id }}" name="stock" 
                                                                   value="{{ $variant->stock }}" min="0" required readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_video_url_{{ $variant->id }}" class="form-label">Video URL</label>
                                                            <input type="url" class="form-control" id="edit_video_url_{{ $variant->id }}" name="video_url" 
                                                                   value="{{ $variant->video_url }}" placeholder="https://www.youtube.com/watch?v=...">
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
                            <!-- Stock Update Modal -->
                            <div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="stockModalLabel">Add Stock</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="stockUpdateForm" action="{{ route('admin.stock.update') }}" method="POST">
                                            @csrf
                                            <div class="modal-body text-start">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="stock_variant_id" class="form-label">Variant SKU</label>
                                                            <input type="text" class="form-control" id="stock_variant_id" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="current_stock" class="form-label">Current Stock</label>
                                                            <input type="number" class="form-control" id="current_stock" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="new_stock" class="form-label">Stock to Add <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="new_stock" name="stock" 
                                                                   min="0" required placeholder="Enter quantity to add">
                                                            <small class="text-muted">This amount will be added to the current stock</small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="stock_notes" class="form-label">Notes</label>
                                                            <textarea class="form-control" id="stock_notes" name="notes" rows="3" 
                                                                      placeholder="Optional notes about this stock update"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update Stock</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <p class="text-muted">No product variants found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class=" mt-4">
                    {{-- <div class="text-muted">
                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
                    </div> --}}
                    <div>
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">

@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

@section('scripts')
<script>
// function confirmDelete(variantId) {
//     if (confirm('Are you sure you want to delete this product variant?')) {
//         document.getElementById('delete-form-' + variantId).submit();
//     }
// }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be delete this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    

function openStockModal(variantId, sku, currentStock) {
    document.getElementById('stock_variant_id').value = sku;
    document.getElementById('current_stock').value = currentStock;
    document.getElementById('new_stock').value = ''; // Clear the input for user to enter amount to add
    document.getElementById('stock_notes').value = '';
    
    // Add hidden input for variant ID
    const form = document.getElementById('stockUpdateForm');
    const existingInput = document.getElementById('variant_id_input');
    if (existingInput) {
        existingInput.remove();
    }
    
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'variant_id';
    hiddenInput.id = 'variant_id_input';
    hiddenInput.value = variantId;
    form.appendChild(hiddenInput);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('stockModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Form validation for edit modals
    document.querySelectorAll('form[id^="editForm"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const variantId = this.id.replace('editForm', '');
            const productId = document.getElementById('edit_product_id_' + variantId);
            const sku = document.getElementById('edit_sku_' + variantId);
            const price = document.getElementById('edit_price_' + variantId);
            const stock = document.getElementById('edit_stock_' + variantId);

            let isValid = true;

            // Reset validation states
            this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            // Validate required fields
            if (!productId.value) {
                productId.classList.add('is-invalid');
                isValid = false;
            }

            if (!sku.value.trim()) {
                sku.classList.add('is-invalid');
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

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly.');
            }
        });
    });
});
</script>
<script>
Dropzone.autoDiscover = false;

@foreach($data as $variant)

let existingImages{{ $variant->id }} = @json($variant->images);
let removedImages{{ $variant->id }} = [];

let dz{{ $variant->id }} = new Dropzone("#dropzone-{{ $variant->id }}", {

    url: "#",
    autoProcessQueue: false,
    maxFiles: 10,
    paramName: "images[]",
    acceptedFiles: ".jpg,.jpeg,.png,.webp",
    addRemoveLinks: true,

    init: function () {

        let dz = this;

        // PRELOAD OLD IMAGES
        existingImages{{ $variant->id }}.forEach(function(image){

            let mockFile = {
                name: image.image,
                size: 12345,
                serverId: image.id
            };

            dz.emit("addedfile", mockFile);
            dz.emit("thumbnail", mockFile,
                "{{ asset('uploads/variants') }}/" + image.image
            );
            dz.emit("complete", mockFile);

            dz.files.push(mockFile);
            dz.element.classList.add("dz-started");
        });

        // TRACK REMOVED IMAGES
        dz.on("removedfile", function(file){

            if(file.serverId){
                removedImages{{ $variant->id }}.push(file.serverId);
            }

            if(dz.files.length === 0){
                dz.element.classList.remove("dz-started");
            }

        });

    }
});


// FORM SUBMIT FIX
document.getElementById("editForm{{ $variant->id }}")
.addEventListener("submit", function(){

    // STORE REMOVED IDS
    document.getElementById("removed_images_{{ $variant->id }}").value =
        removedImages{{ $variant->id }}.join(',');

    // APPEND NEW FILES TO FORM
    dz{{ $variant->id }}.files.forEach(function(file){

        if(!file.serverId){ // only NEW files

            let input = document.createElement("input");
            input.type = "file";
            input.name = "images[]";

            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;

            document.getElementById("editForm{{ $variant->id }}")
                .appendChild(input);
        }

    });

});

@endforeach
</script>


@endsection
