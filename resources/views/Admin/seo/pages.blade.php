@extends('Admin.layouts.master')
@section('source', 'Page SEO')
@section('page-title', 'Page SEO Management')

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Page SEO Management</h5>
                <a href="{{ route('seo.pages.create') }}" class="btn btn-primary btn-sm float-end">
                    <i class="fas fa-plus"></i> Add New
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead>
                            <tr>
                                <th>Page Slug</th>
                                <th>Meta Title</th>
                                <th>Meta Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                            <tr>
                                <td>{{ $page->slug }}</td>
                                <td>{{ $page->meta_title }}</td>
                                <td>{{ Str::limit($page->meta_description, 100) }}</td>
                                <td>
                                    @if($page->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Edit Button -->
                                    <button type="button" 
                                            class="btn btn-sm btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal{{ $page->id }}"
                                            title="Edit {{ $page->slug }} SEO">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No pages found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modals for each page -->
@forelse($pages as $page)
<div class="modal fade" id="editModal{{ $page->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $page->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-lg for better spacing -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $page->id }}">Edit {{ ucfirst($page->slug) }} SEO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('seo.pages.update', $page->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_meta_title_{{ $page->id }}" class="form-label">Meta Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_meta_title_{{ $page->id }}" name="meta_title" 
                                       value="{{ $page->meta_title }}" maxlength="255" required>
                                @error('meta_title')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_meta_description_{{ $page->id }}" class="form-label">Meta Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_meta_description_{{ $page->id }}" name="meta_description" 
                                          rows="4" maxlength="500" required>{{ $page->meta_description }}</textarea>
                                @error('meta_description')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_meta_keywords_{{ $page->id }}" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" id="edit_meta_keywords_{{ $page->id }}" name="meta_keywords" 
                                       value="{{ $page->meta_keywords }}" maxlength="255">
                                @error('meta_keywords')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_meta_tags_{{ $page->id }}" class="form-label">Meta Tags</label>
                                <input type="text" class="form-control" id="edit_meta_tags_{{ $page->id }}" name="meta_tags" 
                                       value="{{ $page->meta_tags }}" maxlength="255">
                                @error('meta_tags')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_schema_markup_{{ $page->id }}" class="form-label">Schema Markup</label>
                                <textarea class="form-control" id="edit_schema_markup_{{ $page->id }}" name="schema_markup" 
                                          rows="6">{{ $page->schema_markup }}</textarea>
                                @error('schema_markup')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="edit_is_active_{{ $page->id }}" name="is_active" 
                                           value="1" {{ $page->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit_is_active_{{ $page->id }}">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update SEO
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@empty
<!-- No modals to display if no pages exist -->
@endforelse

<!-- JavaScript for handling modals -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit modal forms
    document.querySelectorAll('form[id^="editForm"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const pageId = this.id.replace('editForm', '');
            const formData = new FormData(this);
            
            // Submit via AJAX/Fetch
            fetch('{{ route("seo.pages.update", ":id") }}'.replace(':id', pageId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
                    alertDiv.style.zIndex = '9999';
                    alertDiv.style.top = '20px';
                    alertDiv.style.right = '20px';
                    alertDiv.innerHTML = `
                        <strong>Success!</strong> ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                    `;
                    document.body.appendChild(alertDiv);
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editModal' + pageId));
                    modal.hide();
                    
                    // Update table row
                    const row = document.querySelector(`tr:has(button[data-bs-target="#editModal${pageId}"])`);
                    if (row) {
                        location.reload(); // Reload to show updated data
                    }
                } else {
                    // Show error message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                    alertDiv.style.zIndex = '9999';
                    alertDiv.style.top = '20px';
                    alertDiv.style.right = '20px';
                    alertDiv.innerHTML = `
                        <strong>Error!</strong> ${data.message || 'Something went wrong'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                    `;
                    document.body.appendChild(alertDiv);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating. Please try again.');
            });
        });
    });

    // Auto-hide alerts after 5 seconds
    setInterval(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            if (alert.style.opacity !== '0') {
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 300);
            }
        });
    }, 5000);
});
</script>
@endsection