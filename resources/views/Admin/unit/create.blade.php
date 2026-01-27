@extends('Admin.layouts.master')
@section('source', 'Unit')
@section('page-title', 'Add Unit')

@section('title')
{{config('app.name')}} - Add Unit
@endsection

@section('content')
<div class="container-fluid py-4">
   
    <div class="col-12">
        <div class="card mb-4">
            <div class="cards p-4">
                
                <form id="unitForm" action="{{ isset($unit) ? route('admin.unit.edit', $unit->id) : route('admin.unit.store') }}"  method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Code --}}
                            <div class="form-group mb-3">
                                <label for="code" class="text-uppercase text-secondary">Unit Code (e.g: pcs, kg, ml) <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $unit->code ?? '') }}" maxlength="16" placeholder="Unit code" required>
                                <div class="invalid-feedback">Unit code can not be blank!</div>
                                @error('code')
                                <span class="invalid-feedback d-block">{{$message}}</span>
                                @enderror
                            </div>

                            {{-- Name --}}
                            <div class="form-group mb-3">
                                <label for="name" class="text-uppercase text-secondary">Unit Name <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$unit->name ?? '') }}" maxlength="64" placeholder="Unit name" required>
                                <div class="invalid-feedback">Unit name cannot be blank!</div>
                                @error('name')
                                <span class="invalid-feedback d-block">{{$message}}</span>
                                @enderror
                            </div>

                            {{-- Allow Decimal --}}
                            <div class="form-group form-check mt-2">
                                <input type="hidden" name="allow_decimal" value="0">
                                <input type="checkbox" class="form-check-input" id="allow_decimal" name="allow_decimal" value="1" {{ old('allow_decimal', $unit->allow_decimal ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label text-uppercase text-secondary" for="allow_decimal">Allow Decimal</label>
                                @error('allow_decimal')
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