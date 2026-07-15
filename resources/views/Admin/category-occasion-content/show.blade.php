@extends('Admin.layouts.master')

@section('source', 'Category Occasion Content')
@section('page-title', 'View Category Occasion Content')

@section('title')
{{ config('app.name') }} - View Category Occasion Content
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header px-5 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Category Occasion Content Details</h6>
                    <div>
                        <a href="{{ route('admin.category-occasion-content.edit', $categoryOccasionContent->id) }}" class="btn btn-primary btn-sm me-2">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.category-occasion-content.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
            <div class="card px-5 pt-2 pb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Category</label>
                            <div>
                                <span class="badge bg-info fs-6">{{ $categoryOccasionContent->category->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Occasion</label>
                            <div>
                                <span class="badge bg-success fs-6">{{ $categoryOccasionContent->occasion->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Content</label>
                    <div class="border rounded p-3 bg-light" style="min-height: 200px;">
                        @if($categoryOccasionContent->content)
                            {!! $categoryOccasionContent->content !!}
                        @else
                            <span class="text-muted">No content available</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Created At</label>
                            <div>{{ $categoryOccasionContent->created_at->format('F j, Y g:i A') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Last Updated</label>
                            <div>{{ $categoryOccasionContent->updated_at->format('F j, Y g:i A') }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Content Statistics</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="border rounded p-2 text-center">
                                <div class="fs-4 fw-bold">{{ strlen($categoryOccasionContent->content ?? '') }}</div>
                                <div class="text-muted small">Characters</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-2 text-center">
                                <div class="fs-4 fw-bold">{{ str_word_count(strip_tags($categoryOccasionContent->content ?? '')) }}</div>
                                <div class="text-muted small">Words</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-2 text-center">
                                <div class="fs-4 fw-bold">{{ $categoryOccasionContent->content ? 'Yes' : 'No' }}</div>
                                <div class="text-muted small">Has Content</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <form action="{{ route('admin.category-occasion-content.destroy', $categoryOccasionContent->id) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this content?')">
                                <i class="fas fa-trash me-2"></i>Delete Content
                            </button>
                        </form>
                    </div>
                    <div>
                        <a href="{{ route('admin.category-occasion-content.edit', $categoryOccasionContent->id) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit me-2"></i>Edit Content
                        </a>
                        <a href="{{ route('admin.category-occasion-content.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
