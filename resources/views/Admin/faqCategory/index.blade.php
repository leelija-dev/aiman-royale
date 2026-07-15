@extends('Admin.layouts.master')
@section('source', 'FAQ Category')
@section('page-title', 'FAQ Categories')

@section('title')
{{ config('app.name') }} - FAQ Categories
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('faqCategory.index') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;" placeholder="Search by category name" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1" style="height:40px;">Search</button>
                        <a href="{{ route('faqCategory.index') }}" class="btn btn-danger mb-sm-3 mb-1" style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Button -->
                <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                    <a href="{{ route('faqCategory.create') }}" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-plus"></i> Add New FAQ Category
                    </a>
                </div>
            </div>
            <div class="card-body px-4 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqCategories as $faqCategory)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $faqCategory->category_name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="badge {{ $faqCategory->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $faqCategory->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-sm">{{ $faqCategory->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" class="text-secondary font-weight-bold text-xs me-4"
                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $faqCategory->id }}"
                                        title="Edit FAQ Category">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form id="delete-form-{{ $faqCategory->id }}"
                                        action="{{ route('faqCategory.destroy', $faqCategory->id) }}"
                                        method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="javascript:void(0);"
                                        onclick="confirmDelete({{ $faqCategory->id }})">
                                        <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $faqCategory->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $faqCategory->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $faqCategory->id }}">Edit FAQ Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="editForm{{ $faqCategory->id }}"
                                            action="{{ route('faqCategory.update', $faqCategory->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-start">
                                                <div class="mb-3">
                                                    <label for="edit_category_name_{{ $faqCategory->id }}" class="form-label">Category Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="edit_category_name_{{ $faqCategory->id }}" name="category_name"
                                                        value="{{ $faqCategory->category_name }}" maxlength="255" required>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="edit_is_active_{{ $faqCategory->id }}" name="is_active" 
                                                            {{ $faqCategory->is_active ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="edit_is_active_{{ $faqCategory->id }}">
                                                            Active
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <p class="text-muted">No FAQ categories found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class=" mt-4">
                    @if(isset($faqCategories) && method_exists($faqCategories, 'links'))
                    <div>
                        {{ $faqCategories->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(categoryId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                // Submit the form
                document.getElementById('delete-form-' + categoryId).submit();
                // Return false to prevent SweetAlert from closing immediately
                return false;
            }
        }).then((result) => {
            // This won't execute because form submission redirects
            if (result.isConfirmed) {
                // Form is submitted, page will redirect
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Form validation for edit modals
        document.querySelectorAll('form[id^="editForm"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const categoryId = this.id.replace('editForm', '');
                const categoryName = document.getElementById('edit_category_name_' + categoryId);

                let isValid = true;

                // Reset validation states
                this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                // Validate required fields
                if (!categoryName.value.trim()) {
                    categoryName.classList.add('is-invalid');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields correctly.');
                }
            });
        });
    });
</script>
@endsection
