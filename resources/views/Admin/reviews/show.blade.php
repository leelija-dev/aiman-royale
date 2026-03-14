@extends('Admin.layouts.master')
@section('title', 'Review Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Review Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back to Reviews
                        </a>
                        <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Review Information -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Review Content</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Product:</strong>
                                            <p>
                                                @if($review->product)
                                                    <a href="#" class="text-primary">{{ $review->product->name }}</a>
                                                    <br><small class="text-muted">ID: {{ $review->product_id }}</small>
                                                @else
                                                    <span class="text-muted">N/A (Product ID: {{ $review->product_id }})</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Rating:</strong>
                                            <p>
                                                <span class="text-warning">
                                                    @php echo str_repeat('⭐', $review->rating); @endphp
                                                    <span class="text-muted">({{ $review->rating }}/5)</span>
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Reviewer:</strong>
                                            <p>
                                                {{ $review->reviewer_name }}
                                                @if($review->reviewer_email)
                                                    <br><small class="text-muted">{{ $review->reviewer_email }}</small>
                                                @endif
                                                @if($review->user)
                                                    <br><small class="badge badge-info">User: {{ $review->user->name }}</small>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Status:</strong>
                                            <p>
                                                <span class="badge badge-{{ $review->status == 'approved' ? 'success' : ($review->status == 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($review->status) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                

                                    <div class="mb-3">
                                        <strong>Review Text:</strong>
                                        <div class="border rounded p-3 bg-light">
                                            <p class="mb-0">{{ $review->review_text }}</p>
                                        </div>
                                    </div>

                                    @if($review->admin_notes)
                                        <div class="mb-3">
                                            <strong>Admin Notes:</strong>
                                            <div class="border rounded p-3 bg-info bg-light">
                                                <p class="mb-0">{{ $review->admin_notes }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Metadata & Actions -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Quick Actions</h4>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        
                                        <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit Review
                                        </a>
                                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                                <i class="fas fa-trash"></i> Delete Review
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Review Metadata</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Review ID:</strong></td>
                                            <td>{{ $review->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ $review->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created Time:</strong></td>
                                            <td>{{ $review->created_at->format('h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Updated:</strong></td>
                                            <td>{{ $review->updated_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Review Date:</strong></td>
                                            <td>{{ $review->review_date->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>IP Address:</strong></td>
                                            <td>{{ $review->ip_address ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>User Agent:</strong></td>
                                            <td>
                                                <small class="text-muted">{{ $review->user_agent ?? 'N/A' }}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Helpful Count:</strong></td>
                                            <td>{{ $review->helpful_count ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Count:</strong></td>
                                            <td>{{ $review->total_count ?? 0 }}</td>
                                        </tr>
                                        @if($review->total_count > 0)
                                        <tr>
                                            <td><strong>Helpful %:</strong></td>
                                            <td>{{ round(($review->helpful_count / $review->total_count) * 100, 1) }}%</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
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

function toggleVerified(reviewId) {
    fetch(`/admin/reviews/${reviewId}/toggle-verified`, {
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
        alert('An error occurred while toggling verified status.');
    });
}
</script>
@endsection
