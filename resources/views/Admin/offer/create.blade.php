@extends('Admin.layouts.master')
@section('source', 'Coupon')
@section('page-title', 'Coupon')

@section('title')
    {{ config('app.name') }} - Coupon
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
                    <h6>Add New Coupon</h6>
                </div>
                <div class="card px-5 pt-2 pb-3">
                    <form action="{{ route('offer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <!-- Left Column -->
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Offer Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Offer (%) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="discount"
                                        value="{{ old('discount') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                        value="{{ old('start_date') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Duration (Days) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="duration" name="duration"
                                        value="{{ old('duration') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                                        readonly>
                                </div>

                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Offer Apply <span class="text-danger">*</span></label>

                                    <select class="form-control" id="code_type" name="apply_on">
                                        <option value="">Select Offer Apply</option>
                                        <option value="all-products">All Products</option>
                                        <option value="selected-product">Selected Product</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="variantSection" style="display:none;">
                                    <label class="form-label">
                                        Product Variants <span class="text-danger">*</span>
                                    </label>

                                    <select id="selected_product_variants" class="form-control select2"
                                        name="selected_product_variants[]" multiple>

                                        @foreach ($productVariants as $productVariant)
                                            <option
                                                value="{{ $productVariant->id }}"
                                                data-product="{{ $productVariant->product_id }}">
                                                {{ $productVariant->product->name }} , Design No: {{$productVariant->product->design_no}}
                                                , Size: {{ $productVariant->size }}
                                                , Color: {{ $productVariant->color }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_timer" name="is_timer"
                                            value="1">

                                        <label class="form-check-label">
                                            Show Countdown Timer
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Status <span class="text-danger">*</span>
                                    </label>

                                    <select class="form-control" name="is_active">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="text-end mt-3">
                            <a href="{{ route('offer.index') }}" class="btn btn-danger">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Save Offer
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const codeType = document.getElementById("code_type");
            const minimumAmountDiv = document.getElementById("minimumAmountDiv");

            function toggleMinimumAmount() {
                if (codeType.value === "special-discount") {
                    minimumAmountDiv.style.display = "block";
                } else {
                    minimumAmountDiv.style.display = "none";
                }
            }

            // Run on page load
            toggleMinimumAmount();

            // Run when dropdown changes
            codeType.addEventListener("change", toggleMinimumAmount);
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>s"></script>

    <script>
        $(document).ready(function() {

            // Initialize Select2
            $('#selected_product_variants').select2({
                placeholder: "Search & Select Product Variants",
                width: '100%',
                allowClear: true
            });

            // Show/Hide Product Variant dropdown
            function toggleVariantDropdown() {

                if ($('#code_type').val() === 'selected-product') {

                    $('#variantSection').slideDown();

                } else {

                    $('#variantSection').slideUp();

                    $('#selected_product_variants').val(null).trigger('change');

                    $('#hiddenProducts').html('');
                }
            }

            toggleVariantDropdown();

            $('#code_type').change(toggleVariantDropdown);

            // Store Product ID & Variant ID
            $('#selected_product_variants').on('change', function() {

                $('#hiddenProducts').html('');

                $('#selected_product_variants option:selected').each(function() {

                    let productId = $(this).data('product');
                    let variantId = $(this).val();

                    $('#hiddenProducts').append(`
                <input type="hidden" name="product_id[]" value="${productId}">
                <input type="hidden" name="product_variant_id[]" value="${variantId}">
            `);

                });

            });

        });
    </script>
    <script>
        function calculateEndDate() {

            let start = document.getElementById('start_date').value;
            let duration = parseInt(document.getElementById('duration').value);

            if (!start || isNaN(duration)) {
                document.getElementById('end_date').value = '';
                return;
            }

            let date = new Date(start);

            // Add duration in days while keeping the same time
            date.setDate(date.getDate() + duration);

            // Format YYYY-MM-DDTHH:MM
            let year = date.getFullYear();
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let day = String(date.getDate()).padStart(2, '0');
            let hour = String(date.getHours()).padStart(2, '0');
            let minute = String(date.getMinutes()).padStart(2, '0');

            document.getElementById('end_date').value =
                `${year}-${month}-${day}T${hour}:${minute}`;
        }

        document.getElementById('start_date').addEventListener('change', calculateEndDate);
        document.getElementById('duration').addEventListener('input', calculateEndDate);

        calculateEndDate();
    </script>
@endsection
