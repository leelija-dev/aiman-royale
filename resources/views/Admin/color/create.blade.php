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
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('admin.colors.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Color Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name') }}" maxlength="50" required>
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="code" class="form-label">Color Code <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="text" class="form-control" id="code" name="code" 
                                           value="{{ old('code') }}" maxlength="7" required pattern="^#[0-9A-Fa-f]{6}$">
                                    <div id="colorPreview" style="width: 32px; height: 32px; background-color: #000000; border: 1px solid #ddd; border-radius: 4px;"></div>
                                </div>
                                @error('code')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
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
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Color
                            </button>
                            <a href="{{ route('admin.colors') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
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
    const colorPreview = document.getElementById('colorPreview');
    
    codeInput.addEventListener('input', function() {
        const color = this.value;
        if (/^#[0-9A-Fa-f]{6}$/.test(color)) {
            colorPreview.style.backgroundColor = color;
        }
    });
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name');
        const code = document.getElementById('code');

        let isValid = true;

        // Reset validation states
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

        // Validate required fields
        if (!name.value.trim()) {
            name.classList.add('is-invalid');
            isValid = false;
        }

        if (!code.value.trim() || !/^#[0-9A-Fa-f]{6}$/.test(code.value)) {
            code.classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields correctly.');
        }
    });
});
</script>
@endsection
