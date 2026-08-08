@extends('Admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Banner</h3>
                    <a href="{{ route('banners.index') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $banner->title) }}" required>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                        id="subtitle" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}">
                                    @error('subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        id="description" name="description" rows="3">{{ old('description', $banner->description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Allowed: jpeg, png, jpg, gif, svg (Max: 2MB)</small>
                                    @if($banner->image)
                                    <div class="mt-2">
                                        <small class="text-muted">Current Image:</small>

                                        @php
                                        $imageUrl = $banner->image;
                                        $isCloudinary = str_contains($imageUrl, 'cloudinary.com');
                                        $isFullUrl = filter_var($imageUrl, FILTER_VALIDATE_URL);
                                        @endphp

                                        <img src="{{ $isCloudinary || $isFullUrl ? $imageUrl : asset('uploads/banners/' . $imageUrl) }}"
                                            alt="{{ $banner->title }}"
                                            style="width: 100px; height: 60px; object-fit: cover; display: block; margin-top: 5px;">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discount">Discount Code</label>
                                    <input type="text" class="form-control @error('discount') is-invalid @enderror"
                                        id="discount" name="discount" value="{{ old('discount', $banner->discount) }}">
                                    @error('discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="button_text" class="form-label">Button Text</label>
                                        <input type="text" class="form-control @error('button_text') is-invalid @enderror" id="button_text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" required>
                                        @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="type" class="form-label">Banner Type</label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                            <option value="main" {{ old('type', $banner->type) == 'main' ? 'selected' : '' }}>Main Banner (Large carousel)</option>
                                            <option value="secondary" {{ old('type', $banner->type) == 'secondary' ? 'selected' : '' }}>Secondary Banner (Small carousel)</option>
                                            <option value="editor" {{ old('type', $banner->type) == 'editor' ? 'selected' : '' }}>Editor Banner</option>
                                        </select>
                                        @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="filter_type">Filter Type</label>
                                    <select class="form-select @error('filter_type') is-invalid @enderror" id="filter_type" name="filter_type" onchange="toggleFilterFields()">
                                        <option value="single" {{ old('filter_type', $banner->filter_type ?? 'single') == 'single' ? 'selected' : '' }}>Single Filter</option>
                                        <option value="multiple" {{ old('filter_type', $banner->filter_type) == 'multiple' ? 'selected' : '' }}>Multiple Filters</option>
                                        <option value="discount" {{ old('filter_type', $banner->filter_type) == 'discount' ? 'selected' : '' }}>Discount Percentage</option>
                                        <option value="category" {{ old('filter_type', $banner->filter_type) == 'category' ? 'selected' : '' }}>Category Filter</option>
                                    </select>
                                    @error('filter_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group" id="single_filter_group">
                                    <label for="filter">Single Filter</label>
                                    <input type="text" class="form-control @error('filter') is-invalid @enderror"
                                        id="filter" name="filter" value="{{ old('filter', $banner->filter) }}">
                                    @error('filter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">This will be used as URL parameter (e.g., autumn, summer, etc.)</small>
                                </div>

                                <div class="form-group" id="multiple_filters_group" style="display: none;">
                                    <label>Multiple Filters</label>
                                    <div id="multiple_filters_container">
                                        @if($banner->filters && is_array($banner->filters))
                                        @foreach($banner->filters as $index => $filter)
                                        <div class="filter-item mb-2">
                                            <div class="input-group">
                                                <select class="form-select filter-type-select" name="filter_types[]">
                                                    <option value="discount" {{ $filter['type'] == 'discount' ? 'selected' : '' }}>Discount</option>
                                                    <option value="category" {{ $filter['type'] == 'category' ? 'selected' : '' }}>Category</option>
                                                    <option value="color" {{ $filter['type'] == 'color' ? 'selected' : '' }}>Color</option>
                                                    <option value="size" {{ $filter['type'] == 'size' ? 'selected' : '' }}>Size</option>
                                                    <option value="occasion" {{ $filter['type'] == 'occasion' ? 'selected' : '' }}>Occasion</option>
                                                    <option value="price_range" {{ $filter['type'] == 'price_range' ? 'selected' : '' }}>Price Range</option>
                                                </select>
                                                <input type="text" class="form-control filter-value" name="filter_values[]" value="{{ $filter['value'] }}" placeholder="Value">
                                                <button type="button" class="btn btn-danger remove-filter">×</button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @elseif(old('filter_types'))
                                        @foreach(old('filter_types') as $index => $type)
                                        <div class="filter-item mb-2">
                                            <div class="input-group">
                                                <select class="form-select filter-type-select" name="filter_types[]">
                                                    <option value="discount" {{ $type == 'discount' ? 'selected' : '' }}>Discount</option>
                                                    <option value="category" {{ $type == 'category' ? 'selected' : '' }}>Category</option>
                                                    <option value="color" {{ $type == 'color' ? 'selected' : '' }}>Color</option>
                                                    <option value="size" {{ $type == 'size' ? 'selected' : '' }}>Size</option>
                                                    <option value="occasion" {{ $type == 'occasion' ? 'selected' : '' }}>Occasion</option>
                                                    <option value="price_range" {{ $type == 'price_range' ? 'selected' : '' }}>Price Range</option>
                                                </select>
                                                <input type="text" class="form-control filter-value" name="filter_values[]" value="{{ old('filter_values')[$index] ?? '' }}" placeholder="Value">
                                                <button type="button" class="btn btn-danger remove-filter">×</button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="filter-item mb-2">
                                            <div class="input-group">
                                                <select class="form-select filter-type-select" name="filter_types[]">
                                                    <option value="discount">Discount</option>
                                                    <option value="category">Category</option>
                                                    <option value="color">Color</option>
                                                    <option value="size">Size</option>
                                                    <option value="occasion">Occasion</option>
                                                    <option value="price_range">Price Range</option>
                                                </select>
                                                <input type="text" class="form-control filter-value" name="filter_values[]" placeholder="Value">
                                                <button type="button" class="btn btn-danger remove-filter">×</button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addFilterField()">+ Add Filter</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_order">Sort Order</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                        id="sort_order" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0">
                                    @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_active">Status</label>
                                    <div class="form-check">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror"
                                            id="is_active" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                    @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Banner
                            </button>
                            <a href="{{ route('banners.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function toggleFilterFields() {
        const filterType = document.getElementById('filter_type').value;
        const singleGroup = document.getElementById('single_filter_group');
        const multipleGroup = document.getElementById('multiple_filters_group');

        if (filterType === 'multiple') {
            singleGroup.style.display = 'none';
            multipleGroup.style.display = 'block';
        } else {
            singleGroup.style.display = 'block';
            multipleGroup.style.display = 'none';
        }
    }

    function addFilterField() {
        const container = document.getElementById('multiple_filters_container');
        const newFilterItem = document.createElement('div');
        newFilterItem.className = 'filter-item mb-2';
        newFilterItem.innerHTML = `
        <div class="input-group">
            <select class="form-select filter-type-select" name="filter_types[]">
                <option value="discount">Discount</option>
                <option value="category">Category</option>
                <option value="color">Color</option>
                <option value="size">Size</option>
                <option value="occasion">Occasion</option>
                <option value="price_range">Price Range</option>
            </select>
            <input type="text" class="form-control filter-value" name="filter_values[]" placeholder="Value">
            <button type="button" class="btn btn-danger remove-filter" onclick="removeFilterField(this)">×</button>
        </div>
    `;
        container.appendChild(newFilterItem);
    }

    function removeFilterField(button) {
        button.closest('.filter-item').remove();
    }

    // Handle remove filter button clicks
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-filter')) {
            removeFilterField(e.target);
        }
    });

    // Initialize filter fields on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleFilterFields();
    });
</script>
@endsection