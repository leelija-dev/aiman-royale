@extends('Admin.layouts.master')
@section('source', 'Product Variant')
@section('page-title', 'Add Product Variant')

@section('title')
{{ config('app.name') }} - Add Product Variant
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Add New Product Variant</h6>
            </div>
            <div class="card px-3 pt-3 pb-2">
                @if ($errors->has('unique_combination'))
                    <div class="alert alert-danger">
                        {{ $errors->first('unique_combination') }}
                    </div>
                @endif
                <form action="{{ route('admin.product-variants.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sku" name="sku" 
                                       value="{{ old('sku') }}" maxlength="100" required>
                                @error('sku')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="{{ old('price') }}" step="0.01" min="0" required>
                                @error('price')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                    <div class="form-group">
                                        <label class="text-uppercase text-secondary">Upload Gallery Images</label>
                                        <div id="multiImageDropzone" class="dropzone"></div>
                                        @error('images')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                            
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="color" class="form-label">Color</label>
                                <select class="form-control" id="color" name="color">
                                    <option value="">No Color</option>
                                    @foreach($colors as $color)
                                    <option value="{{ $color }}" {{ old('color') == $color ? 'selected' : '' }}>
                                        {{ $color }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('color')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Select a color for this variant</small>
                            </div>
                            <div class="mb-3">
                                <label for="size" class="form-label">Size</label>
                                <select class="form-control" id="size" name="size">
                                    <option value="">No Size</option>
                                    @foreach($sizes as $size)
                                    <option value="{{ $size }}" {{ old('size') == $size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('size')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Select a size for this variant</small>
                            </div>
                            <div class="mb-3">
                                <label for="discount_price" class="form-label">Discount Price</label>
                                <input type="number" class="form-control" id="discount_price" name="discount_price" 
                                       value="{{ old('discount_price') }}" step="0.01" min="0">
                                @error('discount_price')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Optional - leave empty for regular price</small>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="stock" name="stock" 
                                       value="{{ old('stock') }}" min="0" required>
                                @error('stock')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Number of items available for this variant</small>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Variant
                            </button>
                            <a href="{{ route('admin.product-variants') }}" class="btn btn-secondary">
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

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
            });
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const productId = document.getElementById('product_id');
        const sku = document.getElementById('sku');
        const price = document.getElementById('price');
        const stock = document.getElementById('stock');

        let isValid = true;

        // Reset validation states
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

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
</script>
@endsection
