@extends('Admin.layouts.master')
@section('source', 'Coupon')
@section('page-title', 'Coupon')

@section('title')
    {{ config('app.name') }} - Edit Coupon
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
                    <h6>Edit Coupon</h6>
                </div>
                <div class="card px-5 pt-2 pb-3">
                    <form action="{{ route('offer.update', $offer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Offer Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $offer->name) }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Offer (%) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('discount') is-invalid @enderror"
                                        name="discount" value="{{ old('discount', $offer->discount) }}">
                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" id="start_date" name="start_date" class="form-control"
                                        value="{{ old('start_date', \Carbon\Carbon::parse($offer->start_date)->format('Y-m-d\TH:i')) }}">
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Duration (Days) <span class="text-danger">*</span></label>
                                    <input type="number" id="duration" name="duration" class="form-control"
                                        value="{{ old('duration', $offer->duration) }}">
                                    @error('duration')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" id="end_date" name="end_date" class="form-control"
                                        value="{{ old('end_date', \Carbon\Carbon::parse($offer->end_date)->format('Y-m-d\TH:i')) }}"
                                        readonly>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Offer Apply <span class="text-danger">*</span></label>
                                    <select class="form-control @error('apply_on') is-invalid @enderror" id="code_type"
                                        name="apply_on">
                                        <option value="">Select Offer Apply</option>
                                        <option value="all-products"
                                            {{ old('apply_on', $offer->apply_on) == 'all-products' ? 'selected' : '' }}>
                                            All Products
                                        </option>
                                        <option value="selected-product"
                                            {{ old('apply_on', $offer->apply_on) == 'selected-product' ? 'selected' : '' }}>
                                            Selected Product
                                        </option>
                                    </select>
                                    @error('apply_on')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3" id="variantSection"
                                    style="{{ old('apply_on', $offer->apply_on) == 'selected-product' ? 'display:block;' : 'display:none;' }}">

                                    <label class="form-label">
                                        Product Variants <span class="text-danger">*</span>
                                    </label>

                                    <select id="selected_product_variants" class="form-control select2"
                                        name="selected_product_variants[]" multiple>

                                        @php
                                            $selectedVariantIds = $offer->offerProducts
                                                ->pluck('product_variant_id')
                                                ->toArray();
                                        @endphp

                                        @foreach ($productVariants as $productVariant)
                                            <option value="{{ $productVariant->id }}"
                                                data-product="{{ $productVariant->product_id }}"
                                                {{ in_array($productVariant->id, $selectedVariantIds) ? 'selected' : '' }}>
                                                {{ $productVariant->product->name }}
                                                - Design No: {{ $productVariant->product->design_no }}
                                                - Size: {{ $productVariant->size }}
                                                - Color: {{ $productVariant->color }}
                                            </option>
                                        @endforeach

                                    </select>

                                    <!-- Hidden inputs generated here -->
                                    <div id="hiddenProducts"></div>

                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_timer" name="is_timer"
                                            value="1" {{ old('is_timer', $offer->is_timer) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            Show Countdown Timer
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Status <span class="text-danger">*</span>
                                    </label>

                                    <select class="form-control @error('is_active') is-invalid @enderror" name="is_active">
                                        <option value="1"
                                            {{ old('is_active', $offer->is_active) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $offer->is_active) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('is_active')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <a href="{{ route('offer.index') }}" class="btn btn-danger">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Update Offer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Scripts Section -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

        // Trigger change event to populate hidden fields on load
        setTimeout(function() {
            $('#selected_product_variants').trigger('change');
        }, 100);
    });

    // Calculate end date function
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const startDate = document.getElementById("start_date");
        const duration = document.getElementById("duration");
        const endDate = document.getElementById("end_date");

        function calculateEndDate() {

            if (startDate.value === "" || duration.value === "") {
                endDate.value = "";
                return;
            }

            let start = new Date(startDate.value);

            if (isNaN(start.getTime())) {
                endDate.value = "";
                return;
            }

            let days = parseInt(duration.value);

            start.setDate(start.getDate() + days);

            let yyyy = start.getFullYear();
            let mm = String(start.getMonth() + 1).padStart(2, '0');
            let dd = String(start.getDate()).padStart(2, '0');
            let hh = String(start.getHours()).padStart(2, '0');
            let mi = String(start.getMinutes()).padStart(2, '0');

            endDate.value = `${yyyy}-${mm}-${dd}T${hh}:${mi}`;
        }

        // Instant update while typing
        startDate.addEventListener("input", calculateEndDate);
        startDate.addEventListener("change", calculateEndDate);

        duration.addEventListener("input", calculateEndDate);
        duration.addEventListener("keyup", calculateEndDate);
        duration.addEventListener("change", calculateEndDate);

    });
</script>
