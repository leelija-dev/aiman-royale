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
                        <div
                            class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Design
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product
                                        Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Brand
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Featured Image
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions
                                    </th>
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
                                                        {{ $product->category ? $product->category->name : 'N/A' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">${{ number_format($product->price, 2) }}</h6>
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
                                                        <img src="{{ asset('assets/img/placeholder.png') }}" 
                                                             alt="No Featured Image" 
                                                             class="avatar avatar-sm me-2" 
                                                             style="max-width: 40px; max-height: 40px; object-fit: cover;">
                                                        <span class="text-xs text-muted">None</span>
                                                    @endif
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

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $product->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $product->id }}">Edit
                                                        Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
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
                                                                    <label for="edit_design_no_{{ $product->id }}"
                                                                        class="form-label">Design Number <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        id="edit_design_no_{{ $product->id }}"
                                                                        name="design_no"
                                                                        value="{{ $product->design_no }}" maxlength="40"
                                                                        required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="edit_name_{{ $product->id }}"
                                                                        class="form-label">Product Name <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        id="edit_name_{{ $product->id }}" name="name"
                                                                        value="{{ $product->name }}" maxlength="200"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="slug{{ $product->id }}"
                                                                        class="form-label">slug<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        id="edit_slug_{{ $product->slug }}" name="slug"
                                                                        value="{{ $product->slug }}" maxlength="200"
                                                                        required readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edit_brand_{{ $product->id }}"
                                                                        class="form-label">Brand</label>
                                                                        <select class="form-control" id="brand" name="brand">
                                                                            <option value="" selected hidden>Select Brand</option>
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

                                                                <!-- Specifications Section -->
                                                                <div class="card mb-3">
                                                                    <div class="card-header">
                                                                        <h6 class="mb-0">Product Specifications</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <!-- Lehenga Fabric -->
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

                                                                            <!-- Type -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label for="edit_type_{{ $product->id }}" class="form-label">Type</label>
                                                                                <input type="text" class="form-control" 
                                                                                       id="edit_type_{{ $product->id }}" 
                                                                                       name="type" 
                                                                                       value="{{ $product->type ?? '' }}" maxlength="100">
                                                                            </div>

                                                                            <!-- Stitching Type -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label for="edit_stitching_type_{{ $product->id }}" class="form-label">Stitching Type</label>
                                                                                <input type="text" class="form-control" 
                                                                                       id="edit_stitching_type_{{ $product->id }}" 
                                                                                       name="stitching_type" 
                                                                                       value="{{ $product->stitching_type ?? '' }}" maxlength="100">
                                                                            </div>

                                                                            <!-- Pattern -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label for="edit_pattern_{{ $product->id }}" class="form-label">Pattern</label>
                                                                                <input type="text" class="form-control" 
                                                                                       id="edit_pattern_{{ $product->id }}" 
                                                                                       name="pattern" 
                                                                                       value="{{ $product->pattern ?? '' }}" maxlength="100">
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

                                                                <!-- Product Parts Section -->
                                                                <div class="card mb-3">
                                                                    <div class="card-header d-flex justify-content-between align-items-center">
                                                                        <h6 class="mb-0">Product Parts</h6>
                                                                        <button type="button" class="btn btn-sm btn-primary" onclick="addProductPart({{ $product->id }})">
                                                                            <i class="fas fa-plus"></i> Add Part
                                                                        </button>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div id="product-parts-container-{{ $product->id }}">
                                                                            @if($product->parts && $product->parts->count() > 0)
                                                                                @foreach($product->parts as $index => $part)
                                                                                    <div class="part-item border rounded p-3 mb-3" style="background: #f8f9fa;">
                                                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                                                            <h6 class="mb-0">Part {{ $index + 1 }}</h6>
                                                                                            <button type="button" class="btn btn-sm btn-danger" onclick="removePart(this)">
                                                                                                <i class="fas fa-trash"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 mb-3">
                                                                                                <label class="form-label">Part Name *</label>
                                                                                                <input type="text" class="form-control part-name" name="parts[{{ $index }}][part_name]" 
                                                                                                       value="{{ $part->part_name }}" placeholder="e.g., Lehenga, Choli, Dupatta" required>
                                                                                            </div>
                                                                                            <div class="col-md-6 mb-3">
                                                                                                <label class="form-label">Fabric</label>
                                                                                                <input type="text" class="form-control" name="parts[{{ $index }}][fabric]" 
                                                                                                       value="{{ $part->fabric }}" placeholder="e.g., Art Silk, Cotton, Net">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                        
                                                                        <!-- Template for new part - WITHOUT required attribute -->
                                                                        <div id="part-template-{{ $product->id }}" style="display: none;">
                                                                            <div class="part-item border rounded p-3 mb-3" style="background: #f8f9fa;">
                                                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                                                    <h6 class="mb-0">New Part</h6>
                                                                                    <button type="button" class="btn btn-sm btn-danger" onclick="removePart(this)">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6 mb-3">
                                                                                        <label class="form-label">Part Name *</label>
                                                                                        <input type="text" class="form-control part-name" name="parts[new_part_index][part_name]" 
                                                                                               placeholder="e.g., Lehenga, Choli, Dupatta">
                                                                                    </div>
                                                                                    <div class="col-md-6 mb-3">
                                                                                        <label class="form-label">Fabric</label>
                                                                                        <input type="text" class="form-control" name="parts[new_part_index][fabric]" 
                                                                                               placeholder="e.g., Art Silk, Cotton, Net">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
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
                                                                    <label for="fabric" class="form-label">Meta
                                                                        Title<sup class="text-danger">*</sup></label>
                                                                    <input type="text" class="form-control"
                                                                        id="meta_title" name="meta_title"
                                                                        value="{{ $product->meta_title }}">
                                                                    @error('meta_title')
                                                                        <div class="text-danger small">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="keywords" class="form-label">Keywords<sup
                                                                            class="text-danger">*</sup></label>
                                                                    <input type="text" class="form-control"
                                                                        id="keywords" name="keywords"
                                                                        value="{{ $product->keywords }}" required>
                                                                    @error('keywords')
                                                                        <div class="text-danger small">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tags" class="form-label">Tags<sup
                                                                            class="text-danger">*</sup></label>
                                                                    <input type="text" class="form-control"
                                                                        id="tags" name="tags"
                                                                        value="{{ $product->tags }}" required>
                                                                    @error('tags')
                                                                        <div class="text-danger small">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                <!-- Meta Description -->

                                                                <div class="mb-3">
                                                                    <label for="meta_description" class="form-label">Meta
                                                                        Description<sup class="text-danger">*</sup></label>
                                                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="4" required>{{ $product->meta_description }}</textarea>
                                                                    @error('meta_description')
                                                                        <div class="text-danger small">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="schema_markup" class="form-label">Schema
                                                                        Markup</label>
                                                                    <textarea class="form-control" id="schema_markup" name="schema_markup" rows="4">{{ $product->schema_markup }}</textarea>
                                                                    @error('schema_markup')
                                                                        <div class="text-danger small">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="edit_category_id_{{ $product->id }}"
                                                                        class="form-label">Category <span
                                                                            class="text-danger">*</span></label>
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

                                                                <div class="mb-3">
                                                                    <label for="edit_price_{{ $product->id }}"
                                                                        class="form-label">Price <span
                                                                            class="text-danger">*</span></label>
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
                                                                        class="form-label">Stock <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="number" class="form-control"
                                                                        id="edit_stock_{{ $product->id }}"
                                                                        name="stock" value="{{ $product->stock ?? 0 }}"
                                                                        min="0" required readonly>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="edit_status_{{ $product->id }}"
                                                                        class="form-label">Status <span
                                                                            class="text-danger">*</span></label>
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
                                                                        class="form-label">Product Image<sup class="text-danger">*</sup></label>
                                                                    <input type="file" class="form-control"
                                                                        id="edit_image_{{ $product->id }}"
                                                                        name="image" accept="image/*">
                                                                    @if ($product->images->count() > 0)
                                                                        <small class="text-muted">Current:
                                                                            {{ $product->images->first()->image }}</small>
                                                                    @endif
                                                                    @error('image')
                                                                    <div class="text-danger small">{{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="edit_description_{{ $product->id }}"
                                                                        class="form-label">Description</label>
                                                                    <textarea class="form-control" id="edit_description_{{ $product->id }}" name="description" rows="4">{{ $product->description }}</textarea>
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <p class="text-muted">No products found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class=" mt-4">
                        <div>
                            {{ $data->links('pagination::bootstrap-5') }}
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

        function openEditModal(productId, occasionId) {
            const modal = new bootstrap.Modal(document.getElementById('editModal' + productId));
            
            const occasionSelect = document.getElementById('edit_occasion_id_' + productId);
            if (occasionSelect && occasionId && !occasionSelect.value) {
                occasionSelect.value = occasionId;
            }
            
            modal.show();
        }

        // Store part counters for each product
        let partCounters = {};

        function addProductPart(productId) {
            // Initialize counter for this product if not exists
            if (!partCounters[productId]) {
                const existingParts = document.querySelectorAll('#product-parts-container-' + productId + ' .part-item');
                partCounters[productId] = existingParts.length;
            }
            
            const container = document.getElementById('product-parts-container-' + productId);
            const template = document.getElementById('part-template-' + productId);
            const clone = template.cloneNode(true);
            
            // Update part number
            partCounters[productId]++;
            const partHeader = clone.querySelector('h6');
            if (partHeader) {
                partHeader.textContent = 'Part ' + partCounters[productId];
            }
            
            // Update name attributes with unique indices and add required attribute
            const inputs = clone.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes('new_part_index')) {
                    const newName = name.replace('new_part_index', partCounters[productId] - 1);
                    input.setAttribute('name', newName);
                    
                    // Add required attribute to part_name field
                    if (input.classList.contains('part-name')) {
                        input.setAttribute('required', 'required');
                    }
                }
            });
            
            // Show the cloned part
            clone.style.display = 'block';
            clone.id = '';
            container.appendChild(clone);
            
            // Update order numbers
            updatePartOrders(productId);
        }

        function removePart(button) {
            const partItem = button.closest('.part-item');
            if (partItem) {
                partItem.remove();
                const container = partItem.closest('[id^="product-parts-container-"]');
                if (container) {
                    const productId = container.id.replace('product-parts-container-', '');
                    
                    // Update counter
                    if (partCounters[productId]) {
                        partCounters[productId]--;
                    }
                    
                    updatePartOrders(productId);
                }
            }
        }

        function updatePartOrders(productId) {
            const parts = document.querySelectorAll('#product-parts-container-' + productId + ' .part-item');
            parts.forEach((part, index) => {
                // Update part number display
                const partHeader = part.querySelector('h6');
                if (partHeader) {
                    partHeader.textContent = 'Part ' + (index + 1);
                }
                
                // Update all input names to use new index
                const inputs = part.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name && name.startsWith('parts[')) {
                        const match = name.match(/parts\[\d+\]\[(.+)\]/);
                        if (match && match[1]) {
                            const fieldName = match[1];
                            input.setAttribute('name', 'parts[' + index + '][' + fieldName + ']');
                        }
                    }
                });
            });
            
            // Update counter
            partCounters[productId] = parts.length;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize part counters
            document.querySelectorAll('[id^="product-parts-container-"]').forEach(container => {
                const productId = container.id.replace('product-parts-container-', '');
                const existingParts = container.querySelectorAll('.part-item');
                partCounters[productId] = existingParts.length;
            });
            
            // Remove required attribute from all hidden template fields before form submission
            document.querySelectorAll('form[id^="editForm"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Find all hidden templates and remove required attributes
                    const hiddenTemplates = this.querySelectorAll('[id^="part-template-"]');
                    hiddenTemplates.forEach(template => {
                        const requiredFields = template.querySelectorAll('[required]');
                        requiredFields.forEach(field => {
                            field.removeAttribute('required');
                        });
                    });
                    
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

                    // Validate product parts
                    const partContainer = document.getElementById('product-parts-container-' + productId);
                    if (partContainer) {
                        const partItems = partContainer.querySelectorAll('.part-item');
                        partItems.forEach((item, index) => {
                            const partName = item.querySelector('.part-name');
                            if (partName && !partName.value.trim()) {
                                partName.classList.add('is-invalid');
                                isValid = false;
                                if (!document.activeElement || document.activeElement !== partName) {
                                    partName.focus();
                                }
                                alert('Please fill in Part Name for Part ' + (index + 1));
                            }
                        });
                    }

                    if (!isValid) {
                        e.preventDefault();
                        if (!document.querySelector('.part-validation-error')) {
                            alert('Please fill in all required fields correctly.');
                        }
                    }
                });
            });
        });
    </script>
@endsection