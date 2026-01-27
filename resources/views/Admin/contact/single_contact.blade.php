{{-- @extends('Admin.layouts.master')
@section('source', 'contact')
@section('page-title', 'User contact')
@section('content')

<div class="container">
    <div class="row "> --}}
        <!-- Left side: Contact Details -->
        <div class="col-md-6 mt-2">
            {{-- <a href="{{ route('admin.contacts') }}"
                class="btn btn-secondary btn-sm ms-2 d-flex align-items-center justify-content-center"
                style="height: 30px; width: 80px;">
                Back
            </a> --}}
            {{-- <a href="{{ url()->previous() }}">
                    <p class="bi bi-arrow-left">Back</p>
            </a> --}}

            {{-- <div class="card mb-4 mt-2">
                    <div class="mb-2 ms-2 mt-3">
                            <span class="text-dark fw-bold">First Name:</span> {{ $data->f_name }}
                    </div>
                    <div class="mb-2 ms-2">
                        <span class="text-dark fw-bold text-uppercase">Last Name:</span>{{$data->l_name}}
                    </div>
                    <div class="mb-2 ms-2">
                        <span class="text-dark fw-bold text-uppercase">Email:</span>{{$data->email}}
                    </div>
                    <div class="mb-2 ms-2">
                        <span class="text-dark fw-bold text-uppercase">Phone:</span>{{$data->phone}}
                    </div>
                    <div class="mb-2 ms-2">
                        <span class="text-dark fw-bold text-uppercase">Services:</span> {{ $data->services }}
                    </div>
                       <div class="mb-2 ms-2">
                        <span class="text-dark fw-bold text-uppercase">Message:</span> {{ $data->message }}
                    </div>
                    <div class="mb-2 ms-2">
                        <span class="text-dark fw-bold text-uppercase">Status:</span> {{ $data->status }}
                    </div>
                     
                   
                </div>
                    
                
             <div class="row ">
                
                <div class="col-md-12 mt-2">
                   <div class="card mb-4 mt-2">
                       <div class="mb-2 ms-2 mt-3">
                            <span class="text-dark fw-bold text-uppercase">Subject:</span> {{$contact_reply ? $contact_reply->subject :'No Subject' }}
                             <span class="text-dark fw-bold ms-12"></span>{{$contact_reply ? $contact_reply->created_at->format('d-m-Y') :''}}
                        </div>
                        <div class="mb-2 ms-2">
                          <span class="text-dark fw-bold text-uppercase ">Reply:</span> {{$contact_reply ? $contact_reply->reply :'No Reply'}}
                        </div>
                         
                        
                    </div>
                </div>
        </div>

        </div>
    
       <!-- Right side: Reply Form -->
        <div class="col-6">
            <div class="mb-0 ms-12" >
                    <form action="{{ route('admin.update-contact', $data->id) }}" method="POST" style="display: flex; align-items: center; gap: 10px;">
                        @csrf
                        <select name="status" class="form-select" style="width: 150px;">
                            <option value="" hidden selected>update status</option>
                            @foreach($status_data as $status)
                                <option value="{{ $status->status }}">
                                    {{ $status->status_id }} - {{ $status->status }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-secondary  mt-3 align-middle text-center">
                            Update
                        </button>
                    
                     </form>
            </div>
          
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.sendmail.send', $data->id) }}" method="POST">
                    @csrf
                        <h6>Send Reply</h6>
                        {{-- <div class="card mt-3" > --}}
                                    {{-- <div class="form-group">
                                        <label for="mailSubject" class="text-uppercase">Subject</label>
                                        <input type="text" class="form-control" id="mailSubject" name="subject">
                                        @error('subject')
                                            <div>
                                                <span class="invalid-feedback d-block" role="alert">
                                                    {{ $message }}
                                                </span>
                                                </div>
                                            @enderror
                                    </div>
                                    <div class="form-group " >
                                        <label for="message" class="text-uppercase">Message</label>
                                        <textarea type="text" name="reply" id="reply" placeholder="Reply"
                                                class="form-control" rows="12" ></textarea>
                                                @error('reply')
                                            <div>
                                                <span class="invalid-feedback d-block" role="alert">
                                                    {{ $message }}
                                                </span>
                                                </div>
                                            @enderror
                                    </div>
                                
                            
                            
                                    <button type="submit" 
                                        class="btn btn-secondary d-flex align-items-center justify-content-end mt-3"
                                        style="height: 30px; width: 80px;">
                                        send
                                    </button>
                    </form>
                 
                </div>
            </div>
        </div>
        
    </div>
</div>
       <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div> --}}


{{-- <style>
    .ck-editor__editable_inline {
        min-height:60px !important;
        max-height:60px!important;
        overflow-y: auto;
    }
</style>
<!-- Load CKEditor 5 from CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
    ClassicEditor
        .create(document.querySelector('#reply'),{
            
        })
        .then(editor => {
            editor.ui.view.editable.element.style.height = '40px';
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        showClass: {
            popup: ''
        },
        hideClass: {
            popup: ''
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
@endif  

@endsection --}} --}}