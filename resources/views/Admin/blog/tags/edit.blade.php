{{-- @extends('Admin.layouts.master')

@section('title','Edit Tag')

@section('content')
<div class="container-fluid py-4">
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.blog.tags.update', $tag) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row g-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $tag->name) }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Slug</label>
              <input type="text" name="slug" class="form-control" value="{{ old('slug', $tag->slug) }}">
            </div>
            <div>
              <button class="btn btn-primary">Update</button>
              <a href="{{ route('admin.blog.tags.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection --}}
