@extends('Admin.layouts.master')
@section('source', 'FAQ')
@section('page-title', 'FAQs')

@section('title')
{{ config('app.name') }} - FAQs
@endsection


@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('faqs.index') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;" placeholder="Search FAQs..." value="{{ request('search') }}">
                        <select name="category_id" class="form-control me-2" style="height:40px;">
                            <option value="">All Categories</option>
                            @foreach($categories as $id => $name)
                                <option value="{{ $id }}" {{ request('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1" style="height:40px;">Search</button>
                        <a href="{{ route('faqs.index') }}" class="btn btn-danger mb-sm-3 mb-1" style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Button -->
                <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                    <a href="{{ route('faqs.create') }}" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-plus"></i> Add New FAQ
                    </a>
                </div>
            </div>
            <div class="card-body px-4 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Question</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ Str::limit($faq->question, 50) }}</h6>
                                            <small class="text-muted">{{ Str::limit($faq->answer, 80) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-sm">{{ $faq->category->category_name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="badge {{ $faq->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-sm">{{ $faq->sort_order }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-sm">{{ $faq->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" class="text-secondary font-weight-bold text-xs me-4"
                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $faq->id }}"
                                        title="Edit FAQ">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form id="delete-form-{{ $faq->id }}"
                                        action="{{ route('faqs.destroy', $faq->id) }}"
                                        method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="javascript:void(0);"
                                        onclick="confirmDelete({{ $faq->id }})">
                                        <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $faq->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $faq->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $faq->id }}">Edit FAQ</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="editForm{{ $faq->id }}"
                                            action="{{ route('faqs.update', $faq->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-start">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="edit_question_{{ $faq->id }}" class="form-label">Question <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="edit_question_{{ $faq->id }}" name="question"
                                                                value="{{ $faq->question }}" maxlength="255" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="edit_category_{{ $faq->id }}" class="form-label">Category <span class="text-danger">*</span></label>
                                                            <select class="form-control" id="edit_category_{{ $faq->id }}" name="category_id" required>
                                                                @foreach($categoriess as $id => $name)
                                                                    <option value="{{ $id }}" {{ $faq->category_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_answer_{{ $faq->id }}" class="form-label">Answer <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="edit_answer_{{ $faq->id }}" name="answer" rows="4" required>{{ $faq->answer }}</textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="edit_sort_order_{{ $faq->id }}" class="form-label">Sort Order</label>
                                                            <input type="number" class="form-control" id="edit_sort_order_{{ $faq->id }}" name="sort_order" value="{{ $faq->sort_order }}" min="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <div class="form-check mt-4">
                                                                <input class="form-check-input" type="checkbox" id="edit_is_active_{{ $faq->id }}" name="is_active" value="1" {{ $faq->is_active ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="edit_is_active_{{ $faq->id }}">
                                                                    Active
                                                                </label>
                                                            </div>
                                                        </div>
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
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-muted">No FAQs found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class=" mt-4">
                    @if(isset($faqs) && method_exists($faqs, 'links'))
                    <div>
                        {{ $faqs->links('pagination::bootstrap-5') }}
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
    function confirmDelete(faqId) {
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
                document.getElementById('delete-form-' + faqId).submit();
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
                const faqId = this.id.replace('editForm', '');
                const question = document.getElementById('edit_question_' + faqId);
                const answer = document.getElementById('edit_answer_' + faqId);
                const category = document.getElementById('edit_category_' + faqId);

                let isValid = true;

                // Reset validation states
                this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                // Validate required fields
                if (!question.value.trim()) {
                    question.classList.add('is-invalid');
                    isValid = false;
                }
                if (!answer.value.trim()) {
                    answer.classList.add('is-invalid');
                    isValid = false;
                }
                if (!category.value) {
                    category.classList.add('is-invalid');
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
