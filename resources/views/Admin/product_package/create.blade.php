@extends('Admin.layouts.master')
@section('source', 'Product Package ')
@section('page-title', 'Product Package Type')

@section('title')
{{config('app.name')}} - Product Package Type

@endsection

@section('content')
<div class="container-fluid py-4">
   
    <div class="col-12">
        <div class="card mb-4">
            <div class="cards p-4">
                
                <form id="unitForm" action="{{ isset($package) ? route('admin.product-package.update', $package->id) : route('admin.product-package.store') }}"  method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            {{-- product package type --}}
                            <div class="form-group mb-3">
                                <label for="package_type" class="text-uppercase text-secondary">Product Package Type<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="package_type" name="package_type" value="{{ old('package_type', $package->package_type ?? '') }}" maxlength="16" placeholder="Product package type" required>
                                <div class="invalid-feedback">Product Package type can not be blank!</div>
                                @error('package_type')
                                <span class="invalid-feedback d-block">{{$message}}</span>
                                @enderror
                            </div>

                            
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('unitForm');

    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
});
</script>

@endsection