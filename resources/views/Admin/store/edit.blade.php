@extends('Admin.layouts.master')
@section('source', 'Store')
@section('page-title', 'Store')

@section('title')
    {{ config('app.name') }} - Store
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
                    <h6>Edit Store</h6>
                </div>
                <div class="card px-5 pt-2 pb-3">
                    <form action="{{ route('store.update',$store->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $store->name }}" required>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- phone number  -->
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number  </label>
                                    <input type="number" class="form-control" id="phone_number" name="phone_number"
                                        value="{{ $store->phone_number }}"  required>
                                    @error('phone_number')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="email"
                                        name="email" value="{{ $store->email }}" >
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>




                                <!-- Address-->
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $store->address }}">
                                    
                                    @error('address')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">

                                 <div class="mb-3">
                                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="state"
                                        name="state" value="{{ $store->state }}" >
                                    @error('state')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="country"
                                        name="country" value="{{ $store->country }}" >
                                    @error('country')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="gst_number" class="form-label">GST Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="gst_number"
                                        name="gst_number" value="{{ $store->gst_number }}" >
                                    @error('gst_number')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="gst_percentage" class="form-label">GST Percentage (for products selling ) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="gst_percentage"
                                        name="gst_percentage" value="{{ $store->gst_percentage }}" >
                                    @error('gst_percentage')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="is_active" name="is_active" required>
                                        <option value="1"
                                            {{ old('is_active', $store->status ?? '1') == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $store->status ?? '1') == '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('is_active')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12 text-end">
                                <a href="{{ route('store.index') }}" class="btn btn-danger">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Store
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
