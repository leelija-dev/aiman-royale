@extends('Admin.layouts.master')
@section('source', 'Hero Section')
@section('page-title', 'Edit Hero Section')

@section('title')
    {{ config('app.name') }} - Hero Section
@endsection
<style>
    .hr-line {
        border-top: 2px solid #0408382d !important;
        opacity: 1 !important;
    }
</style>
@section('content')
    <div class="container-fluid py-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header px-5 pb-0">
                    <h6>Edit hero section</h6>
                </div>
                <div class="card px-5 pt-2 pb-3">
                    <form action="{{ route('hero-section.update', ['id' => $hero->id]) }}" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Design Number -->
                                <div class="mb-3">
                                    <label for="design_no" class="form-label">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ $hero->title ?? '' }}" required>
                                    @error('title')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Product Name -->
                                <div class="mb-3">
                                    <label for="offer" class="form-label">Offer </label>
                                    <input type="text" class="form-control" id="offer" name="offer"
                                        value="{{ $hero->offer ?? 0 }}" maxlength="200" required>
                                    @error('offer')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- slug -->
                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Short Description </label>
                                    <input type="text" class="form-control" id="short_description"
                                        name="short_description" value="{{ $hero->short_description ?? '' }}"
                                        maxlength="255">
                                    @error('short_description')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>




                                <!-- redirect link-->
                                <div class="mb-3">
                                    <label for="redirect_link" class="form-label">Redirect Link(for button)</label>
                                    <input type="text" class="form-control" id="redirect_link" name="redirect_link"
                                        value="{{ $hero->redirect_link }}">
                                    @error('redirect_link')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">

                                {{-- <div class="mb-3">
                                    <label for="position" class="form-label">Position <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="position" name="position">
                                        <option value="" hidden>Select Position</option>
                                        <option value="top" {{ $hero->position == 'top' ? 'selected' : '' }}>Top (↑)
                                        </option>
                                        <option value="bottom" {{ $hero->position == 'bottom' ? 'selected' : '' }}>Bottom
                                            (↓)
                                        </option>
                                        <option value="center" {{ $hero->position == 'center' ? 'selected' : '' }}>Center
                                            (↔)
                                        </option>
                                        <option value="left" {{ $hero->position == 'left' ? 'selected' : '' }}>Left (←)
                                        </option>
                                        <option value="right" {{ $hero->position == 'right' ? 'selected' : '' }}>Right (→)
                                        </option>
                                    </select>
                                    @error('position')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <!--  Image -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                         Desktop Banner Image (Aspect Ratio: 16:6) <span class="text-danger">*</span>
                                    </label>

                                    <input type="file" class="form-control" id="image" name="image"
                                        accept="image/*" onchange="previewImage(event)">

                                    @error('image')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror

                                    <small class="text-muted">Upload an image for the desktop hero section. Recommended aspect ratio: <strong>16:6</strong>.</small>

                                    <div class="mt-3">
                                        <img id="imagePreview" src="{{ $hero->image ?? '' }}" alt="Hero Image"
                                            style="width:200px; max-height:100px; border:1px solid #ddd; padding:5px; {{ empty($hero->image) ? 'display:none;' : '' }}">
                                    </div>
                                </div>
                                <!-- image for mobile screen -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                        Mobile Banner Image (Aspect Ratio 2:3 ) <span class="text-danger">*</span>
                                    </label>

                                    <input type="file" class="form-control" id="mobile_screen_image"
                                        name="mobile_screen_image" accept="image/*" onchange="previewMobileImage(event)">

                                        @error('mobile_screen_image')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror

                                        <small class="text-muted">
                                            Upload an image for the mobile hero section. Recommended aspect ratio:
                                            <strong>2:3</strong>.
                                        </small>
                                        <!-- Image Preview -->
                                        <div class="mt-2">
                                           <img id="mobileImagePreview"
     src="{{ $hero->mobile_screen_image ?? '' }}"
     alt="Image Preview"
     class="img-thumbnail"
     style="width:80px; height:120px; object-fit:cover; {{ empty($hero->mobile_screen_image) ? 'display:none;' : '' }}">
                                        </div>
                                </div>
                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="1"
                                            {{ old('status', $hero->status ?? '') == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $hero->status ?? '') == '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12 text-end">
                                <a href="{{ route('hero-section.index') }}" class="btn btn-danger">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Product
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        }
    </script> --}}
    <script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }

    function previewMobileImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('mobileImagePreview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>
@endsection
