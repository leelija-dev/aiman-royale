@extends('Admin.layouts.master')
@section('source', 'Size')
@section('page-title', 'Add Size')

@section('title')
{{ config('app.name') }} - Add Size
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Add New Size</h6>
            </div>
            <div class="card px-4 pt-2 pb-2">
                <form action="{{ route('admin.sizes.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    
                        <div class="col-md-12">
                            <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Size Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name') }}" maxlength="20" required>
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="chest_size" class="form-label">Chest Size <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="chest_size" name="chest_size" 
                                       value="{{ old('chest_size') }}"  required>
                                @error('chest_size')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="neck_size" class="form-label">Bust Size <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="neck_size" name="neck_size" 
                                       value="{{ old('neck_size') }}" required>
                                @error('neck_size')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="waist_size" class="form-label">Waist Size <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="waist_size" name="waist_size" 
                                       value="{{ old('waist_size') }}" maxlength="20" required>
                                @error('waist_size')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="arm" class="form-label">Arm Hole Size <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="arm" name="arm" 
                                       value="{{ old('arm') }}" required>
                                @error('neck_size')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        
                        
                            
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code" class="form-label">Size Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="code" name="code" 
                                       value="{{ old('code') }}" maxlength="10" required>
                                @error('code')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Enter size code (e.g., S, M, L, XL)</small>
                            </div>

                            <div class="mb-3">
                                <label for="hip" class="form-label">Hip <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="hip" name="hip" 
                                       value="{{ old('hip') }}" maxlength="10" required>
                                @error('code')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror 
                            </div>

                              <div class="mb-3">
                                <label for="uk_size" class="form-label">Uk Size <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="uk_size" name="uk_size" 
                                       value="{{ old('uk_size') }}" maxlength="10" required>
                                @error('code')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                
                            </div>


                            
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" 
                                       value="{{ old('sort_order') }}" min="0" required>
                                @error('sort_order')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Lower numbers appear first</small>
                            </div>
                        </div>
                        
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12 text-end">
                            <a href="{{ route('admin.sizes') }}" class="btn btn-danger">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Size
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

        if (!code.value.trim()) {
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
