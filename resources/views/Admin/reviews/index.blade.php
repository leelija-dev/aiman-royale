@extends('Admin.layouts.master')

@section('title', 'Reviews Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reviews Management</h3>
                    <div class="card-tools">
                        <a href="{{ route('reviews.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Add Review
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Bulk Actions -->
                    
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
                                        </th>
                                        <th>Product</th>
                                        <th>Reviewer</th>
                                        <th>Rating</th>
                                        <th>Review Text</th>
                                        <th>Date</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reviews as $review)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="review_ids[]" value="{{ $review->id }}" class="review-checkbox">
                                            </td>
                                            <td>
                                                <strong>{{ $review->product->name ?? 'N/A' }}</strong>
                                                @if($review->product_id)
                                                    <br><small class="text-muted">ID: {{ $review->product_id }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $review->reviewer_name }}</strong>
                                                @if($review->reviewer_email)
                                                    <br><small class="text-muted">{{ $review->reviewer_email }}</small>
                                                @endif
                                                @if($review->user)
                                                    <br><small class="badge badge-info">User: {{ $review->user->name }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-warning">
                                                    @php echo str_repeat('⭐', $review->rating); @endphp
                                                    <small class="text-muted">({{ $review->rating }}/5)</small>
                                                </div>
                                            </td>
                                            <td>
                                                {{$review->review_text ?? ''}}
                                            </td>
                                            {{--
                                            <td>
                                                @if($review->is_featured)
                                                    <span class="badge badge-warning">⭐</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            --}}
                                            <td>
                                                <small>{{ $review->created_at->format('M d, Y') }}</small>
                                                <br><small class="text-muted">{{ $review->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    {{--
                                                    <button type="button" class="btn btn-success" onclick="toggleStatus({{ $review->id }})" title="Toggle Status">
                                                        <i class="fas fa-sync"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary" onclick="toggleFeatured({{ $review->id }})" title="Toggle Featured">
                                                        <i class="fas fa-star"></i>
                                                    </button>
                                                    --}}
                                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this review?')" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5>No reviews found</h5>
                                                <p class="text-muted">Start by creating your first review.</p>
                                                <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Create Review
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews
                            </div>
                            <div>
                                {{ $reviews->links() }}
                            </div>
                        </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Select all functionality
function selectAll() {
    document.querySelectorAll('.review-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAll() {
    document.querySelectorAll('.review-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
}

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.review-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

// Bulk action confirmation
function confirmBulkAction() {
    const action = document.querySelector('select[name="action"]').value;
    const selectedCount = document.querySelectorAll('.review-checkbox:checked').length;
    
    if (!action) {
        alert('Please select a bulk action.');
        return false;
    }
    
    if (selectedCount === 0) {
        alert('Please select at least one review.');
        return false;
    }
    
    const actionMessages = {
        'approve': 'approve',
        'reject': 'reject',
        'delete': 'delete'
    };
    
    return confirm(`Are you sure you want to ${actionMessages[action]} ${selectedCount} review(s)?`);
}

// AJAX toggle functions
function toggleStatus(reviewId) {
    fetch(`/admin/reviews/${reviewId}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while toggling status.');
    });
}

function toggleFeatured(reviewId) {
    fetch(`/admin/reviews/${reviewId}/toggle-featured`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while toggling featured status.');
    });
}
</script>
@endsection
