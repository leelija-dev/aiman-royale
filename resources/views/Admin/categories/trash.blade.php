@extends('Admin.layouts.master')
@section('source', 'Categories')
@section('page-title', ' Trashed Categories')

@section('title')
    {{ config('app.name') }} - Trashed Categories
@endsection

{{-- @section('title', 'Trashed Categories') --}}

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Trashed Categories</h4>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </a>
                </div>
            </div>
            <div class="px-3 pt-0 pb-2">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Deleted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->deleted_at->format('d M, Y h:i A') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-start gap-2">
                                            <form action="{{ route('admin.categories.restore', $category->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn btn-success px-3 py-2  d-flex justify-content-center align-items-center gap-2"
                                                    title="Restore">
                                                    <i class="fas fa-trash-restore"></i> Restore
                                                </button>
                                            </form>
                                                              {{-- <form action="{{ route('admin.categories.force-delete', $category->id) }}" 
                                            method="POST" 
                                            class="d-inline" 
                                            onsubmit="return confirm('Are you sure you want to permanently delete this category? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger px-3 py-2  d-flex justify-content-center align-items-center gap-2" title="Delete Permanently">
                                          <i class="fas fa-trash"></i> Delete Permanently
                                        </button> --}}

                                            <!-- Delete Permanently Button (opens modal) -->
                                            <button type="button"
                                                class="btn btn-danger px-3 py-2 d-flex justify-content-center align-items-center gap-2"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}"
                                                title="Delete Permanently">
                                                <i class="fas fa-trash"></i> Delete Permanently
                                            </button>
                                            {{-- </form> --}}
                                        </div>
                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">
                                                            Confirm
                                                            Permanent Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to permanently delete
                                                            <strong><br>{{ $category->name }}</strong>?
                                                        </p>
                                                        {{-- <p class="text-danger">This will also delete all products associated with this brand.</p> --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form
                                                            action="{{ route('admin.categories.force-delete', $category->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fas fa-trash"></i> Delete Permanently
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Trashed categories not available!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $categories->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
