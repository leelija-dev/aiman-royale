@extends('Admin.layouts.master')

@section('title', 'Create Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Review</h3>
                    <div class="card-tools">
                        <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back to Reviews
                        </a>
                    </div>
                </div>
                <form action="{{ route('reviews.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_id">Product <span class="text-danger">*</span></label>
                                    <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $id => $name)
                                            <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id">User (Optional)</label>
                                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                        <option value="">Select User (Leave empty for guest review)</option>
                                        <!-- You can populate users here if needed -->
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reviewer_name">Reviewer Name <span class="text-danger">*</span></label>
                                    <input type="text" name="reviewer_name" id="reviewer_name" class="form-control @error('reviewer_name') is-invalid @enderror" value="{{ old('reviewer_name') }}" required>
                                    @error('reviewer_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reviewer_email">Reviewer Email</label>
                                    <input type="email" name="reviewer_email" id="reviewer_email" class="form-control @error('reviewer_email') is-invalid @enderror" value="{{ old('reviewer_email') }}">
                                    @error('reviewer_email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rating">Rating <span class="text-danger">*</span></label>
                                    <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror" required>
                                        <option value="">Select Rating</option>
                                        <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars)</option>
                                        <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars)</option>
                                        <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 Stars)</option>
                                        <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2 Stars)</option>
                                        <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>⭐ (1 Star)</option>
                                    </select>
                                    @error('rating')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                          
                        </div>

                        <div class="form-group">
                            <label for="review_text">Review Text <span class="text-danger">*</span></label>
                            <textarea name="review_text" id="review_text" rows="4" class="form-control @error('review_text') is-invalid @enderror" required>{{ old('review_text') }}</textarea>
                            @error('review_text')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="admin_notes">Admin Notes</label>
                            <textarea name="admin_notes" id="admin_notes" rows="2" class="form-control @error('admin_notes') is-invalid @enderror" placeholder="Internal notes about this review...">{{ old('admin_notes') }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Review
                        </button>
                        <a href="{{ route('reviews.index') }}" class="btn btn-default ml-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
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
    const form = document.querySelector('form');
    const ratingSelect = document.getElementById('rating');
    const reviewerName = document.getElementById('reviewer_name');
    const reviewText = document.getElementById('review_text');
    const productSelect = document.getElementById('product_id');

    // Add CSS to ensure error messages are visible
    const style = document.createElement('style');
    style.textContent = `
        .invalid-feedback.d-block {
            display: block !important;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #dc3545;
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
    `;
    document.head.appendChild(style);

    // Real-time validation
    const inputs = [reviewerName, reviewText, productSelect, ratingSelect];
    inputs.forEach(input => {
        if (input) {
            input.addEventListener('input', function() {
                validateField(this);
            });
            input.addEventListener('blur', function() {
                validateField(this);
            });
            input.addEventListener('change', function() {
                validateField(this);
            });
        }
    });

    // Rating preview with validation
    ratingSelect.addEventListener('change', function() {
        const rating = this.value;
        validateField(this);
        if (rating) {
            const stars = '⭐'.repeat(parseInt(rating));
            console.log('Selected rating:', stars);
        }
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Validate all required fields
        if (!validateField(productSelect)) isValid = false;
        if (!validateField(reviewerName)) isValid = false;
        if (!validateField(ratingSelect)) isValid = false;
        if (!validateField(reviewText)) isValid = false;

        // Validate email format if provided
        const emailField = document.getElementById('reviewer_email');
        if (emailField.value && !validateEmail(emailField.value)) {
            showError(emailField, 'Please enter a valid email address');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            
            // Scroll to first error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            // Show alert with error count
            const errorCount = document.querySelectorAll('.is-invalid').length;
            alert(`Please fix ${errorCount} error(s) before submitting.`);
        }
    });

    // Field validation function
    function validateField(field) {
        if (!field) return true;
        
        let isValid = true;
        const value = field.value.trim();

        // Remove existing error
        removeError(field);

        switch(field.id) {
            case 'product_id':
                if (!value) {
                    showError(field, '⚠️ Please select a product for this review');
                    isValid = false;
                }
                break;

            case 'reviewer_name':
                if (!value) {
                    showError(field, '👤 Reviewer name is required');
                    isValid = false;
                } else if (value.length < 2) {
                    showError(field, '👤 Name must be at least 2 characters long');
                    isValid = false;
                } else if (value.length > 100) {
                    showError(field, '👤 Name cannot exceed 100 characters');
                    isValid = false;
                } else if (!/^[a-zA-Z\s\-']+$/.test(value)) {
                    showError(field, '👤 Name can only contain letters, spaces, hyphens and apostrophes');
                    isValid = false;
                }
                break;

            case 'rating':
                if (!value) {
                    showError(field, '⭐ Please select a rating between 1 and 5 stars');
                    isValid = false;
                }
                break;

            case 'status':
                if (!value) {
                    showError(field, '📊 Please select a status');
                    isValid = false;
                }
                break;

            case 'review_text':
                if (!value) {
                    showError(field, '📝 Review text is required');
                    isValid = false;
                } else if (value.length < 10) {
                    showError(field, '📝 Review must be at least 10 characters long');
                    isValid = false;
                } else if (value.length > 1000) {
                    showError(field, '📝 Review cannot exceed 1000 characters');
                    isValid = false;
                }
                break;

            case 'reviewer_email':
                if (value && !validateEmail(value)) {
                    showError(field, '📧 Please enter a valid email address (e.g., name@example.com)');
                    isValid = false;
                }
                break;
        }

        return isValid;
    }

    // Email validation function
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Show error function
    function showError(field, message) {
        field.classList.add('is-invalid');
        
        // Remove existing error message if any
        const existingError = field.parentNode.querySelector('.invalid-feedback:not(.server-error)');
        if (existingError) {
            existingError.remove();
        }
        
        // Create and insert new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.textContent = message;
        
        // Insert after the field
        field.parentNode.insertBefore(errorDiv, field.nextSibling);
    }

    // Remove error function
    function removeError(field) {
        field.classList.remove('is-invalid');
        const errorDiv = field.parentNode.querySelector('.invalid-feedback:not(.server-error)');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    // Character counter for review text
    const reviewTextArea = document.getElementById('review_text');
    if (reviewTextArea) {
        // Remove existing counter if any
        const existingCounter = document.getElementById('reviewCounter');
        if (existingCounter) {
            existingCounter.remove();
        }
        
        const counterDiv = document.createElement('div');
        counterDiv.className = 'text-muted small mt-1';
        counterDiv.id = 'reviewCounter';
        reviewTextArea.parentNode.appendChild(counterDiv);
        
        function updateCounter() {
            const length = reviewTextArea.value.length;
            counterDiv.textContent = `${length}/1000 characters`;
            
            counterDiv.classList.remove('text-danger', 'text-warning', 'text-muted');
            
            if (length > 1000) {
                counterDiv.classList.add('text-danger');
            } else if (length < 10 && length > 0) {
                counterDiv.classList.add('text-warning');
            } else {
                counterDiv.classList.add('text-muted');
            }
        }
        
        reviewTextArea.addEventListener('input', updateCounter);
        updateCounter(); // Initial call
    }

    // Auto-populate reviewer info if user is selected
    const userSelect = document.getElementById('user_id');
    if (userSelect) {
        userSelect.addEventListener('change', function() {
            const userId = this.value;
            if (userId) {
                console.log('User selected:', userId);
                // Add AJAX call here if needed
            }
        });
    }

    // Preserve server-side validation errors
    @if($errors->any())
        @foreach($errors->keys() as $error)
            const field = document.getElementById('{{ $error }}');
            if (field) {
                field.classList.add('is-invalid');
            }
        @endforeach
    @endif
});
</script>
@endsection