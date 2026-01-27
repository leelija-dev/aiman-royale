@extends('Admin.layouts.master')
@section('source', 'FAQs')
@section('page-title', 'Add FAQs')
@section('content')

<div class="container-fluid py-4">
   
    <div class="col-12">
        <div class="card mb-4">
            <div class="cards p-4">
                
                    <form action="{{route('testimonial.edit',[$page->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                    
                                <div class="form-group">
                                    <label for="page" class="text-uppercase text-secondary  ">Pages Name</label>
                                        <select id="name" name="name" class="form-control" required>
                                            <option value="{{$page->name}}" hidden selected>{{$page->name}}</option>
                                                @foreach($data as $pages)
                                                    <option value="{{$pages->page_title}}">{{$pages->page_title}}</option>
                                                @endforeach
                                        </select>
                                </div>
                                @error('name')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                                
                                <div class="form-group">
                                    <label for="designation" class="text-uppercase text-secondary  ">Designation</label>
                                    <input class="form-control" id="designation" name="designation"  value="{{$page->designation}}" ></input>
                                </div>
                                @error('designation')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                                <div class="form-group">
                                    <label for="message" class="text-uppercase text-secondary  ">Message</label>
                                    <input class="form-control" id="message" name="message"   value="{{$page->message}}" required></input>
                                </div>
                                    @error('message')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                               
                                    <div class="d-flex content-center ms-2">
                                @if(isset($page->image) && $page->image)
                                    <img src="{{ asset('upload_image/' . $page->image) }}" width="100" height="100" style="object-fit: cover; border-radius: 10px;">
                                @else
                                    No Image
                                @endif
                            </div>
                                    <div class="form-group text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <label for="image">Image</label>
                                                <input type="file" name="image" accept=".jpg,.png,.jpeg" class="form-control"  aria-label="image" aria-describedby="basic-addon1">
                                    </div>
                                       
                                        @error('image')
                                                    <div>
                                                            <span class="invalid-feedback d-block" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                    </div>
                                        @enderror
                                    <div class="form-check form-switch">
                                    <label class="form-check-label text-uppercase text-secondary  " for="statusSwitch">Status</label>
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="status" 
                                        id="statusSwitch"
                                        value="1"
                                        {{ $page->status ? 'checked' : '' }}
                                         required>
                                </div>
                                @error('status')
                                <div class="alert alert-danger">{{$message}}</div>
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