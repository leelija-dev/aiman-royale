
 
 {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>   --}}

{{-- @extends('Admin.layouts.master')
@section('source', 'Careers')
@section('page-title', 'Add Job Vacancy')


@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="cards px-0 pt-0 pb-2">
                <form action="{{ route('admin.job') }}" method="POST" enctype="multipart/form-data">
                    @csrf  
             
                         <div class="row px-4">
                            <div class="col-md-6">

                                <div class="form-group" >
                                    <label for="description" class="text-uppercase text-secondary ">Job Description</label>
                                    <textarea type="text" name="description" id="description" placeholder="Enter job description"
                                            class="form-control" rows="13"  ></textarea>
                                 </div>
                                @error('description')
                                    
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    
                                @enderror
                            </div>
                       
                            
                        <!-- Right Column - All Input Fields -->
                        
                            
                              <div class="col-md-6">
                                <div class="form-group mt-1 ">
                                    <label for="job_role" class="text-uppercase text-secondary  ">Job Role</label>
                                    <input type="text" name="job_role" id="job_role" placeholder="Job Role"
                                        class="form-control" required/>
                                </div>
                                @error('status', 'editStatus')
                                    <div >
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    </div>
                                @enderror

                                <div class="form-group mt-1">
                                    <label for="exprience" class="text-uppercase text-secondary  ">Experience</label>
                                    <input type="text" name="exprience" id="exprience" placeholder="Experience"
                                        class="form-control" required/>
                                </div>
                                @error('exprience')
                                    <div >
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    </div>
                                @enderror

                                <div class="form-group mt-1 ">
                                    <label for="location" class="text-uppercase text-secondary  ">Location</label>
                                    <input type="text" name="location" id="location" placeholder="Location"
                                        class="form-control" required/>
                                </div>
                                @error('location')
                                    <div >
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    </div>
                                @enderror
                                <div class="form-group mt-1  ">
                                    <label for="skills" class="text-uppercase text-secondary  ">Skills</label>
                                    <select id="skills" name="skills[]" multiple="multiple" class="form-control select2" required>
                                        <option value="PHP">PHP</option>
                                        <option value="PYTHON">PYTHON</option>
                                        <option value="JAVA">JAVA</option>
                                        <option value="C">C</option>
                                        <option value="C++">C++</option>
                                    </select>
                                </div>
                                @error('skills')
                                    <div >
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    </div>
                                @enderror
                                <div class="form-group mt-1">
                                    <label for="department" class="text-uppercase text-secondary">Department</label>
                                    <select id="department" name="department" class="form-control" required>
                                        <option value="" hidden selected>Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->departments }}">{{ $department->departments }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('department')
                                    <div >
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    </div>
                                @enderror
                                <div class="form-group mt-1 ">
                                    <label for="stauts" class="text-uppercase text-secondary  ">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="" hidden selected>Select Status</option>
                                        <option value="active">Active</option>
                                        <option value="close">Close</option>
                                        <option value="draft">Draft</option>
                                    
                                    </select>
                                </div>
                                @error('status')
                                    <div >
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    </div>
                                @enderror
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                                </div>
                            </div>
                        
                         
                   
                        </div> 
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
</div>

<style>
    .ck-editor__editable_inline {
        min-height:415px !important;
        max-height:415px!important;
        overflow-y: auto;
    }
</style>
<!-- Load CKEditor 5 from CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
    ClassicEditor
        .create(document.querySelector('#description'),{
            
        })
        .then(editor => {
            editor.ui.view.editable.element.style.height = '435px';
        })
        .catch(error => {
            console.error(error);
        });



    $(document).ready(function () {
        $('#skills').select2({
            tags: true,
            placeholder: 'Select skills',
            width: '100%',
            tokenSeparators: [',']
        });
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



@endsection --}}


 

  
                
     