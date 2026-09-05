@extends('Admin.layouts.master')
@section('source', 'FAQ')
@section('page-title', 'Create FAQ')

@section('title')
{{ config('app.name') }} - Create FAQ
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Create FAQ</h3>
                <a href="{{ route('faqs.index') }}" class="btn btn-secondary float-right">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('faqs.store') }}" method="POST" id="faqForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="heading">Heading <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('heading') is-invalid @enderror"
                                    id="heading" name="heading" value="{{ old('heading') }}" maxlength="255" required>
                                @error('heading')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_id">Product <span class="text-danger">*</span></label>
                                <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                                    <option value="">Select Product</option>
                                    @foreach($products as $id => $name)
                                        <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Associate this FAQ with a specific product</small>
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categoriess as $id => $name)
                                        <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Question-Answer Pairs Container -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Questions & Answers</h5>
                                    <button type="button" class="btn btn-success btn-sm float-right" id="addMoreBtn">
                                        <i class="fas fa-plus"></i> Add Question
                                    </button>
                                </div>
                                <div class="card-body" id="faqContainer">
                                    <!-- Default FAQ Pair -->
                                    <div class="faq-item border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-11">
                                                <div class="form-group">
                                                    <label>Question <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('faqs.0.question') is-invalid @enderror"
                                                        name="faqs[0][question]" placeholder="Enter question" required>
                                                    @error('faqs.0.question')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Answer <span class="text-danger">*</span></label>
                                                    <textarea class="form-control @error('faqs.0.answer') is-invalid @enderror"
                                                        name="faqs[0][answer]" rows="3" placeholder="Enter answer" required></textarea>
                                                    @error('faqs.0.answer')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-1 d-flex align-items-start">
                                                <button type="button" class="btn btn-danger btn-sm remove-btn" style="margin-top: 30px;" disabled>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sort_order">Sort Order</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                    id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Lower numbers appear first</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create FAQ
                            </button>
                            <a href="{{ route('faqs.index') }}" class="btn btn-danger ms-3">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let faqIndex = 1; // Start counter for new FAQs

    // Add new FAQ pair
    $('#addMoreBtn').on('click', function() {
        const newFaq = `
            <div class="faq-item border p-3 mb-3 rounded">
                <div class="row">
                    <div class="col-11">
                        <div class="form-group">
                            <label>Question <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" 
                                name="faqs[${faqIndex}][question]" 
                                placeholder="Enter question" required>
                        </div>
                        <div class="form-group">
                            <label>Answer <span class="text-danger">*</span></label>
                            <textarea class="form-control" 
                                name="faqs[${faqIndex}][answer]" 
                                rows="3" placeholder="Enter answer" required></textarea>
                        </div>
                    </div>
                    <div class="col-1 d-flex align-items-start">
                        <button type="button" class="btn btn-danger btn-sm remove-btn" style="margin-top: 30px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        $('#faqContainer').append(newFaq);
        faqIndex++;
        
        // Enable remove buttons if more than 1 item
        if ($('.faq-item').length > 1) {
            $('.remove-btn').prop('disabled', false);
        }
    });

    // Remove FAQ pair
    $(document).on('click', '.remove-btn', function() {
        if ($('.faq-item').length <= 1) {
            alert('You must have at least one FAQ item.');
            return;
        }
        
        if (confirm('Are you sure you want to remove this question-answer pair?')) {
            $(this).closest('.faq-item').remove();
            
            // Disable remove button if only 1 item left
            if ($('.faq-item').length === 1) {
                $('.remove-btn').prop('disabled', true);
            }
        }
    });
});
</script>
@endpush

<style>
.faq-item {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.faq-item:hover {
    background-color: #f1f3f5;
    border-color: #adb5bd;
}

.remove-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

#addMoreBtn {
    margin-top: -5px;
}
</style>
@endsection