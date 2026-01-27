@extends('Admin.layouts.master')
@section('source', 'FAQs')
@section('page-title', 'Add FAQs')
@section('content')

    <div class="container-fluid py-4">

        <div class="col-12">
            <div class="card mb-4">
                <div class="cards p-4">

                    <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="page_id" class="text-uppercase text-secondary  ">Pages Name</label>
                            <select id="page_id" name="page_id" class="form-control" required>
                                <option value="" hidden selected>select pages</option>
                                @foreach ($data as $page)
                                    <option value="{{ $page->page_id }}" {{old('page_id') == $page->page_id ? "selected" : "" }}>{{ $page->meta_title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('page_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="name" class="text-uppercase text-secondary  ">Customer Name</label>
                            <input class="form-control" id="name" name="name" placeholder="Customer Name.." value="{{old('name')}}"
                                required></input>
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="designation" class="text-uppercase text-secondary  ">Designation</label>
                            <input class="form-control" id="designation" name="designation" placeholder="Write Designation.." value="{{old('designation')}}" required></input>
                        </div>
                        @error('designation')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="message" class="text-uppercase text-secondary">Review</label>
                            <textarea class="form-control" id="message" name="message" placeholder="Write Review.." rows="4" required>{{old('message')}}</textarea>
                        </div>
                        @error('message')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            <label for="image">Image</label>
                            <input type="file" name="image" accept=".jpg,.png,.jpeg" class="form-control"
                                aria-label="image" aria-describedby="basic-addon1">
                        </div>

                        @error('image')
                            <div>
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </span>
                            </div>
                        @enderror
                        <div class="form-check form-switch">
                            <label class="form-check-label text-uppercase text-secondary  "
                                for="statusSwitch">Status</label>
                            <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" value="1"
                                required>
                        </div>
                        @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <button class="btn btn-primary" type="submit">submit</button>




                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <style>
    .ck-editor__editable_inline {
        min-height:150px !important;
        max-height:150px!important;
        overflow-y: auto;
    }
</style>
<!-- Load CKEditor 5 from CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
    ClassicEditor
        .create(document.querySelector('#answer'),{
            
        })
        .then(editor => {
            editor.ui.view.editable.element.style.height = '150px';
        })
        .catch(error => {
            console.error(error);
        });
    </script> --}}
@endsection
