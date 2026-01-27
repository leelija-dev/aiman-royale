

{{-- <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
<link id="pagestyle" href="assets/css/soft-ui-dashboard.css" rel="stylesheet" /> --}}
{{-- @extends('Admin.layouts.master')
@section('source', 'Careers')
@section('page-title', 'Applications')
@section('content')
<div class="container-fluid py-4">
            
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                {{-- <div class="card-header pb-0 d-flex justify-content-end">--}}
                    {{-- <h6>All Application</h6> --}}
                   {{-- <a href="{{ route('application') }}">
                     <button class="btn btn-primary " >New Application</button>
                    </a>
                </div> --}}
                 {{-- <div class="card px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatable">
                            <thead>
                                <tr>
                                     <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ms-2">
                                        Sl.No</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">
                                        Name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      JOb Role</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Exprience</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                 
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                    
                                        
                                        
                                </tr>
                                    
                            
                    
                    </thead>
                    <tbody >
                                         
                        @forelse($data as $user)
                            
                           <tr class="{{ $user->viewed ? '' : 'bg-light unviewed-row' }}" 
                             style="{{ $user->viewed ? '' : 'bg-primary text-white p-3' }}">

                               <td class="position-relative text-center">
                                    @if(!$user->viewed)
                                        <span class="badge bg-primary rounded-pill py-1 px-1 position-absolute start-0 top-50 translate-middle-y ms-1" style="font-size: 7px;">
                                        New
                                        </span>
                                    @endif
                                    {{ $loop->iteration }}
                                            
                                            
                                </td>
                                <td class="text-center">{{ $user->name}}</td>
                                <td class="text-center">{{ $user->email}}</td>        
                                <td class="text-center">{{ $user->job_role}} </td>            
                                <td class="text-center"> {{ $user->exprience}}</td>      
                                <td class="text-center">   
                                    @switch($user->status)
                                        @case('Rejected')
                                            <button class="btn btn-danger d-flex justify-content-center align-items-center" style="width:80px ;height:30px   "> {{$user->status}}</button>
                                            @break
                                        @case("Selected")
                                            <button class="btn btn-primary d-flex justify-content-center align-items-center" style="width:80px ;height:30px  "> {{$user->status}}</button>
                                            @break
                                        @case('Accept')
                                            <button class="btn btn-success d-flex justify-content-center align-items-center ms-" style="width:80px ;height:30px  "> {{$user->status}}</button>
                                            @break  
                                        @case('Pending')
                                        @case('pending')
                                            <button class="btn btn-warning d-flex justify-content-center align-items-center" style="width:80px ;height:30px "> {{$user->status}}</button>
                                            @break 
                                        @case('Processing')
                                            <button class="btn btn-info d-flex justify-content-center align-items-center" style="width:80px ;height:30px  ">{{ $user->status }}</button>

                                            @break 
                                        @default
                                            <button class="btn btn-secondary  d-flex justify-content-center align-items-center" style="width:80px ;height:30px  ">{{$user->status}} </button>
                                            
                                    @endswitch
                                </td>

                                <td class="text-center"> --}}
                                    
                                    {{-- <a href="{{ route('single-application', $user->id) }}">
                                        <i class="bi bi-eye-fill me-2" title="Show Details"></i>
                                    </a> --}}
                                    {{-- <a href="{{ route('single-application', $user->id) }}">
                                        <i class="bi bi-eye-fill me-2" title="Show Details"></i>
                                        
                                    </a>
                                
                                
                                    
                                        
                                    <i class="bi bi-trash-fill text-secondary" role="button"
                                       data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}" title="Delete">
                                    </i>
                                        
                                </td>
                            </tr>
                            

                            
                            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            Are you sure you want to delete <strong>{{ $user->name }}</strong> status details?
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('deleteapplication', $user->id) }}" class="btn btn-secondary">Delete</a>
                                        </div>
                                         

                                    </div>
                                </div>
                            </div>
                            @empty
                                <tr>
                                <td colspan="8" class="text-center text-prinary fw-bold py-4">
                                    No data exists.
                                </td>
                                </tr>
                          @endforelse
                        </tbody>
                    </table>
                </div> 
            </div>
        </div> 
    </div> 
</div> --}} 

<!-- Bootstrap Toast Container -->
{{-- <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div> --}}

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
@endsection
