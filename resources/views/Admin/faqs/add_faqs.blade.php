{{-- @extends('Admin.layouts.master')
@section('source', 'FAQs')
@section('page-title', 'Add FAQs')
@section('content')

<div class="container-fluid py-4">
   
    <div class="col-12">
        <div class="card mb-4">
            <div class="cards p-4">
                
                <form action="{{route('faq.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    <div class="form-group">
                        <label for="page_id" class="text-uppercase text-secondary">Pages</label>
                        <select id="page_id" name="page_id" class="form-control" required>
                            <option value="" hidden selected>select pages</option>
                                @foreach($page_title as $page)
                                    <option value="{{$page->page_id}}">{{$page->meta_title}}</option>
                                @endforeach
                        </select>
                    </div>
                    @error('page_id')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="form-group">
                        <label for="question" class="text-uppercase text-secondary">Question</label>
                        <input class="form-control" id="question" name="question" placeholder="Write Question.." required>
                    </div>
                    @error('question')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror

                    <div class="form-group">
                        <label for="answer" class="text-uppercase text-secondary">Answer</label>
                        <textarea type="text" name="answer" id="answer" placeholder="Write Answer..." class="form-control" rows="13"></textarea>
                    </div>
                    @error('answer')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror

                    <div class="form-check form-switch">
                        <label class="form-check-label text-uppercase text-secondary" for="statusSwitch">Status</label>
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="status" 
                            id="statusSwitch"
                            value="1"
                            {{ old('status') ? 'checked' : '' }}>
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

<!-- Summernote CSS & JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>

<style>
    .note-editor.note-frame .note-editing-area .note-editable {
        min-height: 150px !important;
        max-height: 150px !important;
        overflow-y: auto;
    }
</style>

<script>
    $(document).ready(function() {
        $('#answer').summernote({
            height: 150,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>
@endsection --}}
