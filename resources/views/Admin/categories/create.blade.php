@extends('Admin.layouts.master')
@section('source', 'Categories')
@section('page-title', ' Add Category')

@section('title')
    {{ config('app.name') }} - Add Category
@endsection

{{-- @section('title', 'Create Product Category') --}}
<style>
.hr-line {
    border-top: 2px solid #0408382d !important;
    opacity: 1 !important;
}
</style>
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
                                <textarea name="description" id="description-editor" rows="4" class="form-control">{{ old('description') }}</textarea>
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
                        </div>
                        
                        <div class="col-lg-12 ">
                            <div class="row">
                            
                             <div class="mb-3 d-flex align-items-center">
                                    <hr class="flex-grow-1 hr-line">
                                    <span class="px-2 text-muted fw-bold">SEO</span>
                                    <hr class="flex-grow-1 hr-line">
                                </div>
                            <div class="col-6">
                            <div class="mb-3">
                                <label for="fabric" class="form-label">Meta Title<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                       value="{{ old('meta_title') }}" required>
                                <div class="invalid-feedback">Meta title cannot be blank!</div>
                                @error('meta_title')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="mb-3">
                                <label for="keywords" class="form-label">Keywords<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="keywords" name="keywords" 
                                       value="{{ old('keywords') }}" required>
                                       <div class="invalid-feedback">Keywords cannot be blank!</div>
                                @error('keywords')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                           
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="tags" name="tags" 
                                       value="{{ old('tags') }}" required>
                                <div class="invalid-feedback">Tags cannot be blank!</div>
                                @error('tags')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                             </div>
                            <div class="col-6">
                            <!-- Meta Description -->
                            
                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description<sup class="text-danger">*</sup></label>
                                        <textarea class="form-control" id="meta_description" name="meta_description" rows="4" required>{{ old('meta_description') }}</textarea>
                                        <div class="invalid-feedback">Meta description cannot be blank!</div>
                                        @error('meta_description')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="schema_markup" class="form-label">Schema Markup</label>
                                        <textarea class="form-control" id="schema_markup" name="schema_markup" rows="4">{{ old('schema_markup') }}</textarea>
                                        @error('schema_markup')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                            </div>
                            </div>
                            <div class="col-12 text-end">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Cancel</a>
                                <button class="btn btn-primary">Save</button>
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
    
    // Initialize Summernote for description editor
    // $('#description-editor').summernote({
    //     height: 200,
    //     toolbar: [
    //         ['style', ['bold', 'italic', 'underline', 'clear']],
    //         ['para', ['ul', 'ol', 'paragraph', 'height']],
    //         ['insert', ['link', 'picture', 'video']],
    //         ['view', ['fullscreen', 'codeview', 'help']]
    //     ],
    //     placeholder: 'Enter category description...',
    //     callbacks: {
    //         onImageUpload: function(files) {
    //             // Handle image upload if needed
    //             // For now, just return the URL
    //             // You can implement server-side upload here
    //         }
    //     }
    // });
  
    $(document).ready(function() {
        $('#description-editor').summernote({
            height: 200,
        });
    });

});
</script>

@endsection
