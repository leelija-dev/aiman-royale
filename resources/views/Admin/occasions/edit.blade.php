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
            
            <!-- SEO Fields -->
            <hr class="my-4">
            <h5 class="text-secondary text-uppercase mb-3">SEO Details</h5>
            
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Meta Title</label>
              <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $occasion->meta_title) }}" maxlength="255">
              <small class="text-muted">SEO title for search engines (max 255 characters)</small>
              @error('meta_title')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Meta Description</label>
              <textarea name="meta_description" rows="3" class="form-control" maxlength="500">{{ old('meta_description', $occasion->meta_description) }}</textarea>
              <small class="text-muted">SEO description for search engines (max 500 characters)</small>
              @error('meta_description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Meta Keywords</label>
              <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $occasion->meta_keywords) }}" maxlength="255">
              <small class="text-muted">Comma-separated keywords for SEO</small>
              @error('meta_keywords')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Meta Tags</label>
              <input type="text" name="meta_tags" class="form-control" value="{{ old('meta_tags', $occasion->meta_tags) }}" maxlength="255">
              <small class="text-muted">Comma-separated tags for categorization</small>
              @error('meta_tags')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="mb-3">
              <label class="form-label text-secondary text-uppercase">Schema Markup</label>
              <textarea name="schema_markup" rows="8" class="form-control font-monospace" placeholder="Enter JSON-LD schema markup...">{{ old('schema_markup', $occasion->schema_markup) }}</textarea>
              <small class="text-muted">JSON-LD schema markup for structured data (optional)</small>
              @error('schema_markup')
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
