{{-- @extends('Admin.layouts.master')

@section('source', 'Email group')
@section('page-title', 'Send Email')
@section('content')

<div class="container-fluid py-4">

    <div class="row">
        <div class="col-12">
            <div class="card ">

                <form action="{{route('admin.send-mail-group')}}" method="POST">
                    @csrf --}}
                    {{-- <div class="card mt-3" > --}}

                    {{-- <div class="form-group ms-5 me-5">
                        <label for="mailSubject" class="text-uppercase text-secondary  ">Subject</label>
                        <input type="text" class="form-control" id="mailSubject" name="subject" required>


                        @error('subject')
                        <div>
                            <span class="invalid-feedback d-block" role="alert">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group  ms-5 me-5">
                        <label for="message" class="text-uppercase text-secondary  ">Message</label>
                        <textarea type="text" name="reply" id="reply" placeholder="Reply"
                            class="form-control" rows="12"></textarea>


                        @error('reply')
                        <div>
                            <span class="invalid-feedback d-block" role="alert">
                                {{ $message }}
                            </span>
                        </div>
                        @enderror



                        <button type="submit"
                            class="btn btn-secondary d-flex align-items-center justify-content-center mt-3  me-5"
                            style="height: 30px; width: 80px;">
                            send
                        </button>


                </form>

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

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<style>
    .ck-editor__editable_inline {
        min-height: 60px !important;
        max-height: 60px !important;
        overflow-y: auto;
    }
</style>
<!-- Load CKEditor 5 from CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#reply'), {

        })
        .then(editor => {
            editor.ui.view.editable.element.style.height = '40px';
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection --}}