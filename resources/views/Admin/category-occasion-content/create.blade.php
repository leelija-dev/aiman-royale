@extends('Admin.layouts.master')

@section('source', 'Category Occasion Content')
@section('page-title', 'Add Category Occasion Content')
@section('title', 'Add Category Occasion Content')

@section('content')
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-12">
            <div class="card">

                <!-- Header -->
                <div class="card-header bg-primary front-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Add New Content
                    </h5>
                    <a href="{{ route('admin.category-occasion-content.index') }}" class="btn btn-light btn-sm">
                        ⬅ Back
                    </a>
                </div>

                <div class="card px-4 py-3">

                    <!-- Error Block -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.category-occasion-content.store') }}" 
                          method="POST" 
                          id="contentForm"
                          enctype="multipart/form-data">
                        @csrf

                        <!-- Category + Occasion -->
                        <div class="row mb-4">

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    Category <span class="text-danger">*</span>
                                </label>

                                <select name="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror"
                                        required>
                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    Occasion <span class="text-danger">*</span>
                                </label>

                                <select name="occasion_id"
                                        class="form-select @error('occasion_id') is-invalid @enderror"
                                        required>
                                    <option value="">Select Occasion</option>

                                    @foreach($occasions as $occasion)
                                        <option value="{{ $occasion->id }}"
                                            {{ old('occasion_id') == $occasion->id ? 'selected' : '' }}>
                                            {{ $occasion->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('occasion_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Content</label>

                            <textarea name="content"
                                      id="content"
                                      rows="10"
                                      maxlength="10000"
                                      class="form-control @error('content') is-invalid @enderror"
                                      placeholder="Enter content...">{{ old('content') }}</textarea>

                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">Max 10,000 characters</small>
                                <small id="char-count" class="text-muted">0 / 10000</small>
                            </div>

                            @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Warning -->
                        <div id="char-warning" class="alert alert-warning d-none">
                            You are close to the character limit.
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.category-occasion-content.index') }}" class="btn btn-danger">
                                Cancel
                            </a>

                            <div>
                                <button type="button" class="btn btn-outline-danger me-2" onclick="confirmReset()">
                                    Reset
                                </button>

                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    Save Content
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const textarea = document.getElementById('content');
    const counter = document.getElementById('char-count');
    const warning = document.getElementById('char-warning');
    const submitBtn = document.getElementById('submitBtn');

    const max = 10000;
    const warn = 9000;

    function updateCount() {
        let len = textarea.value.length;
        counter.textContent = `${len} / ${max}`;

        counter.classList.toggle('text-danger', len > max);
        warning.classList.toggle('d-none', len < warn);

        submitBtn.disabled = len > max;
    }

    textarea.addEventListener('input', updateCount);
    updateCount();

    document.getElementById('contentForm').addEventListener('submit', function(e) {
        if (textarea.value.length > max) {
            e.preventDefault();
            alert('Character limit exceeded!');
            textarea.focus();
        } else {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
        }
    });
});

// Reset confirmation
function confirmReset() {
    if (confirm('Reset the form?')) {
        document.getElementById('contentForm').reset();
        document.getElementById('char-count').textContent = '0 / 10000';
        document.getElementById('char-warning').classList.add('d-none');
    }
}
</script>
@endsection