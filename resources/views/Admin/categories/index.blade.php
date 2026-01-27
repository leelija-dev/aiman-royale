@extends('Admin.layouts.master')
@section('source', 'Categories')
@section('page-title', ' Product Categories')

@section('title')
{{config('app.name')}} - Product Categories
@endsection

{{-- @section('title','Product Categories') --}}

@section('content')
<div class="container-fluid py-4">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-md-nowrap flex-wrap">
      <h5 class="card-title">Product Categories</h5>
      <div class="d-flex gap-2 flex-sm-nowrap flex-wrap">
        <a href="{{ route('admin.categories.trash') }}" class="btn btn-outline-secondary">
          <i class="fas fa-trash"></i>  View Trashed Category
        </a>
        
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary ">
          <i class="fas fa-plus"></i> Add New Category
        </a>
      </div>
    </div>
    <div class="ms-3 me-3">
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <div class="table-responsive">
        <table class="table align-items-center mb-0 ">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">#</th>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name</th>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Slug</th>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Created At</th>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $category)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>
                  @if($category->is_active)
                    <span class="badge bg-success rounded-pill">
                      <i class="fas fa-check-circle me-1"></i> Active
                    </span>
                  @else
                    <span class="badge bg-danger rounded-pill">
                      <i class="fas fa-times-circle me-1"></i> Inactive
                    </span>
                  @endif
                </td>
                <td>{{ $category->created_at->format('d M, Y') }}</td>
                <td>
                  <div class="d-flex justify-content-start gap-2">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" 
                       class="btn btn-primary mb-0 px-3 d-flex justify-content-center align-items-center" 
                       title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form id="delete-form-{{$category->id}}" action="{{ route('admin.categories.destroy', $category->id) }}" 
                          method="POST" >
                      @csrf
                      @method('DELETE')
                      </form>
                      <button type="submit" class="btn btn-danger mb-0 px-3 d-flex justify-content-center align-items-center" title="Move to Trash" onclick="confirmDelete({{$category->id}})">
                        <i class="fas fa-trash"></i>
                      </button>
                    
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">Categories not available!</td>
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

<script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be delete this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection