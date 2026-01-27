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
            <div class="card-header pb-0">
                <h6>Add New Product</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
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

                            <!-- Brand -->
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <input type="text" class="form-control" id="brand" name="brand" 
                                       value="{{ old('brand') }}" maxlength="100">
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
                                       value="{{ old('stock') }}" min="0" required>
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

                            <!-- Image -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                @error('image')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Product
                            </button>
                            <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
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
@endsection
