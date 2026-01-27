@extends('Admin.layouts.master')
@section('source', 'Product Variant')
@section('page-title', 'Edit Product Variant')

@section('title')
{{ config('app.name') }} - Edit Product Variant
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Edit Product Variant</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if ($errors->has('unique_combination'))
                <div class="alert alert-danger">
                    {{ $errors->first('unique_combination') }}
                </div>
                @endif
                <form action="{{ route('admin.product-variants.update', $productVariant->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $productVariant->product_id == $product->id ? 'selected' : '' }}>
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
                                    value="{{ old('sku', $productVariant->sku) }}" maxlength="100" required>
                                @error('sku')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price"
                                    value="{{ old('price', $productVariant->price) }}" step="0.01" min="0" required>
                                @error('price')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="color" class="form-label">Color</label>
                                <select class="form-control" id="color" name="color">
                                    <option value="">No Color</option>
                                    @foreach($colors as $color)
                                    <option value="{{ $color }}" {{ $productVariant->color == $color ? 'selected' : '' }}>
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
                                    <option value="{{ $size }}" {{ $productVariant->size == $size ? 'selected' : '' }}>
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
                                    value="{{ old('discount_price', $productVariant->discount_price) }}" step="0.01" min="0">
                                @error('discount_price')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Optional - leave empty for regular price</small>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control bg-light text-muted"
                                    value="{{ $productVariant->stock }}"
                                    readonly
                                    disabled>


                                @error('stock')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-warning">
                                    <i class="fas fa-info-circle"></i>
                                    Stock cannot be modified here. Please use Stock Management to adjust inventory.
                                </small>
                            </div> -->
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Variant
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const productId = document.getElementById('product_id');
            const sku = document.getElementById('sku');
            const price = document.getElementById('price');
            // const stock = document.getElementById('stock');

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

            // if (!stock.value || stock.value < 0) {
            //     stock.classList.add('is-invalid');
            //     isValid = false;
            // }

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly.');
            }
        });
    });
</script>
@endsection