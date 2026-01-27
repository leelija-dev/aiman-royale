@extends('Admin.layouts.master')
@section('source', 'Categories')
@section('page-title', ' Edit Category')

@section('title')
{{config('app.name')}} - Edit Category
@endsection
{{-- @section('title','Edit Product Category') --}}

@section('content')
<div class="container-fluid py-4">
  <div class="card">
    <div class="card-body overflow-visible mh-100">
      <form id="updateCategory" action="{{ route('admin.categories.update', $category->id) }}" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="row">
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Name<sup class="text-danger">*</sup></label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
              <div class="invalid-feedback">Product category name cannot be blank!</div>
              @error('name')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Slug <sup class="text-danger">*</sup></label>
              <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}" required>
              <div class="invalid-feedback">Slug cannot be blank!</div>
              @error('slug')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
           <div class="mb-3">
    <label class="form-label text-secondary text-uppercase">
        Image <sup class="text-danger">*</sup>
    </label>

    {{-- Show existing image (edit page) --}}
    @if(!empty($category->image))
        <div class="mb-2">
            <img src="{{ asset('uploads/category/'.$category->image) }}"
                 alt="Category Image"
                 style="width:120px;height:auto;border:1px solid #ddd;padding:5px;border-radius:6px;">
        </div>
    @endif

    {{-- File input --}}
    <input type="file"
           name="image"
           class="form-control"
           accept=".jpg,.jpeg,.png">
</div>

            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Parent Category</label>
              <select name="parent_id" class="form-control">
                <option value="">None (Root Category)</option>
                @if(isset($categories) && $categories->count() > 0)
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                  @endforeach
                @endif
              </select>
              @error('parent_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Description</label>
              <textarea name="description" rows="4" class="form-control">{{ old('description', $category->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Status</label>
              <div class="form-check form-switch">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ (old('is_active', $category->is_active) == 1 || old('is_active', $category->is_active) === true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
              </div>
              @error('is_active')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class=" d-flex justify-content-end gap-2 flex-sm-nowrap flex-wrap">
              <a href="{{ route('admin.categories.index') }}" class="btn btn-danger mb-sm-2 mb-0">Cancel</a>
              <button class="btn btn-primary mb-sm-2 mb-0">Update</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('updateCategory');

    form.addEventListener('submit', function(event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
</script>
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById("previewImg").src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection