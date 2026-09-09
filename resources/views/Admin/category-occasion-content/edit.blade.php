@extends('Admin.layouts.master')

@section('source', 'Category Occasion Content')
@section('page-title', 'Edit Category Occasion Content')
@section('title', 'Edit Category Occasion Content')
@section('title', 'Edit Category Occasion Content')

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header px-5 pb-0">
                <h6>Edit Category Occasion Content</h6>
            </div>

            <div class="card px-5 pt-3 pb-4">
                <form action="{{ route('admin.category-occasion-content.update', $categoryOccasionContent->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Category -->
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>

                            <select name="category_id" id="category_id" 
                                    class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $categoryOccasionContent->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Occasion -->
                        <div class="col-md-6 mb-3">
                            <label for="occasion_id" class="form-label">
                                Occasion <span class="text-danger">*</span>
                            </label>

                            <select name="occasion_id" id="occasion_id" 
                                    class="form-select @error('occasion_id') is-invalid @enderror" required>
                                <option value="">Select Occasion</option>

                                @foreach($occasions as $occasion)
                                    <option value="{{ $occasion->id }}"
                                        {{ old('occasion_id', $categoryOccasionContent->occasion_id) == $occasion->id ? 'selected' : '' }}>
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
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>

                        <textarea name="content" id="content" rows="8"
                                  class="form-control @error('content') is-invalid @enderror"
                                  placeholder="Enter content for this category-occasion combination..."
                                  maxlength="10000">{{ old('content', $categoryOccasionContent->content) }}</textarea>

                        <small class="text-muted">Max 10,000 characters. HTML allowed.</small>

                        @error('content')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Character Counter -->
                    <div class="mb-3 d-flex justify-content-between">
                        <small class="text-muted">Limit: 10,000 characters</small>
                        <small id="char-count" class="text-muted">0 / 10000</small>
                    </div>

                    <!-- Info Box -->
                    <div class="alert alert-light alert-info">
                        <h6 class="mb-2">
                            <i class="fas fa-info-circle me-2"></i>Current Information
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Category:</strong> {{ $categoryOccasionContent->category->name ?? 'N/A' }} <br>
                                <strong>Occasion:</strong> {{ $categoryOccasionContent->occasion->name ?? 'N/A' }}
                            </div>

                            <div class="col-md-6">
                                <strong>Created:</strong> {{ optional($categoryOccasionContent->created_at)->format('M d, Y h:i A') }} <br>
                                <strong>Updated:</strong> {{ optional($categoryOccasionContent->updated_at)->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.category-occasion-content.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>

                        <div>
                            <button type="reset" class="btn btn-outline-danger me-2">
                                Reset
                            </button>

                            <button type="submit" class="btn btn-primary">
                                Update Content
                            </button>
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
document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('content');
    const counter = document.getElementById('char-count');
    const max = 10000;

    function updateCount() {
        let len = textarea.value.length;
        counter.textContent = `${len} / ${max}`;

        counter.classList.toggle('text-danger', len > max);
    }

    textarea.addEventListener('input', updateCount);
    updateCount();

    document.querySelector('form').addEventListener('submit', function (e) {
        if (textarea.value.length > max) {
            e.preventDefault();
            alert('Maximum 10,000 characters allowed.');
            textarea.focus();
        }
    });
});
</script>
@endsection