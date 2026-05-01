@extends('Admin.layouts.master')

@section('source', 'Category Occasion Content')
@section('page-title', 'Category Occasion Content')

@section('title')
{{ config('app.name') }} - Category Occasion Content
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header px-5 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Category Occasion Content Management</h6>
                    <a href="{{ route('admin.category-occasion-content.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Content
                    </a>
                </div>
            </div>
            <div class="card px-5 pt-2 pb-3">
                <!-- Filters -->
                <form method="GET" action="{{ route('admin.category-occasion-content.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="occasion_id" class="form-label">Occasion</label>
                            <select name="occasion_id" id="occasion_id" class="form-select">
                                <option value="">All Occasions</option>
                                @foreach($occasions as $occasion)
                                    <option value="{{ $occasion->id }}" {{ request('occasion_id') == $occasion->id ? 'selected' : '' }}>
                                        {{ $occasion->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                   value="{{ request('search') }}" placeholder="Search content, category, or occasion...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('admin.category-occasion-content.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Category</th>
                                <th>Occasion</th>
                                <th>Content</th>
                                <th>Created</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <td>
                                        <span class="badge bg-info">{{ $item->category->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $item->occasion->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @if($item->content)
                                            <div class="text-truncate" style="max-width: 300px;">
                                                {{ Str::limit(strip_tags($item->content), 100) }}
                                            </div>
                                            @if(strlen(strip_tags($item->content)) > 100)
                                                <small class="text-muted">Click to view full content</small>
                                            @endif
                                        @else
                                            <span class="text-muted">No content</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $item->created_at->format('M j, Y') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.category-occasion-content.show', $item->id) }}" 
                                               class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.category-occasion-content.edit', $item->id) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.category-occasion-content.destroy', $item->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        title="Delete" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p>No category occasion content found.</p>
                                            <a href="{{ route('admin.category-occasion-content.create') }}" class="btn btn-primary">
                                                Add First Content
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($data->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $data->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
