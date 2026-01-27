@extends('Admin.layouts.master')
@section('source', 'Brands')
@section('page-title', 'AddBrands')

@section('title')
{{config('app.name')}} - Add Brand

@endsection

@section('content')
    <div class="row w-100 px-3 mt-3 m-0 ">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Brand</h4>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body overflow-visible mh-100 py-0">
                    <form id="brandForm" action="{{ route('admin.brands.store') }}" method="POST" novalidate> 
                        @csrf
                        
                        <div class="form-group">
                            <label for="name" class="text-uppercase text-secondary">Brand Name<sup class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            <div class="invalid-feedback">Brand name can not be blank!</div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug') }}" >
                            <small class="form-text text-muted">Leave empty to auto-generate from name</small>
                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}

                        <div class="form-group">
                            <label for="description" class="text-uppercase text-secondary">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', false) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                            <small class="form-text text-muted">Check this box to make the brand active. Leave unchecked to create as inactive.</small>
                        </div>

                        <div class="form-group d-flex justify-content-end gap-3">
                            <button type="reset" class="btn btn-danger">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Brand
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-generate slug from name
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            
            if (nameInput) {
                nameInput.addEventListener('input', function() {
                    const name = this.value;
                    if (name && !slugInput.value) {
                        generateSlug(name);
                    }
                });
            }
            
            // Also generate slug when clicking on the slug field if it's empty
            if (slugInput) {
                slugInput.addEventListener('focus', function() {
                    if (!this.value && nameInput.value) {
                        generateSlug(nameInput.value);
                    }
                });
            }
            
            function generateSlug(name) {
                fetch('{{ route("admin.brands.generate-slug") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ name: name })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.slug) {
                        document.getElementById('slug').value = data.slug;
                    }
                })
                .catch(error => {
                    console.error('Error generating slug:', error);
                });
            }
        });
    </script>
    @endpush
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('brandForm');

    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
});
</script>
@endsection
