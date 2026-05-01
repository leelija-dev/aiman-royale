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
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;"
                            placeholder="Search by product name, design no, or brand" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1"
                            style="height:40px;">Search</button>
                        <a href="{{ route('admin.products') }}" class="btn btn-danger mb-sm-3 mb-1"
                            style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                    <a href="{{ route('admin.products-trashed') }}"
                        class="btn btn-outline-secondary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-trash"></i> View Trashed Products
                    </a>
                    <a href="{{ route('admin.add-product') }}" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-plus"></i> Add New Product
                    </a>
                </div>
            </div>
            <div class="card px-4 pt-2 pb-2">
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Featured Image</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Parts</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $product)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @if ($product->images->count() > 0)
                                            <img src="{{ asset($product->images->first()->image) }}"
                                                class="avatar avatar-sm me-3" alt="{{ $product->name }}">
                                            @else
                                            <img src="https://via.placeholder.com/40"
                                                class="avatar avatar-sm me-3" alt="No image">
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
                                            @if ($product->fabric)
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
                                            <h6 class="mb-0 text-sm">
                                                {{ $product->category ? $product->category->name : 'N/A' }}
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">₹{{ number_format($product->price, 2) }}</h6>
                                            @if ($product->discount_price)
                                            <p class="text-xs text-success mb-0">
                                                ${{ number_format($product->discount_price, 2) }}</p>
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
                                            <span
                                                class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->status }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            @if($product->featured_image)
                                            <img src="{{ asset($product->featured_image) }}"
                                                alt="Featured Image"
                                                class="avatar avatar-sm me-2"
                                                style="max-width: 40px; max-height: 40px; object-fit: cover;">
                                            <span class="text-xs text-success">✓</span>
                                            @else
                                            <img src="https://via.placeholder.com/40"
                                                alt="No Featured Image"
                                                class="avatar avatar-sm me-2"
                                                style="max-width: 40px; max-height: 40px; object-fit: cover;">
                                            <span class="text-xs text-muted">None</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            @php
                                            $partsCount = isset($product->parts) ? $product->parts->count() : 0;
                                            @endphp
                                            <span class="badge bg-info">{{ $partsCount }} Parts</span>
                                            @if($partsCount > 0)
                                            <button type="button" class="btn btn-sm btn-link p-0 mt-1 text-primary"
                                                onclick="showParts({{ $product->id }})">
                                                View Details
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="javascript:void(0);" class="text-secondary font-weight-bold text-xs me-4"
                                        onclick="openEditModal({{ $product->id }}, {{ json_encode($product->occasions ?? []) }})"
                                        title="Edit product">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form id="delete-form-{{ $product->id }}"
                                        action="{{ route('admin.products.delete', $product->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="javascript:void(0);" onclick="confirmDelete({{ $product->id }})">
                                        <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">
                                    <p class="text-muted">No products found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <div>
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modals Container -->
@foreach($data as $product)
<div class="modal fade" id="editModal{{ $product->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $product->id }}">Edit Product: {{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm{{ $product->id }}"
                action="{{ route('admin.products.update', $product->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body text-start" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_design_no_{{ $product->id }}"
                                    class="form-label">Design Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    id="edit_design_no_{{ $product->id }}"
                                    name="design_no"
                                    value="{{ $product->design_no }}" maxlength="40"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_name_{{ $product->id }}"
                                    class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    id="edit_name_{{ $product->id }}" name="name"
                                    value="{{ $product->name }}" maxlength="200"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_slug_{{ $product->id }}"
                                    class="form-label">Slug<span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    id="edit_slug_{{ $product->id }}" name="slug"
                                    value="{{ $product->slug }}" maxlength="200"
                                    required readonly>
                            </div>

                            <div class="mb-3">
                                <label for="edit_brand_{{ $product->id }}"
                                    class="form-label">Brand</label>
                                <select class="form-control" id="edit_brand_{{ $product->id }}" name="brand">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->name }}" {{$brand->name == $product->brand ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="edit_fabric_{{ $product->id }}"
                                    class="form-label">Fabric</label>
                                <input type="text" class="form-control"
                                    id="edit_fabric_{{ $product->id }}"
                                    name="fabric" value="{{ $product->fabric }}"
                                    maxlength="100">
                            </div>

                            <div class="mb-3">
                                <label for="edit_material_care_{{ $product->id }}"
                                    class="form-label">Material Care Instructions</label>
                                <textarea class="form-control"
                                    id="edit_material_care_{{ $product->id }}"
                                    name="material_care" rows="3"
                                    maxlength="1000" placeholder="Enter care instructions such as: Dry clean only, Hand wash cold, Do not bleach, etc.">{{ $product->material_care ?? '' }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit_featured_image_{{ $product->id }}"
                                    class="form-label">Featured Image</label>
                                <input type="file" class="form-control"
                                    id="edit_featured_image_{{ $product->id }}"
                                    name="featured_image" accept="image/*">
                                @if($product->featured_image)
                                <div class="mt-2">
                                    <img src="{{ asset($product->featured_image) }}"
                                        alt="Current Featured Image"
                                        class="img-thumbnail"
                                        style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                    <br>
                                    <small class="text-muted">Current featured image</small>
                                </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="edit_fit_{{ $product->id }}"
                                    class="form-label">Fit</label>
                                <select class="form-control"
                                    id="edit_fit_{{ $product->id }}" name="fit">
                                    <option value="">Select Fit</option>
                                    <option value="Slim"
                                        {{ $product->fit == 'Slim' ? 'selected' : '' }}>
                                        Slim</option>
                                    <option value="Regular"
                                        {{ $product->fit == 'Regular' ? 'selected' : '' }}>
                                        Regular</option>
                                    <option value="A-line"
                                        {{ $product->fit == 'A-line' ? 'selected' : '' }}>
                                        A-line</option>
                                </select>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <hr class="flex-grow-1 hr-line">
                                <span class="px-2 text-muted fw-bold">SEO</span>
                                <hr class="flex-grow-1 hr-line">
                            </div>

                            <div class="mb-3">
                                <label for="edit_meta_title_{{ $product->id }}" class="form-label">Meta Title</label>
                                <input type="text" class="form-control"
                                    id="edit_meta_title_{{ $product->id }}" name="meta_title"
                                    value="{{ $product->meta_title }}">
                            </div>

                            <div class="mb-3">
                                <label for="edit_keywords_{{ $product->id }}" class="form-label">Keywords</label>
                                <input type="text" class="form-control"
                                    id="edit_keywords_{{ $product->id }}" name="keywords"
                                    value="{{ $product->keywords }}">
                            </div>

                            <div class="mb-3">
                                <label for="edit_tags_{{ $product->id }}" class="form-label">Tags</label>
                                <input type="text" class="form-control"
                                    id="edit_tags_{{ $product->id }}" name="tags"
                                    value="{{ $product->tags }}">
                            </div>

                            <div class="mb-3">
                                <label for="edit_meta_description_{{ $product->id }}" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="edit_meta_description_{{ $product->id }}" name="meta_description" rows="4">{{ $product->meta_description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit_schema_markup_{{ $product->id }}" class="form-label">Schema Markup</label>
                                <textarea class="form-control" id="edit_schema_markup_{{ $product->id }}" name="schema_markup" rows="4">{{ $product->schema_markup }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_category_id_{{ $product->id }}"
                                    class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-control"
                                    id="edit_category_id_{{ $product->id }}"
                                    name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{--
                                <div class="mb-3">
                                    <label for="edit_occasion_id_{{ $product->id }}"
                            class="form-label">Occasion</label>
                            <select class="form-control"
                                id="edit_occasion_id_{{ $product->id }}"
                                name="occasion_id">
                                <option value="">Select Occasion</option>
                                @foreach ($occasions as $occasion)
                                <option value="{{ $occasion->id }}"
                                    {{ $product->ocassion_id == $occasion->id ? 'selected' : '' }}>
                                    {{ $occasion->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        --}}
                        <div class="mb-3">
                            <label class="form-label">Occasion</label>

                            <div class="border p-2 rounded" style="max-height: 150px; overflow-y: auto;">
                                @foreach ($occasions as $occasion)
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name="occasion_id[]"
                                        value="{{ $occasion->id }}"
                                        id="edit_occasion_{{ $product->id }}_{{ $occasion->id }}"

                                        {{ in_array($occasion->id, $product->occasions ?? []) ? 'checked' : '' }}>

                                    <label class="form-check-label" for="edit_occasion_{{ $product->id }}_{{ $occasion->id }}">
                                        {{ $occasion->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Specifications Section -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Product Specifications</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Lehenga Fabric -->
                                    {{--
                                            <div class="col-md-6 mb-3">
                                                <label for="edit_lehenga_fabric_{{ $product->id }}" class="form-label">Lehenga Fabric</label>
                                    <input type="text" class="form-control"
                                        id="edit_lehenga_fabric_{{ $product->id }}"
                                        name="lehenga_fabric"
                                        value="{{ $product->lehenga_fabric ?? '' }}" maxlength="100">
                                </div>

                                <!-- Choli Fabric -->
                                <div class="col-md-6 mb-3">
                                    <label for="edit_choli_fabric_{{ $product->id }}" class="form-label">Choli Fabric</label>
                                    <input type="text" class="form-control"
                                        id="edit_choli_fabric_{{ $product->id }}"
                                        name="choli_fabric"
                                        value="{{ $product->choli_fabric ?? '' }}" maxlength="100">
                                </div>

                                <!-- Dupatta Fabric -->
                                <div class="col-md-6 mb-3">
                                    <label for="edit_dupatta_fabric_{{ $product->id }}" class="form-label">Dupatta Fabric</label>
                                    <input type="text" class="form-control"
                                        id="edit_dupatta_fabric_{{ $product->id }}"
                                        name="dupatta_fabric"
                                        value="{{ $product->dupatta_fabric ?? '' }}" maxlength="100">
                                </div>
                                --}}

                                <!-- Type -->
                                {{--
                                            <div class="col-md-6 mb-3">
                                                <label for="edit_type_{{ $product->id }}" class="form-label">Type</label>
                                <input type="text" class="form-control"
                                    id="edit_type_{{ $product->id }}"
                                    name="type"
                                    value="{{ $product->type ?? '' }}" maxlength="100">
                            </div>
                            --}}

                            <!-- Stitching Type -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_stitching_type_{{ $product->id }}" class="form-label">Stitching Type</label>
                                <input type="text" class="form-control"
                                    id="edit_stitching_type_{{ $product->id }}"
                                    name="type"
                                    value="{{ $product->type ?? '' }}">
                            </div>

                            <!-- Pattern -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_pattern_{{ $product->id }}" class="form-label">Pattern</label>
                                <input type="text" class="form-control"
                                    id="edit_pattern_{{ $product->id }}"
                                    name="pattern"
                                    value="{{ $product->pattern ?? '' }}">
                            </div>

                            <!-- Color -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_color_{{ $product->id }}" class="form-label">Color</label>
                                <input type="text" class="form-control"
                                    id="edit_color_{{ $product->id }}"
                                    name="color"
                                    value="{{ $product->color ?? '' }}" maxlength="100">
                            </div>

                            <!-- Sales Package -->
                            <div class="col-md-12 mb-3">
                                <label for="edit_sales_package_{{ $product->id }}" class="form-label">Sales Package</label>
                                <textarea class="form-control"
                                    id="edit_sales_package_{{ $product->id }}"
                                    name="sales_package" rows="2">{{ $product->sales_package ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="edit_price_{{ $product->id }}"
                        class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="number" class="form-control"
                        id="edit_price_{{ $product->id }}"
                        name="price" value="{{ $product->price }}"
                        step="0.01" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="edit_discount_price_{{ $product->id }}"
                        class="form-label">Discount Price</label>
                    <input type="number" class="form-control"
                        id="edit_discount_price_{{ $product->id }}"
                        name="discount_price"
                        value="{{ $product->discount_price }}"
                        step="0.01" min="0">
                </div>

                <div class="mb-3">
                    <label for="edit_stock_{{ $product->id }}"
                        class="form-label">Stock <span class="text-danger">*</span></label>
                    <input type="number" class="form-control"
                        id="edit_stock_{{ $product->id }}"
                        name="stock" value="{{ $product->stock ?? 0 }}"
                        min="0" required>
                </div>

                <div class="mb-3">
                    <label for="edit_status_{{ $product->id }}"
                        class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-control"
                        id="edit_status_{{ $product->id }}"
                        name="status" required>
                        <option value="active"
                            {{ $product->status == 'active' ? 'selected' : '' }}>
                            Active</option>
                        <option value="inactive"
                            {{ $product->status == 'inactive' ? 'selected' : '' }}>
                            Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_is_featured_{{ $product->id }}"
                        class="form-label">Is Featured</label>
                    <select class="form-control"
                        id="edit_is_featured_{{ $product->id }}"
                        name="is_featured">
                        <option value="0"
                            {{ $product->is_featured == false ? 'selected' : '' }}>
                            No</option>
                        <option value="1"
                            {{ $product->is_featured == true ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_image_{{ $product->id }}"
                        class="form-label">Product Image</label>
                    <input type="file" class="form-control"
                        id="edit_image_{{ $product->id }}"
                        name="image" accept="image/*">
                    @if ($product->images->count() > 0)
                    <div class="mt-2">
                        <img src="{{ asset($product->images->first()->image) }}"
                            alt="Current Image"
                            class="img-thumbnail"
                            style="max-width: 100px; max-height: 100px; object-fit: cover;">
                        <br>
                        <small class="text-muted">Current image</small>
                    </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="edit_description_{{ $product->id }}"
                        class="form-label">Description</label>
                    <textarea class="form-control" id="edit_description_{{ $product->id }}" name="description" rows="4">{{ $product->description }}</textarea>
                </div>
        </div>
    </div>

    <!-- Product Parts Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                    <h5 class="mb-0">Product Parts</h5>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addProductPart({{ $product->id }})">
                        <i class="fas fa-plus"></i> Add Part
                    </button>
                </div>
                <div class="card-body">
                    <div id="product-parts-container-{{ $product->id }}" class="product-parts-container">
                        <!-- Existing parts will be loaded here via JavaScript -->
                    </div>
                </div>
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
@endforeach

<!-- Parts View Modal -->
<div class="modal fade" id="partsViewModal" tabindex="-1" aria-labelledby="partsViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="partsViewModalLabel">Product Parts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="parts-view-content" class="text-center py-3">
                    <p class="text-muted">Loading...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    console.log('Script is executing...');
    
    // Store existing parts data
    const productParts = {};

    // Initialize when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Fix for navbar error
        if (typeof navbarColorOnResize === 'function') {
            try {
                navbarColorOnResize();
            } catch (e) {
                console.log('Navbar function error (ignored)');
            }
        }

        // Load existing parts when edit modal is opened
        @foreach($data as $product)
            (function(productId) {
                const modal = document.getElementById('editModal' + productId);
                if (modal) {
                    modal.addEventListener('show.bs.modal', function() {
                        loadExistingParts(productId);
                    });

                    // Reset parts container when modal is closed
                    modal.addEventListener('hidden.bs.modal', function() {
                        const container = document.getElementById('product-parts-container-' + productId);
                        if (container) {
                            container.innerHTML = '';
                        }
                    });
                }
            })({{ $product->id }});
        @endforeach

        // Form validation for edit modals
        document.querySelectorAll('form[id^="editForm"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const productId = this.id.replace('editForm', '');

                // Check if there are any parts with empty required fields
                const container = document.getElementById('product-parts-container-' + productId);
                if (container) {
                    const partItems = container.querySelectorAll('.part-item');
                    let hasEmptyPartName = false;

                    partItems.forEach((item, index) => {
                        const partName = item.querySelector('.part-name');
                        if (partName && !partName.value.trim()) {
                            partName.classList.add('is-invalid');
                            hasEmptyPartName = true;
                        } else if (partName) {
                            partName.classList.remove('is-invalid');
                        }
                    });

                    if (hasEmptyPartName) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please fill in all part names or remove empty parts.'
                        });
                        return;
                    }
                }
            });
        });
    });

    function confirmDelete(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                document.getElementById('delete-form-' + productId).submit();
                return false;
            }
        });
    }

    function openEditModal(productId, occasionIds) {
        console.log('openEditModal called with:', productId, occasionIds);
        
        const modalElement = document.getElementById('editModal' + productId);
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);

            // Handle checkboxes for multiple occasions
            if (occasionIds && Array.isArray(occasionIds)) {
                occasionIds.forEach(occasionId => {
                    const checkbox = document.getElementById('edit_occasion_' + productId + '_' + occasionId);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }

            modal.show();
        }
    }
    
    console.log('openEditModal function defined');

    // Product Parts Functions
    function loadExistingParts(productId) {
        const container = document.getElementById('product-parts-container-' + productId);
        if (!container) return;

        // Clear container first
        container.innerHTML = '';

        // Check if product has parts
        if (productParts[productId] && productParts[productId].length > 0) {
            productParts[productId].forEach((part, index) => {
                addExistingPartToContainer(container, part, index, productId);
            });
        }
    }

    function addExistingPartToContainer(container, part, index, productId) {
        const partDiv = document.createElement('div');
        partDiv.className = 'part-item border rounded p-3 mb-3';
        partDiv.style.background = '#f8f9fa';
        partDiv.setAttribute('data-part-index', index);
        partDiv.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 part-number">Part ${index + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removePart(this, ${productId})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Part Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control part-name" name="parts[${index}][part_name]" 
                               value="${escapeHtml(part.part_name || '')}" placeholder="e.g., Lehenga, Choli, Dupatta">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fabric</label>
                        <input type="text" class="form-control" name="parts[${index}][fabric]" 
                               value="${escapeHtml(part.fabric || '')}" placeholder="e.g., Art Silk, Cotton, Net">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Work Type</label>
                        <input type="text" class="form-control" name="parts[${index}][work_type]" 
                               value="${escapeHtml(part.work_type || '')}" placeholder="e.g., Zari Work, Mirror Work, Thread Work">
                    </div>
                </div>
            `;
        container.appendChild(partDiv);
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function addProductPart(productId) {
        const container = document.getElementById('product-parts-container-' + productId);
        if (!container) return;

        // Get current part count for index
        const partCount = container.children.length;

        // Create new part element from scratch (not from template)
        const newPart = document.createElement('div');
        newPart.className = 'part-item border rounded p-3 mb-3';
        newPart.style.background = '#f8f9fa';
        newPart.setAttribute('data-part-index', partCount);
        newPart.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 part-number">Part ${partCount + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removePart(this, ${productId})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Part Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control part-name" name="parts[${partCount}][part_name]" 
                               placeholder="e.g., Lehenga, Choli, Dupatta">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fabric</label>
                        <input type="text" class="form-control" name="parts[${partCount}][fabric]" 
                               placeholder="e.g., Art Silk, Cotton, Net">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Work Type</label>
                        <input type="text" class="form-control" name="parts[${partCount}][work_type]" 
                               placeholder="e.g., Zari Work, Mirror Work, Thread Work">
                    </div>
                </div>
            `;

        container.appendChild(newPart);
    }

    function removePart(button, productId) {
        const partItem = button.closest('.part-item');
        if (partItem) {
            Swal.fire({
                title: 'Remove Part?',
                text: "Are you sure you want to remove this part?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    partItem.remove();
                    // Reindex remaining parts
                    reindexParts(productId);
                }
            });
        }
    }

    function reindexParts(productId) {
        const container = document.getElementById('product-parts-container-' + productId);
        if (!container) return;

        const parts = container.querySelectorAll('.part-item');
        parts.forEach((part, index) => {
            // Update data attribute
            part.setAttribute('data-part-index', index);

            // Update heading
            const heading = part.querySelector('.part-number');
            if (heading) {
                heading.textContent = `Part ${index + 1}`;
            }

            // Update input names
            const partNameInput = part.querySelector('input[name*="[part_name]"]');
            const fabricInput = part.querySelector('input[name*="[fabric]"]');
            const workTypeInput = part.querySelector('input[name*="[work_type]"]');

            if (partNameInput) {
                partNameInput.setAttribute('name', `parts[${index}][part_name]`);
            }
            if (fabricInput) {
                fabricInput.setAttribute('name', `parts[${index}][fabric]`);
            }
            if (workTypeInput) {
                workTypeInput.setAttribute('name', `parts[${index}][work_type]`);
            }
        });
    }

    function showParts(productId) {
        const modal = new bootstrap.Modal(document.getElementById('partsViewModal'));
        const contentDiv = document.getElementById('parts-view-content');

        if (productParts[productId] && productParts[productId].length > 0) {
            let html = '<div class="table-responsive"><table class="table table-bordered table-hover">';
            html += '<thead class="table-light"><tr><th>#</th><th>Part Name</th><th>Fabric</th><th>Work Type</th></tr></thead><tbody>';

            productParts[productId].forEach((part, index) => {
                html += `<tr>
                        <td>${index + 1}</td>
                        <td>${escapeHtml(part.part_name || '-')}</td>
                        <td>${escapeHtml(part.fabric || '-')}</td>
                        <td>${escapeHtml(part.work_type || '-')}</td>
                    </tr>`;
            });

            html += '</tbody></table></div>';
            contentDiv.innerHTML = html;
        } else {
            contentDiv.innerHTML = '<p class="text-muted text-center py-4">No parts available for this product.</p>';
        }

        modal.show();
    }

    // Product Parts Functions
    function loadExistingParts(productId) {
        const container = document.getElementById('product-parts-container-' + productId);
        if (!container) return;

        const parts = productParts[productId] || [];
        
        if (parts.length > 0) {
            let html = '<div class="table-responsive"><table class="table table-sm"><thead><tr><th>Part Name</th><th>Quantity</th><th>Actions</th></tr></thead><tbody>';
            
            parts.forEach((part, index) => {
                html += `<tr>
                    <td><input type="text" class="form-control form-control-sm" name="parts[${productId}][${index}][name]" value="${part.name || ''}" placeholder="Part name"></td>
                    <td><input type="number" class="form-control form-control-sm" name="parts[${productId}][${index}][quantity]" value="${part.quantity || 1}" min="1"></td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removePart(this)">Remove</button></td>
                </tr>`;
            });
            
            html += '</tbody></table></div>';
            container.innerHTML = html;
        } else {
            container.innerHTML = '<p class="text-muted text-center py-4">No parts available for this product.</p>';
        }

        modal.show();
    }
</script>

<style>
    .part-item {
        transition: all 0.3s ease;
    }

    .part-item:hover {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .hr-line {
        border-top: 2px solid #dee2e6;
        opacity: 1;
    }

    .product-parts-container {
        min-height: 50px;
    }
</style>
@endsection