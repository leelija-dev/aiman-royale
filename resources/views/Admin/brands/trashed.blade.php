@extends('Admin.layouts.master')
@section('source', 'Brands')
@section('page-title', 'Trashed Brands')

@section('title')
{{config('app.name')}} - Trashed Brands
@endsection

{{-- @section('title', 'Trashed Brands') --}}

@section('content')
    <div class="row w-100 px-3 mt-3 m-0">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Trashed Brands</h4>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to Active Brands
                    </a>
                </div>
                <div class="px-3 pt-0 pb-2 overflow-visible mh-100 py-0">
                    @if(session('success'))
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
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($brands->count() > 0)
                                    @foreach($brands as $brand)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->deleted_at->format('d M, Y h:i A') }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start gap-2">
                                                    <form action="{{ route('admin.brands.restore', $brand->id) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="btn btn-success px-3 py-2  d-flex justify-content-center align-items-center gap-2" 
                                                                title="Restore">
                                                            <i class="fas fa-trash-restore"></i> Restore
                                                        </button>
                                                    </form>
                                                    
                                                    <button type="button" 
                                                            class="btn btn-danger px-3 py-2 d-flex justify-content-center align-items-center gap-2" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModal{{ $brand->id }}"
                                                            title="Delete Permanently">
                                                        <i class="fas fa-trash"></i> Delete Permanently
                                                    </button>
                                                </div>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $brand->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{ $brand->id }}">Confirm Permanent Deletion</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to permanently delete <strong>{{ $brand->name }}</strong>? This action cannot be undone.</p>
                                                                <p class="text-danger">This will also delete all products associated with this brand.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <form action="{{ route('admin.brands.force-delete', $brand->id) }}" method="POST" class="d-inline">
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
                                    @endforeach
                                    @else
                                        <tr class="text-center" >
                                            <td colspan="4">Trashed brands not available!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $brands->links() }}
                        </div>
                   
                </div>
            </div>
        </div>
    </div>
@endsection
