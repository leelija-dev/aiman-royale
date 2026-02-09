@extends('Admin.layouts.master')
@section('source', 'Categories')
@section('page-title', ' Add Category')

@section('title')
    {{ config('app.name') }} - Add Category
@endsection

{{-- @section('title', 'Create Product Category') --}}

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body overflow-visible mh-100 py-3">
                <form id="categoriePost" action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label text-secondary text-uppercase">Name <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>
                                <div class="invalid-feedback">Category name cannot be blank!</div>
                                @error('name')
                                    <div>
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary text-uppercase">Slug <sup
                                        class="text-danger">*</sup></label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}"
                                    required>
                                <div class="invalid-feedback">Slug cannot be blank!</div>
                                @error('slug')
                                    <div>
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                              <label class="form-label text-secondary text-uppercase">Image<sup class="text-danger">*</sup></label>
                              <input type="file" name="image" id="imageInput" class="form-control" max-size="1024" accept=".jpg,.jpeg,.png, .webp, .svg" value="{{ old('image') }}" required>
                                {{-- <small id="imageError" class="text-danger d-none"></small> --}}
                              @error('image')
                            <div>
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            </div>
                            @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary text-uppercase">Parent Category</label>
                                <select name="parent_id" class="form-control">
                                    <option value="">None (Root Category)</option>
                                    @if (isset($categories) && $categories->count() > 0)
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary text-uppercase">Description</label>
                                <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary text-uppercase">Status</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                        value="1"
                                        {{ old('is_active', 1) == 1 || old('is_active', 1) === true ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                                @error('is_active')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary text-uppercase">Show Home Page</label>

                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_home" value="0">

                                    <input class="form-check-input"
                                        type="checkbox"
                                        name="is_home"
                                        id="is_home"
                                        value="1"
                                        >

                                    <label class="form-check-label" for="is_home">Yes</label>
                                </div>

                                @error('is_home')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Dropdown (Hidden by default) -->
                            <div class="mb-3" id="homeDropdownWrapper" style="display: none;">
                                <label class="form-label text-secondary text-uppercase">Select Position</label>
                                <select name="home_position" class="form-select">
                                    <option value="" selected hidden>Select Position</option>
                                    <option value="top" >Top</option>
                                    <option value="bottom" >Bottom</option>
                                    <option value="left" >Left</option>
                                    <option value="right" >Right</option>

                                </select>
                                @error('home_position')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 text-end">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Cancel</a>
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        (function() {
            'use strict'
            const form = document.getElementById('categoriePost');
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>
    {{-- <script>
document.getElementById('imageInput').addEventListener('change', function () {

    const file = this.files[0];
    const errorBox = document.getElementById('imageError');

    if (!file) return;

    const maxSize = 1 * 1024 * 1024; // 1 MB

    if (file.size > maxSize) {

        errorBox.innerText = "Image size must be less than 1 MB";
        this.value = ""; // Remove selected file immediately

    } else {

        errorBox.innerText = "";

    }
});
</script> --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('is_home');
    const dropdown = document.getElementById('homeDropdownWrapper');

    function toggleDropdown() {
        dropdown.style.display = checkbox.checked ? 'block' : 'none';
    }

    // Initial state (important for edit page)
    toggleDropdown();

    // On change
    checkbox.addEventListener('change', toggleDropdown);
});
</script>

@endsection
