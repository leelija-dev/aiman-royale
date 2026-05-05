@extends('Admin.layouts.master')
@section('source', 'Product')
@section('page-title', 'Add Product')

@section('title')
{{ config('app.name') }} - Add Product
@endsection
<style>
    .hr-line {
        border-top: 2px solid #0408382d !important;
        opacity: 1 !important;
    }
</style>
@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header px-5 pb-0">
                <h6>Add New Product</h6>
            </div>
            <div class="card px-5 pt-2 pb-3">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Design Number -->
                            <div class="mb-3">
                                <label for="design_no" class="form-label">Design Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="design_no" name="design_no"
                                    value="{{ old('design_no') }}" maxlength="40" required>
                                @error('design_no')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Product Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" maxlength="200" required>
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- slug -->
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    value="{{ old('slug') }}" maxlength="255" required>
                                @error('slug')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Brand -->
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                {{-- <input type="text" class="form-control" id="brand" name="brand" 
                                       value="{{ old('brand') }}" maxlength="100"> --}}
                                <select class="form-control" id="brand" name="brand">
                                    <option value="" selected hidden>Select Brand</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->name }}" {{ old('brand') == $brand->name ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('brand')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fabric -->
                            <div class="mb-3">
                                <label for="fabric" class="form-label">Fabric</label>
                                <input type="text" class="form-control" id="fabric" name="fabric"
                                    value="{{ old('fabric') }}" maxlength="100">
                                @error('fabric')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Material Care -->
                            <div class="mb-3">
                                <label for="material_care" class="form-label">Material Care Instructions</label>
                                <textarea class="form-control" id="material_care" name="material_care"
                                    rows="3" maxlength="1000" placeholder="Enter care instructions such as: Dry clean only, Hand wash cold, Do not bleach, etc.">{{ old('material_care') }}</textarea>
                                @error('material_care')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Featured Image -->
                            <div class="mb-3">
                                <label for="featured_image" class="form-label">Featured Image</label>
                                <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
                                @error('featured_image')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Upload a featured image. Will be compressed to ~10KB.</small>
                            </div>

                            <!-- Specifications Section -->
                             {{--
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">Product Specifications</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Lehenga Fabric -->
                                        <div class="col-md-6 mb-3">
                                            <label for="lehenga_fabric" class="form-label">Lehenga Fabric</label>
                                            <input type="text" class="form-control" id="lehenga_fabric" name="lehenga_fabric"
                                                value="{{ old('lehenga_fabric') }}" maxlength="100">
                                            @error('lehenga_fabric')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Choli Fabric -->
                                        <div class="col-md-6 mb-3">
                                            <label for="choli_fabric" class="form-label">Choli Fabric</label>
                                            <input type="text" class="form-control" id="choli_fabric" name="choli_fabric"
                                                value="{{ old('choli_fabric') }}" maxlength="100">
                                            @error('choli_fabric')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Dupatta Fabric -->
                                        <div class="col-md-6 mb-3">
                                            <label for="dupatta_fabric" class="form-label">Dupatta Fabric</label>
                                            <input type="text" class="form-control" id="dupatta_fabric" name="dupatta_fabric"
                                                value="{{ old('dupatta_fabric') }}" maxlength="100">
                                            @error('dupatta_fabric')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Type -->
                                        <div class="col-md-6 mb-3">
                                            <label for="type" class="form-label">Type</label>
                                            <input type="text" class="form-control" id="type" name="type"
                                                value="{{ old('type') }}" >
                                            @error('type')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Stitching Type -->
                                        <div class="col-md-6 mb-3">
                                            <label for="stitching_type" class="form-label">Stitching Type</label>
                                            <input type="text" class="form-control" id="stitching_type" name="stitching_type"
                                                value="{{ old('stitching_type') }}" maxlength="100">
                                            @error('stitching_type')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Pattern -->
                                        <div class="col-md-6 mb-3">
                                            <label for="pattern" class="form-label">Pattern</label>
                                            <input type="text" class="form-control" id="pattern" name="pattern"
                                                value="{{ old('pattern') }}" maxlength="100">
                                            @error('pattern')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Color -->
                                        <div class="col-md-6 mb-3">
                                            <label for="color" class="form-label">Color</label>
                                            <input type="text" class="form-control" id="color" name="color"
                                                value="{{ old('color') }}" maxlength="100">
                                            @error('color')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Sales Package -->
                                        <div class="col-md-12 mb-3">
                                            <label for="sales_package" class="form-label">Sales Package</label>
                                            <textarea class="form-control" id="sales_package" name="sales_package" rows="2">{{ old('sales_package') }}</textarea>
                                            @error('sales_package')
                                            <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                             --}}
                            <!-- Product Parts Management -->
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Product Parts</h5>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="addProductPart()">
                                        <i class="fas fa-plus"></i> Add Part
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="product-parts-container">
                                        <!-- Parts will be added here dynamically -->
                                    </div>

                                    <!-- Template for new part -->
                                    <div id="part-template" style="display: none;">
                                        <div class="part-item border rounded p-3 mb-3" style="background: #f8f9fa;">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0">New Part</h6>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="removePart(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Part Name *</label>
                                                    <input type="text" class="form-control part-name" name="parts[][part_name]"
                                                        placeholder="e.g., Lehenga, Choli, Dupatta" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Fabric</label>
                                                    <input type="text" class="form-control" name="parts[][fabric]"
                                                        placeholder="e.g., Art Silk, Cotton, Net">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Work Type</label>
                                                    <input type="text" class="form-control" name="parts[][work_type]"
                                                        placeholder="e.g., Zari Work, Mirror Work, Thread Work">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- JavaScript for dynamic specifications and product parts -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const categorySelect = document.getElementById('category_id');
                                    const lehengaSpecs = ['lehenga_fabric', 'choli_fabric', 'dupatta_fabric'];
                                    const sareeSpecs = ['fabric'];
                                    const gownSpecs = ['fabric', 'stitching_type'];
                                    const commonSpecs = ['type', 'pattern', 'color', 'sales_package'];

                                    function toggleSpecifications() {
                                        const category = categorySelect.options[categorySelect.selectedIndex]?.text.toLowerCase() || '';

                                        // Hide all specification fields first
                                        const allSpecFields = [
                                            ...lehengaSpecs, ...sareeSpecs, ...gownSpecs, ...commonSpecs
                                        ];

                                        allSpecFields.forEach(fieldId => {
                                            const field = document.getElementById(fieldId);
                                            if (field) {
                                                field.closest('.mb-3, .col-md-6, .col-md-12').style.display = 'none';
                                            }
                                        });

                                        // Show relevant fields based on category
                                        if (category.includes('lehenga')) {
                                            lehengaSpecs.forEach(fieldId => {
                                                const field = document.getElementById(fieldId);
                                                if (field) field.closest('.mb-3, .col-md-6, .col-md-12').style.display = 'block';
                                            });
                                        } else if (category.includes('saree')) {
                                            sareeSpecs.forEach(fieldId => {
                                                const field = document.getElementById(fieldId);
                                                if (field) field.closest('.mb-3, .col-md-6, .col-md-12').style.display = 'block';
                                            });
                                        } else if (category.includes('gown')) {
                                            gownSpecs.forEach(fieldId => {
                                                const field = document.getElementById(fieldId);
                                                if (field) field.closest('.mb-3, .col-md-6, .col-md-12').style.display = 'block';
                                            });
                                        }

                                        // Always show common specs
                                        commonSpecs.forEach(fieldId => {
                                            const field = document.getElementById(fieldId);
                                            if (field) field.closest('.mb-3, .col-md-6, .col-md-12').style.display = 'block';
                                        });
                                    }

                                    if (categorySelect) {
                                        categorySelect.addEventListener('change', toggleSpecifications);
                                        // Initial call
                                        toggleSpecifications();
                                    }
                                });

                                // Product Parts Management Functions
                                let partCounter = 0;

                                function addProductPart() {
                                    const container = document.getElementById('product-parts-container');
                                    const template = document.getElementById('part-template');
                                    const clone = template.cloneNode(true);

                                    // Update part number
                                    partCounter++;
                                    clone.querySelector('h6').textContent = 'Part ' + partCounter;

                                    // Update name attributes to ensure unique array indices
                                    const inputs = clone.querySelectorAll('input, textarea');
                                    inputs.forEach(input => {
                                        const name = input.getAttribute('name');
                                        if (name && name.startsWith('parts[][')) {
                                            // Replace parts[][field] with parts[index][field]
                                            input.setAttribute('name', 'parts[' + (partCounter - 1) + ']' + name.substring(7));
                                        }
                                    });

                                    // Show the cloned part
                                    clone.style.display = 'block';
                                    clone.id = '';
                                    container.appendChild(clone);

                                    // Update order numbers
                                    updatePartOrders();
                                }

                                function removePart(button) {
                                    const partItem = button.closest('.part-item');
                                    partItem.remove();
                                    updatePartOrders();
                                }

                                function updatePartOrders() {
                                    const parts = document.querySelectorAll('#product-parts-container .part-item');
                                    parts.forEach((part, index) => {
                                        const orderInput = part.querySelector('.part-order');
                                        if (orderInput) {
                                            orderInput.value = index + 1;
                                        }

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
                                                // Extract field name from parts[oldIndex][fieldName]
                                                const fieldName = name.match(/parts\[\d+\]\[(.+)\]/)[1];
                                                // Update to new index
                                                input.setAttribute('name', 'parts[' + index + '][' + fieldName + ']');
                                            }
                                        });
                                    });
                                }

                                // Auto-add default parts based on category
                                function addDefaultParts(category) {
                                    const container = document.getElementById('product-parts-container');

                                    // Clear existing parts
                                    container.innerHTML = '';
                                    partCounter = 0;

                                    if (category.toLowerCase().includes('lehenga')) {
                                        // Add Lehenga
                                        addProductPart();
                                        const lehengaPart = container.lastElementChild;
                                        lehengaPart.querySelector('.part-name').value = 'Lehenga';

                                        // Add Choli
                                        addProductPart();
                                        const choliPart = container.lastElementChild;
                                        choliPart.querySelector('.part-name').value = 'Choli';

                                        // Add Dupatta
                                        addProductPart();
                                        const dupattaPart = container.lastElementChild;
                                        dupattaPart.querySelector('.part-name').value = 'Dupatta';
                                    } else if (category.toLowerCase().includes('saree')) {
                                        // Add Saree
                                        addProductPart();
                                        const sareePart = container.lastElementChild;
                                        sareePart.querySelector('.part-name').value = 'Saree';

                                        // Add Blouse Piece
                                        addProductPart();
                                        const blousePart = container.lastElementChild;
                                        blousePart.querySelector('.part-name').value = 'Blouse Piece';
                                    } else if (category.toLowerCase().includes('gown')) {
                                        // Add Gown
                                        addProductPart();
                                        const gownPart = container.lastElementChild;
                                        gownPart.querySelector('.part-name').value = 'Gown';
                                    }
                                }

                                // Add event listener to category select to auto-add default parts
                                document.addEventListener('DOMContentLoaded', function() {
                                    const categorySelect = document.getElementById('category_id');
                                    if (categorySelect) {
                                        categorySelect.addEventListener('change', function() {
                                            const category = this.options[this.selectedIndex]?.text || '';
                                            if (category && document.getElementById('product-parts-container').children.length === 0) {
                                                addDefaultParts(category);
                                            }
                                        });
                                    }
                                });
                            </script>

                            <!-- Fit -->
                            <div class="mb-3">
                                <label for="fit" class="form-label">Fit</label>
                                <select class="form-control" id="fit" name="fit">
                                    <option value="">Select Fit</option>
                                    <option value="Slim" {{ old('fit') == 'Slim' ? 'selected' : '' }}>Slim</option>
                                    <option value="Regular" {{ old('fit') == 'Regular' ? 'selected' : '' }}>Regular</option>
                                    <option value="A-line" {{ old('fit') == 'A-line' ? 'selected' : '' }}>A-line</option>
                                </select>
                                @error('fit')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <hr class="flex-grow-1 hr-line">
                                <span class="px-2 text-muted fw-bold">SEO</span>
                                <hr class="flex-grow-1 hr-line">
                            </div>

                            <div class="mb-3">
                                <label for="fabric" class="form-label">Meta Title<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                    value="{{ old('meta_title') }}">
                                @error('meta_title')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keywords" class="form-label">Keywords<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="keywords" name="keywords"
                                    value="{{ old('keywords') }}" required>
                                @error('keywords')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="tags" name="tags"
                                    value="{{ old('tags') }}" required>
                                @error('tags')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Meta Description -->

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description<sup class="text-danger">*</sup></label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="4" required>{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="schema_markup" class="form-label">Schema Markup</label>
                                <textarea class="form-control" id="schema_markup" name="schema_markup" rows="4">{{ old('schema_markup') }}</textarea>
                                @error('schema_markup')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">
                            <!-- Category -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Occasion -->
                            {{--
                            <div class="mb-3">
                                <label for="occasion_id" class="form-label">Occasion</label>
                                <select class="form-control" id="occasion_id" name="occasion_id">
                                    <option value="">Select Occasion</option>
                                    @foreach($occasions as $occasion)
                                    <option value="{{ $occasion->id }}" {{ old('occasion_id') == $occasion->id ? 'selected' : '' }}>
                            {{ $occasion->name }}
                            </option>
                            @endforeach
                            </select>
                            @error('occasion_id')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        --}}
                        

                        <div class="mb-3">
                            <label class="form-label">Occasion</label>

                            <div class="row">
                                @foreach($occasions as $occasion)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="occasion_id[]"
                                            value="{{ $occasion->id }}"
                                            id="occasion_{{ $occasion->id }}"
                                            {{ in_array($occasion->id, old('occasion_id', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="occasion_{{ $occasion->id }}">
                                            {{ $occasion->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            @error('occasion_id')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price"
                                value="{{ old('price') }}" step="0.01" min="0" required>
                            @error('price')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Discount Price -->
                        <div class="mb-3">
                            <label for="discount_price" class="form-label">Discount Price</label>
                            <input type="number" class="form-control" id="discount_price" name="discount_price"
                                value="{{ old('discount_price') }}" step="0.01" min="0">
                            @error('discount_price')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock" name="stock"
                                value="0" min="0" required readonly>
                            @error('stock')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Is Featured -->
                        <div class="mb-3">
                            <label for="is_featured" class="form-label">Is Featured</label>
                            <select class="form-control" id="is_featured" name="is_featured">
                                <option value="0" {{ old('is_featured') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('is_featured') == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                            @error('is_featured')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image<sup class="text-danger">*</sup></label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            @error('image')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Description -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>


            </div>



            <!-- Submit Buttons -->
            <div class="row">
                <div class="col-12 text-end">
                    <a href="{{ route('admin.products') }}" class="btn btn-danger">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Product
                    </button>

                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const designNo = document.getElementById('design_no');
            const name = document.getElementById('name');
            const categoryId = document.getElementById('category_id');
            const price = document.getElementById('price');
            const stock = document.getElementById('stock');
            const status = document.getElementById('status');

            let isValid = true;

            // Reset validation states
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

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
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        let manuallyEdited = false;

        // If user edits slug manually → stop auto update
        slugInput.addEventListener('input', function() {
            manuallyEdited = true;
        });

        nameInput.addEventListener('input', function() {

            if (manuallyEdited) return;

            let slug = this.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '') // remove special chars
                .replace(/\s+/g, '-') // spaces to dash
                .replace(/-+/g, '-'); // remove duplicate dash

            slugInput.value = slug;
        });

    });
</script>
@endsection