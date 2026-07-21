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
                    <h6>Edit Coupon</h6>
                </div>
                <div class="card px-5 pt-2 pb-3">
                    <form action="{{ route('coupon.update',$coupon->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $coupon->name }}" required>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Coupon Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="code" name="code"
                                        value="{{ $coupon->code }}" required>
                                    @error('code')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- discount -->
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Discount(%)<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="discount" name="discount"
                                        value="{{ $coupon->discount }}"  required>
                                    @error('discount')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Remarks -->
                                <div class="mb-3">
                                    <label for="code_for" class="form-label">Remarks</label>
                                    <input type="text" class="form-control" id="code_for"
                                        name="code_for" value="{{ $coupon->code_for }}" >
                                    @error('code_for')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <div class="col-md-6">
                                
                                <!-- validity-->
                                <div class="mb-3">
                                    <label for="validity" class="form-label">Validity(Day)<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="validity" name="validity" value="{{ $coupon->validity }}">
                                    
                                    @error('validity')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                 <div class="mb-3">
                                    <label for="code_type" class="form-label">
                                        Coupon Type <span class="text-danger">*</span>
                                    </label>

                                    <select class="form-control" id="code_type" name="code_type" required>
                                        <option value="" hidden>Select Coupon Type</option>
                                        <option value="product-discount" {{ $coupon->code_type == 'product-discount' ? 'selected' : '' }}>
                                            Product Discount
                                        </option>
                                        <option value="influencer-discount" {{ $coupon->code_type == 'influencer-discount' ? 'selected' : '' }}>
                                            Influencer Discount
                                        </option>
                                        <option value="special-discount" {{ $coupon->code_type == 'special-discount' ? 'selected' : '' }}>
                                            Special Discount 
                                        </option>
                                    </select>

                                    @error('code_type')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="minimumAmountDiv" style="display: none;">
                                    <label for="minimum_amount" class="form-label">
                                        Minimum Amount <span class="text-danger">*</span>
                                    </label>

                                    <input type="number"
                                        class="form-control"
                                        id="minimum_amount"
                                        name="minimum_amount"
                                        min="0"
                                        value="{{ $coupon->minimum_amount }}">

                                    <small class="text-muted">
                                        Enter the minimum order amount required for this coupon to be applicable.
                                    </small>

                                    @error('minimum_amount')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                 
                                <!-- Status -->
                              <div class="mb-3">
                                <label for="is_active" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>

                                <select class="form-control" id="is_active" name="is_active" required>
                                    <option value="1" {{ $coupon->is_active == '1' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ $coupon->is_active ==0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>

                                @error('is_active')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12 text-end">
                                <a href="{{ route('coupon.index') }}" class="btn btn-danger">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Coupon
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function () {
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
@endsection
