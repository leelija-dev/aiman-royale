@extends('Admin.layouts.master')
@section('source', 'Occasions')
@section('page-title', ' Add Occasion')

@section('title')
{{config('app.name')}} - Add Occasion
@endsection

@section('content')
<div class="container-fluid py-4">
  <div class="card">
    <div class="card-body overflow-visible mh-100 py-3">
      <form id="occasionPost" action="{{ route('admin.occasions.store') }}" method="post" novalidate>
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Name <sup class="text-danger">*</sup></label>
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" required >
              <div class="invalid-feedback">Occasion name cannot be blank!</div>
            @error('name')
            <div >
              <span class="invalid-feedback d-block">{{ $message }}</span>
            </div>
            @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Slug <sup class="text-danger">*</sup></label>
              <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
              <div class="invalid-feedback">Slug cannot be blank!</div>
            @error('slug')
              <div>
                <span class="invalid-feedback d-block">{{ $message }}</span>
              </div>
            @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Parent Occasion</label>
              <select name="parent_id" class="form-control">
                <option value="">None (Root Occasion)</option>
                @if(isset($occasions) && $occasions->count() > 0)
                  @foreach($occasions as $occasion)
                    <option value="{{ $occasion->id }}" {{ old('parent_id') == $occasion->id ? 'selected' : '' }}>{{ $occasion->name }}</option>
                  @endforeach
                @endif
              </select>
              @error('parent_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Description</label>
              <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
              @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Status</label>
              <div class="form-check form-switch">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ (old('is_active', 1) == 1 || old('is_active', 1) === true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
              </div>
              @error('is_active')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-12 text-end">
              <a href="{{ route('admin.occasions.index') }}" class="btn btn-danger">Cancel</a>
              <button class="btn btn-primary">Save</button>
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
    const form = document.getElementById('occasionPost');
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
})();
</script>
@endsection
