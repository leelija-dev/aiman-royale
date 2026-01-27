{{-- @extends('Admin.layouts.master')

@section('title','Create Tag')

@section('content')
<div class="container-fluid py-4">
  <div class="card">
    <div class="card-body">
      <form id="tagPost" action="{{ route('admin.blog.tags.store') }}" method="post" novalidate>
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
              <div class="invalid-feedback">Tag name can not be blank!</div>
              @error('name')
              <div>
                <span class="invalid-feedback d-block">{{$message}}</span>
              </div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Slug (optional)</label>
              <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
            </div>
            <div>
              <button class="btn btn-primary">Save</button>
              <a href="{{ route('admin.blog.tags.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
(function () {
    'use strict'
    const form = document.getElementById('tagPost');
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
})();
</script>
@endsection --}}
