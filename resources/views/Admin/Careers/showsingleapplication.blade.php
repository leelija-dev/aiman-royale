{{-- @extends('Admin.layouts.master')
@section('source', 'Careers')
@section('page-title', 'Application Details')
@section('content') --}}



    {{-- <h4 class="mb-4 ms-4">Application Details</h4> --}}

    {{-- <div class="container">
        <form action="{{ route('admin.setup.status.add', $user->id) }}" method="POST">
                @csrf
                <label for="status" class="form-label text-uppercase text-secondary"><strong>Update  Application  Status</strong></label>
                <div class="d-flex align-items-end gap-4 mb-2 ms-1 ">
                    <div>
                        <select name="status" class="form-select " style="width: 150px;" required>
                            <option value="" hidden selected>select status</option>
                            @foreach($data as $status)
                               
                                <option value="{{ $status->status }}" >
                                    {{ $status->status_id }} - {{ $status->status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary mb-0 d-flex justify-content-center align-items-center" style="height: 40px; width:80px">Update</button>
                    </div>
                </div>
            </form>

    

        <!-- 2 Column Layout -->
        <div class="row mb-4" action="{{ route('single-application', $user->id) }}" method="POST">
            <!-- Left Column -->
            <div class="col-md-6" >
                <div class="card mb-3">
                    <div class="card-body" style="height:260px">  
                        <p><span style="color:black">Job Role:</span><span style="font-weight: 900;"> {{ $user->job_role }}</span></p>
                        <p><span style="color:black">Name: </span>{{ $user->name }}</p>
                        <p><span style="color:black">Mobile Number: </span> {{ $user->mobile_number }}</p>
                        
                        <p><span style="color:black">Email Address:</span> {{ $user->email }}</p>
                        
                        
                       
                       
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <div class="card mb-2">
                    <div class="card-body" style="height:260px">
                        <p><span style="color:black">Experience:</span> {{ $user->exprience }}</p>
                        <p><span style="color:black">Current CTC: </span>{{ $user->current_ctc }}</p>
                        <p><span style="color:black">Expected CTC:</span> {{ $user->expected_ctc }}</p>
                        
                        <p><span style="color:black">LinkedIn Profile:</span>{{ $user->linkedin_profile }}</p>
                       
                        <p ><span style="color:black"> Status:</span>{{$user->status}}</p>  
                    </div>
                </div>
            </div>
        </div>
        <div class="card  mb-2">
            <div class="card-body ">
                <h5 class="text-uppercase text-secondary">Cover Letter</h5><br>
                 {{ $user->cover_letter }}
            </div>
        </div>
        <!-- Resume Viewer -->
        <div class="card  mb-4  " >
    
        <h5 class="card-title ms-3 mt-3 text-uppercase text-secondary">Resume</h5>

        <div class="d-flex justify-content-center" style="background-color: white; padding: 0; margin: 0;">
            <iframe 
                src="{{ asset('Application_cv/' . $user->uploadcv) }}#toolbar=0&navpanes=0" 
                width="80%" 
                height="1060px" 
                style="border: none; outline: none; background-color: white;"
            ></iframe>
            
        </div>
        
   </div>

        <!-- Back Button -->
        <a href="{{ route('show-application') }}" class="btn btn-secondary btn-sm" style="height: 40px; width:100px">Back</a>

     
</div>

<!-- Bootstrap Toast Container -->
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
@endsection --}}
