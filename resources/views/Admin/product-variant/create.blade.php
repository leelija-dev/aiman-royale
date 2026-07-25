@extends('Admin.layouts.master')
@section('source', 'Product Variant')
@section('page-title', 'Add Product Variant')

@section('title')
    {{ config('app.name') }} - Add Product Variant
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<style>
    /* 3 images per row in Dropzone preview */
    #multiImageDropzone .dz-preview {
        width: 30%;
        margin: 1%;
        display: inline-block;
        vertical-align: top;
    }

    /* Responsive for mobile */
    @media (max-width: 768px) {
        #multiImageDropzone .dz-preview {
            width: 48%;
        }
    }

    @media (max-width: 480px) {
        #multiImageDropzone .dz-preview {
            width: 100%;
        }
    }
</style>
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
                    <form action="{{ route('admin.product-variants.store') }}" method="POST" enctype="multipart/form-data"
                        id="variantForm" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Product <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="product_id" name="product_id">
                                        <option value="" selected hidden>Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <div id="product_id-error" class="text-danger small" style="display: none;"></div>
                                </div>
                                {{-- <div class="mb-3">
                                <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="sku" name="sku" 
                                       value="{{ old('sku') }}" maxlength="100">
                                @error('sku')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <div id="sku-error" class="text-danger small" style="display: none;"></div>
                            </div> --}}
                                {{-- <div class="mb-3">
                                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="{{ old('price') }}" step="0.01" min="0">
                                @error('price')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <div id="price-error" class="text-danger small" style="display: none;"></div>
                            </div> --}}

                                <div class="mb-3">
                                    <label for="edit_price" class="form-label">Base Price <span
                                            class="text-danger">*</span></label>
                                    <input type="number" id="base_price" class="form-control" name="price"
                                        value="{{ old('price') }}">
                                    @error('price')
                                        <div class="text-danger small">{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="edit_price" class="form-label">Fixed Price / Selling Price <span
                                            class="text-danger">*</span></label>
                                    <input type="number" id="fixed_price" name="fixed_price"
                                        value="{{ old('fixed_price') }}" class="form-control">
                                    @error('fixed_price')
                                        <div class="text-danger small">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="edit_discount" class="form-label">Discount (%)</label>
                                    <input type="number" readonly id="discount" name="discount" class="form-control">
                                    @error('discount')
                                        <div class="text-danger small">{{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Price Displayed on Website (Before Coupon)</label><br>
                                    <span id="offer_price" class="fw-bold text-primary">
                                        ₹0.00
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_discount" class="form-label">Coupon</label>

                                    <select id="coupon" name="coupon_id" class="form-control">
                                        <option value="">Select Coupon</option>

                                        @foreach ($coupons as $coupon)
                                            <option value="{{ $coupon->id }}" data-discount="{{ $coupon->discount }}">
                                                {{ $coupon->name }} - {{ $coupon->code }}
                                                ({{ $coupon->discount }}%)
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('coupon_id')
                                        <div class="text-danger small">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="edit_discount" class="form-label">Final Price</label>
                                    <input type="number" readonly id="final_price" name="final_price"
                                        value="{{ old('final_price') }}" class="form-control">
                                    @error('final_price')
                                        <div class="text-danger small">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary">Upload Gallery Images</label>
                                    <div id="multiImageDropzone" class="dropzone border rounded"></div>
                                </div>



                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="color" name="color">
                                        <option value="" selected hidden>Select Color</option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}"
                                                {{ old('color') == $color->id ? 'selected' : '' }}>
                                                {{ $color->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('color')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <div id="color-error" class="text-danger small" style="display: none;"></div>

                                </div>
                                <div class="mb-3">
                                    <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
                                    <select class="form-control" id="size" name="size">
                                        <option value="" selected hidden>Select Size</option>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->code }}" {{ $size->name }}>
                                                {{ $size->name }} ({{ $size->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('size')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <div id="size-error" class="text-danger small" style="display: none;"></div>

                                </div>
                                {{-- <div class="mb-3">
                                    <label for="discount" class="form-label">Discount(%)</label>
                                    <input type="number" class="form-control" id="discount" name="discount"
                                        value="0" step="0.01" min="0">
                                    @error('discount')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Optional - leave empty for regular price</small>
                                </div> --}}
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="stock" name="stock"
                                        value="{{ old('stock') }}" min="0">
                                    @error('stock')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <div id="stock-error" class="text-danger small" style="display: none;"></div>
                                    <small class="text-muted">Number of items available for this variant</small>
                                </div>
                                <div class="mb-3">
                                    <label for="video_url" class="form-label">Video URL</label>
                                    <input type="url" class="form-control" id="video_url" name="video_url"
                                        value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                                    @error('video_url')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Optional - Add a video URL for this variant (YouTube, Vimeo,
                                        etc.)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12 text-end">
                                <a href="{{ route('admin.product-variants') }}" class="btn btn-danger me-3">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Variant
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">

@endsection

@section('scripts')

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
                const color = document.getElementById('color');
                const size = document.getElementById('size');

                // Debug: Check if elements are found
                console.log('Elements found:', {
                    productId: !!productId,
                    sku: !!sku,
                    price: !!price,
                    stock: !!stock,
                    color: !!color,
                    size: !!size
                });

                // Error elements
                const productIdError = document.getElementById('product_id-error');
                const skuError = document.getElementById('sku-error');
                const priceError = document.getElementById('price-error');
                const stockError = document.getElementById('stock-error');
                const colorError = document.getElementById('color-error');
                const sizeError = document.getElementById('size-error');

                // Debug: Check if error elements are found
                console.log('Error elements found:', {
                    productIdError: !!productIdError,
                    skuError: !!skuError,
                    priceError: !!priceError,
                    stockError: !!stockError,
                    colorError: !!colorError,
                    sizeError: !!sizeError
                });

                let isValid = true;

                // Hide all custom errors
                document.querySelectorAll('[id$="-error"]').forEach(el => el.style.display = 'none');

                // Remove invalid classes
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                // Validate required fields with custom messages
                if (!productId.value) {
                    productId.classList.add('is-invalid');
                    productIdError.textContent = 'Please select a product.';
                    productIdError.style.display = 'block';
                    isValid = false;
                }

                if (!sku.value.trim()) {
                    sku.classList.add('is-invalid');
                    skuError.textContent = 'SKU is required.';
                    skuError.style.display = 'block';
                    isValid = false;
                }

                if (!price.value || price.value < 0) {
                    price.classList.add('is-invalid');
                    priceError.textContent = 'Please enter a valid price (minimum 0).';
                    priceError.style.display = 'block';
                    isValid = false;
                }

                if (!stock.value || stock.value < 0) {
                    stock.classList.add('is-invalid');
                    stockError.textContent = 'Please enter a valid stock quantity (minimum 0).';
                    stockError.style.display = 'block';
                    isValid = false;
                }

                // Validate color (optional but show error if empty)
                console.log('Color value:', color.value);
                console.log('Color element:', color);
                if (!color.value || color.value === '') {
                    color.classList.add('is-invalid');
                    colorError.textContent = 'Please select a color.';
                    colorError.style.display = 'block';
                    isValid = false;
                }

                // Validate size (optional but show error if empty)
                console.log('Size value:', size.value);
                console.log('Size element:', size);
                if (!size.value || size.value === '') {
                    size.classList.add('is-invalid');
                    sizeError.textContent = 'Please select a size.';
                    sizeError.style.display = 'block';
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    // Focus on first invalid field
                    const firstInvalid = document.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.focus();
                    }
                }
            });

            // Real-time error clearing
            const fields = ['product_id', 'sku', 'price', 'stock', 'color', 'size'];
            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                const errorDiv = document.getElementById(fieldId + '-error');

                if (field && errorDiv) {
                    field.addEventListener('input', function() {
                        if (this.value.trim() || (this.type === 'select-one' && this.value)) {
                            this.classList.remove('is-invalid');
                            errorDiv.style.display = 'none';
                        }
                    });

                    // Handle select change events
                    if (field.tagName === 'SELECT') {
                        field.addEventListener('change', function() {
                            if (this.value) {
                                this.classList.remove('is-invalid');
                                errorDiv.style.display = 'none';
                            }
                        });
                    }
                }
            });
        });
    </script>
    <script>
        Dropzone.autoDiscover = false;

        new Dropzone("#multiImageDropzone", {
            url: "#", // Not used
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 10,
            maxFiles: 10,
            paramName: "images[]",
            acceptedFiles: ".jpg,.jpeg,.png,.webp,.avif",
            addRemoveLinks: true,

            init: function() {
                let myDropzone = this;

                document.getElementById("variantForm").addEventListener("submit", function() {

                    // Append images into form manually
                    myDropzone.files.forEach(function(file) {

                        let hiddenInput = document.createElement('input');
                        hiddenInput.type = 'file';
                        hiddenInput.name = 'images[]';
                        hiddenInput.files = createFileList(file);

                        document.getElementById("variantForm").appendChild(hiddenInput);

                    });
                });
            }
        });

        // Helper function
        function createFileList(file) {
            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            return dataTransfer.files;
        }
    </script>

    <script>
        function customRound(value) {
    const decimal = value % 1;

    if (decimal >= 0.5) {
        return Math.ceil(value);
    }

    return value.toFixed(1);
}
        function calculatePrice() {

            let basePrice = parseFloat(document.getElementById('base_price').value) || 0;
            let fixedPrice = parseFloat(document.getElementById('fixed_price').value) || 0;

            let coupon = document.getElementById('coupon');
            let couponPercentage = 0;

            if (coupon.selectedIndex > 0) {
                couponPercentage = parseFloat(
                    coupon.options[coupon.selectedIndex].dataset.discount
                ) || 0;
            }

            if (basePrice <= 0 || fixedPrice <= 0) {
                document.getElementById('discount').value = "";
                document.getElementById('offer_price').innerHTML = "₹0.00";
                document.getElementById('final_price').value = "";
                return;
            }

            // Website selling price before coupon
            let offerPrice = fixedPrice;

            if (couponPercentage > 0) {
                offerPrice = fixedPrice / (1 - (couponPercentage / 100));
            }
            offerPrice = Math.round(offerPrice);
            // Product discount %
            let discount = ((basePrice - offerPrice) / basePrice) * 100;
            discount = Math.max(0, discount);

            // document.getElementById('discount').value = Math.round(discount);
            document.getElementById('discount').value = customRound(discount);

            document.getElementById('offer_price').innerHTML =
                "₹" + offerPrice.toFixed(2);

            document.getElementById('final_price').value =
                fixedPrice.toFixed(2);
        }

        document.getElementById('base_price').addEventListener('input', calculatePrice);
        document.getElementById('fixed_price').addEventListener('input', calculatePrice);
        document.getElementById('coupon').addEventListener('change', calculatePrice);

        calculatePrice();
    </script>
@endsection
