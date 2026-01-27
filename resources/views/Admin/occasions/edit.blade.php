@extends('Admin.layouts.master')
@section('source', 'Occasions')
@section('page-title', ' Edit Occasion')

@section('title')
{{config('app.name')}} - Edit Occasion
@endsection

@section('content')
<div class="container-fluid py-4">
  <div class="card">
    <div class="card-body overflow-visible mh-100">
      <form id="updateOccasion" action="{{ route('admin.occasions.update', $occasion->id) }}" method="post" novalidate>
        @csrf
        @method('PUT')
        <div class="row">
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Name<sup class="text-danger">*</sup></label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $occasion->name) }}" required>
              <div class="invalid-feedback">Occasion name cannot be blank!</div>
              @error('name')
              <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Slug <sup class="text-danger">*</sup></label>
              <input type="text" name="slug" class="form-control" value="{{ old('slug', $occasion->slug) }}" required>
              <div class="invalid-feedback">Slug cannot be blank!</div>
              @error('slug')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Parent Occasion</label>
              <select name="parent_id" class="form-control">
                <option value="">None (Root Occasion)</option>
                @if(isset($occasions) && $occasions->count() > 0)
                  @foreach($occasions as $occ)
                    <option value="{{ $occ->id }}" {{ old('parent_id', $occasion->parent_id) == $occ->id ? 'selected' : '' }}>{{ $occ->name }}</option>
                  @endforeach
                @endif
              </select>
              @error('parent_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Description</label>
              <textarea name="description" rows="4" class="form-control">{{ old('description', $occasion->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Status</label>
              <div class="form-check form-switch">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ (old('is_active', $occasion->is_active) == 1 || old('is_active', $occasion->is_active) === true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
              </div>
              @error('is_active')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class=" d-flex justify-content-end gap-2 flex-sm-nowrap flex-wrap">
              <a href="{{ route('admin.occasions.index') }}" class="btn btn-danger mb-sm-2 mb-0">Cancel</a>
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
    const form = document.getElementById('updateOccasion');

    form.addEventListener('submit', function(event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
</script>
@endsection
