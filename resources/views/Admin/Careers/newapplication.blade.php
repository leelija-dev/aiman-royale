

{{-- <div id="create-page" class="mt-4 mx-3" style="max-height: 80vh; overflow-y: auto;"> --}}
{{-- @extends('Admin.layouts.master')
@section('source', 'Careers')
@section('page-title', 'Application ')
@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="cards px-0 pt-0 pb-2">

                <form action="{{route('user_application')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row px-4">
                     <div class="col-md-6">
                
                        <div class="form-group">
                            <label for="name" class="text-uppercase text-secondary  ">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value=""required>
                        </div>
                        @error('name')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="form-group">
                            <label for="mobile_number" class="text-uppercase text-secondary  ">Mobile No</label>
                        <input type="text" name="mobile_number" class="form-control" required/>
                        </div>
                        @error('mobile_number')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="form-group">
                            <label for="email" class="text-uppercase text-secondary  ">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        @error('email')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        
                        <div class="form-group">
                            <label for="job_role" class="text-uppercase text-secondary  ">Job Role</label>
                            <input type="text" class="form-control" id="job_role" name="job_role" required>
                        </div>
                        @error('job_role')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="form-group">
                            <label for="uploadcv" class="text-uppercase text-secondary  ">Upload CV</label>
                            <input type="file" name="uploadcv" accept='.pdf' class="form-control" id="upload_cv" placeholder="upload CV" required>
                        </div>
                        @error('uploadcv')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                     </div>
                    
                    
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="exprience" class="text-uppercase text-secondary  ">Exprience</label>
                            <input type="text" class="form-control" id="exprience"  name="exprience" required>
                        </div>
                        @error('exprience')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="form-group">
                            <label for="current_ctc" class="text-uppercase text-secondary  ">Current CTC</label>
                            <input type="number" class="form-control" id="current_ctc" name="current_ctc" required>
                        </div>
                        @error('current_ctc')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="form-group">
                            <label for="expected_ctc" class="text-uppercase text-secondary  ">Expected CTC</label>
                            <input type="number" class="form-control" id="expected_ctc" name="expected_ctc"required >
                        </div>
                        @error('expected_ctc')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <div class="form-group">
                            <label for="linkedin_profile" class="text-uppercase text-secondary  ">Linkedin Profile</label>
                            <input type="text" class="form-control" id="linkedin_profile" name="linkedin_profile" required>
                        </div>
                        @error('linkedin_profile')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        
                        <div class="form-group">
                            <label for="text" class="text-uppercase text-secondary  ">Cover Letter</label>
                            <textarea type="text" class="form-control" id="cover_letter" name="cover_letter" ></textarea>
                        </div>
                        @error('cover_letter')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary me-1">submit</button>
                        

                    
            </form>
            </div>
        </div>
    </div>
</div> --}}

      

{{-- </div> --}}

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session("success") }}',
        timer: 3000,
        showConfirmButton: false
    });
    </script>
@endif
@endsection --}}

