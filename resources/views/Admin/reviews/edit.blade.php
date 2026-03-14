@extends('Admin.layouts.master')

@section('title', 'Edit Review')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Review</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back to Reviews
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{--
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h5><i class="fas fa-exclamation-triangle"></i> Validation Errors!</h5>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
            </div>
            @endif
            --}}

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_id">Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                                <option value="">Select Product</option>
                                @foreach($products as $id => $name)
                                <option value="{{ $id }}" {{ old('product_id', $review->product_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
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
                                <option value="{{ $review->user_id }}" {{ $review->user_id ? 'selected' : '' }}>Current User</option>
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
                            <input type="text" name="reviewer_name" id="reviewer_name" class="form-control @error('reviewer_name') is-invalid @enderror" value="{{ old('reviewer_name', $review->reviewer_name) }}" required>
                            @error('reviewer_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reviewer_email">Reviewer Email</label>
                            <input type="email" name="reviewer_email" id="reviewer_email" class="form-control @error('reviewer_email') is-invalid @enderror" value="{{ old('reviewer_email', $review->reviewer_email) }}">
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
                                <option value="5" {{ old('rating', $review->rating) == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars)</option>
                                <option value="4" {{ old('rating', $review->rating) == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars)</option>
                                <option value="3" {{ old('rating', $review->rating) == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 Stars)</option>
                                <option value="2" {{ old('rating', $review->rating) == '2' ? 'selected' : '' }}>⭐⭐ (2 Stars)</option>
                                <option value="1" {{ old('rating', $review->rating) == '1' ? 'selected' : '' }}>⭐ (1 Star)</option>
                            </select>
                            @error('rating')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label for="review_text">Review Text <span class="text-danger">*</span></label>
                    <textarea name="review_text" id="review_text" rows="4" class="form-control @error('review_text') is-invalid @enderror" required>{{ old('review_text', $review->review_text) }}</textarea>
                    @error('review_text')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="admin_notes">Admin Notes</label>
                                <textarea name="admin_notes" id="admin_notes" rows="2" class="form-control @error('admin_notes') is-invalid @enderror" placeholder="Internal notes about this review...">{{ old('admin_notes', $review->admin_notes) }}</textarea>
                                @error('admin_notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Review Metadata -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-info-circle"></i> Review Metadata</h6>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <strong>Created:</strong> {{ $review->created_at->format('M d, Y h:i A') }}
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Updated:</strong> {{ $review->updated_at->format('M d, Y h:i A') }}
                                            </div>
                                            <div class="col-md-3">
                                                <strong>IP Address:</strong> {{ $review->ip_address ?? 'N/A' }}
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Review Date:</strong> {{ $review->review_date->format('M d, Y h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Review
                            </button>
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-default ml-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-info ml-2">
                                <i class="fas fa-eye"></i> View Review
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
            // Rating preview
            document.getElementById('rating').addEventListener('change', function() {
                const rating = this.value;
                const stars = '⭐'.repeat(parseInt(rating));
                console.log('Selected rating:', stars);
            });

            // Auto-populate reviewer info if user is selected
            document.getElementById('user_id').addEventListener('change', function() {
                if (this.value) {
                    // You can fetch user details via AJAX if needed
                    console.log('User selected:', this.value);
                }
            });
        </script>
        @endsection