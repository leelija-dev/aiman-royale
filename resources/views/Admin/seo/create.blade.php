@extends('Admin.layouts.master')
@section('source', 'Page SEO')
@section('page-title', 'Add Page SEO')

@section('title')
{{ config('app.name') }} - Add Page SEO
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Add New Page SEO</h6>
            </div>
            <div class="card px-4 pt-2 pb-2">
                <form action="{{ route('seo.pages.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Page Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="slug" name="slug" 
                                           value="{{ old('slug') }}" maxlength="100" required>
                                    @error('slug')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Enter page slug (e.g., home, contact, about)</small>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                           value="{{ old('meta_title') }}" maxlength="255" required>
                                    @error('meta_title')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">SEO title for the page (max 255 characters)</small>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                           value="{{ old('meta_keywords') }}" maxlength="255">
                                    @error('meta_keywords')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Comma-separated keywords for SEO</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_tags" class="form-label">Meta Tags</label>
                                    <input type="text" class="form-control" id="meta_tags" name="meta_tags" 
                                           value="{{ old('meta_tags') }}" maxlength="255">
                                    @error('meta_tags')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Comma-separated tags for categorization</small>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" 
                                              rows="4" maxlength="500" required>{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">SEO description for the page (max 500 characters)</small>
                                </div>

                                <div class="mb-3">
                                    <label for="schema_markup" class="form-label">Schema Markup</label>
                                    <textarea class="form-control" id="schema_markup" name="schema_markup" 
                                              rows="6">{{ old('schema_markup') }}</textarea>
                                    @error('schema_markup')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">JSON-LD schema markup for structured data</small>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                    <small class="text-muted">Enable/disable SEO data for this page</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Page SEO
                            </button>
                            <a href="{{ route('seo.pages.index') }}" class="btn btn-secondary">
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
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const slug = document.getElementById('slug');
        const metaTitle = document.getElementById('meta_title');
        const metaDescription = document.getElementById('meta_description');

        let isValid = true;

        // Reset validation states
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

        // Validate required fields
        if (!slug.value.trim()) {
            slug.classList.add('is-invalid');
            isValid = false;
        }

        if (!metaTitle.value.trim()) {
            metaTitle.classList.add('is-invalid');
            isValid = false;
        }

        if (!metaDescription.value.trim()) {
            metaDescription.classList.add('is-invalid');
            isValid = false;
        }

        // Validate slug format (alphanumeric and hyphens only)
        const slugPattern = /^[a-z0-9-]+$/;
        if (slug.value.trim() && !slugPattern.test(slug.value.trim())) {
            slug.classList.add('is-invalid');
            isValid = false;
            alert('Slug can only contain lowercase letters, numbers, and hyphens.');
        }

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields correctly.');
        }
    });

    // Auto-format slug to lowercase and replace spaces with hyphens
    const slugInput = document.getElementById('slug');
    slugInput.addEventListener('input', function() {
        this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
    });

    // Character counters
    const metaTitleInput = document.getElementById('meta_title');
    const metaDescriptionInput = document.getElementById('meta_description');

    function addCharacterCounter(input, maxLength) {
        const counter = document.createElement('small');
        counter.className = 'text-muted';
        counter.style.float = 'right';
        input.parentNode.appendChild(counter);

        function updateCounter() {
            const remaining = maxLength - input.value.length;
            counter.textContent = `${input.value.length}/${maxLength} characters`;
            counter.className = remaining < 20 ? 'text-warning' : 'text-muted';
        }

        input.addEventListener('input', updateCounter);
        updateCounter();
    }

    addCharacterCounter(metaTitleInput, 255);
    addCharacterCounter(metaDescriptionInput, 500);
});
</script>
@endsection
