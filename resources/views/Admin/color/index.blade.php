@extends('Admin.layouts.master')
@section('source', 'Color')
@section('page-title', 'Colors')

@section('title')
{{ config('app.name') }} - Colors
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.colors') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;" placeholder="Search by name or code" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1" style="height:40px;">Search</button>
                        <a href="{{ route('admin.colors') }}" class="btn btn-danger mb-sm-3 mb-1" style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Button -->
                <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                    <a href="{{ route('admin.colors.create') }}" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-plus"></i> Add New Color
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Color</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Code</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Color Tone</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $color)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $color->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="color-preview" style="width: 24px; height: 24px; background-color: {{ $color->code }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                                            <span class="text-sm">{{ $color->code }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-sm">{{ $color->color_tone ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" class="text-secondary font-weight-bold text-xs me-4"
                                       data-bs-toggle="modal" data-bs-target="#editModal{{ $color->id }}"
                                       title="Edit color">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form id="delete-form-{{ $color->id }}"
                                          action="{{ route('admin.colors.delete', $color->id) }}"
                                          method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="javascript:void(0);"
                                       onclick="confirmDelete({{ $color->id }})">
                                        <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $color->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $color->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $color->id }}">Edit Color</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="editForm{{ $color->id }}"
                                              action="{{ route('admin.colors.update', $color->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-start">
                                                <div class="mb-3">
                                                    <label for="edit_name_{{ $color->id }}" class="form-label">Color Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="edit_name_{{ $color->id }}" name="name" 
                                                           value="{{ $color->name }}" maxlength="50" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_code_{{ $color->id }}" class="form-label">Color Code <span class="text-danger">*</span></label>
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <input type="text" class="form-control" id="edit_code_{{ $color->id }}" name="code" 
                                                               value="{{ $color->code }}" maxlength="7" required pattern="^#[0-9A-Fa-f]{6}$">
                                                        <div class="color-preview" style="width: 32px; height: 32px; background-color: {{ $color->code }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_color_tone_{{ $color->id }}" class="form-label">Color Tone</label>
                                                    <input type="text" class="form-control" id="edit_color_tone_{{ $color->id }}" name="color_tone" 
                                                           value="{{ $color->color_tone }}" maxlength="50">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <p class="text-muted">No colors found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
                    </div>
                    <div>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(colorId) {
    if (confirm('Are you sure you want to delete this color?')) {
        document.getElementById('delete-form-' + colorId).submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Form validation for edit modals
    document.querySelectorAll('form[id^="editForm"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const colorId = this.id.replace('editForm', '');
            const name = document.getElementById('edit_name_' + colorId);
            const code = document.getElementById('edit_code_' + colorId);

            let isValid = true;

            // Reset validation states
            this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

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
});
</script>
@endsection
