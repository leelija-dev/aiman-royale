@extends('Admin.layouts.master')
@section('source', 'Color')
@section('page-title', 'Add Color')

@section('title')
{{ config('app.name') }} - Add Color
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Add New Color</h6>
            </div>
            <div class="card px-4 pt-2 pb-2">
                <form action="{{ route('admin.colors.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Color Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name') }}" maxlength="50">
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <div id="name-error" class="text-danger small" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="code" class="form-label">Color Code <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="text" class="form-control" id="code" name="code" 
                                           value="{{ old('code') }}" maxlength="7">
                                    <div id="colorPreview" style="width: 32px; height: 32px; background-color: #000000; border: 1px solid #ddd; border-radius: 4px;"></div>
                                </div>
                                @error('code')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <div id="code-error" class="text-danger small" style="display: none;"></div>
                                <small class="text-muted">Enter hex color code (e.g., #FF5733)</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="color_tone" class="form-label">Color Tone</label>
                                <input type="text" class="form-control" id="color_tone" name="color_tone" 
                                       value="{{ old('color_tone') }}" maxlength="50">
                                @error('color_tone')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Enter color tone (e.g., Light, Dark, Pastel)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12 text-end">
                            <a href="{{ route('admin.colors.index') }}" class="btn btn-danger me-3" >
                                <i class="fas fa-times me-3"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Color
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
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');
    const nameInput = document.getElementById('name');
    const colorPreview = document.getElementById('colorPreview');
    const nameError = document.getElementById('name-error');
    const codeError = document.getElementById('code-error');
    
    // Color preview update
    codeInput.addEventListener('input', function() {
        const color = this.value;
        if (/^#[0-9A-Fa-f]{6}$/.test(color)) {
            colorPreview.style.backgroundColor = color;
        }
        
        // Clear error when user starts typing
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
            codeError.style.display = 'none';
        }
    });
    
    // Clear name error when user starts typing
    nameInput.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
            nameError.style.display = 'none';
        }
    });
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name');
        const code = document.getElementById('code');
        const nameError = document.getElementById('name-error');
        const codeError = document.getElementById('code-error');

        let isValid = true;

        // Hide all custom errors
        nameError.style.display = 'none';
        codeError.style.display = 'none';

        // Remove invalid classes
        name.classList.remove('is-invalid');
        code.classList.remove('is-invalid');

        // Validate name field
        if (!name.value.trim()) {
            name.classList.add('is-invalid');
            nameError.textContent = 'Color name is required.';
            nameError.style.display = 'block';
            isValid = false;
        }

        // Validate color code field
        if (!code.value.trim()) {
            code.classList.add('is-invalid');
            codeError.textContent = 'Color code is required.';
            codeError.style.display = 'block';
            isValid = false;
        } else if (!/^#[0-9A-Fa-f]{6}$/.test(code.value)) {
            code.classList.add('is-invalid');
            codeError.textContent = 'Please enter a valid hex color code (e.g., #FF5733).';
            codeError.style.display = 'block';
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            // Focus on first invalid field
            const firstInvalid = document.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.focus();
            }
        }
    });
});
</script>
@endsection
