{{-- @extends('Admin.layouts.master')
@section('source', 'Contact')
@section('page-title', 'Contacts')
@section('notification')
    <h6 class="text-sm font-weight-normal mb-1">
        You have {{ $zerocount ?? 0 }} new notifications.
    </h6>
@endsection
@section('title')
Leelija - Contacts

@endsection

@section('content')

<div class="container py-4 ">
    <div class="row">
        
        <div class="col-12">
            <div class="card mb-4"> --}}
                {{-- <div class="card-header pb-0 d-flex justify-content-end">
                    {{-- <h6>Services</h6> 
                    
                    <a href="{{ route('admin.contact') }}"> 
                      <button class="btn btn-primary me-3"  >Add Contact</button>
                    </a>
                </div> --}}
                {{-- <div class="card px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatable">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        SL.NO</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        First Name</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                       Last Name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Phone</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Services</th>
                                    
                                    <th 
                                         class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                        
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                        
                                        
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $contact)
                                <tr class="{{ $contact->viewed ? '' : 'bg-light unviewed-row' }}" 
                             style="{{ $contact->viewed ? '' : 'bg-primary text-white p-3' }}">
                            <td class="position-relative text-center">
                                    @if(!$contact->viewed)
                                        <span class="badge bg-primary rounded-pill py-1 px-1 position-absolute start-0 top-50 translate-middle-y ms-1" style="font-size: 7px;">
                                        New
                                        </span>
                                    @endif
                                    {{ $loop->iteration }}
                            </td>


                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$contact->f_name}}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$contact->l_name}}
                                        </p>
                                    </td>

                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$contact->email}}
                                        </p>
                                    </td>

                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$contact->phone}}
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$contact->services}}
                                        </p>
                                    </td>
                                   
                                    <td class="align-middle text-center"> --}}
                                        {{-- <p class="text-xs font-weight-bold mb-0">
                                            {{$contact->status}} --}}
                                        {{-- @switch($contact->status)
                                        @case('Rejected')
                                            <button class="btn btn-danger d-flex justify-content-center align-items-center ms-4" style="width: 80px; height:20px; "> {{$contact->status}}</button>
                                            @break
                                        @case("Selected")
                                            <button class="btn btn-primary d-flex justify-content-center align-items-center ms-4" style="width: 80px; height:20px;"> {{$contact->status}}</button>
                                            @break
                                        @case('Accept')
                                            <button class="btn btn-success d-flex justify-content-center align-items-center ms-4" style="width: 80px;height:20px; "> {{$contact->status}}</button>
                                            @break  
                                        @case('Pending')
                                        @case('pending')
                                            <button class="btn btn-warning d-flex justify-content-center align-items-center ms-4" style="width:80px ;height:20px;"> {{$contact->status}}</button>
                                            @break 
                                        @case('Processing')
                                            <button class="btn btn-info d-flex justify-content-center align-items-center ms-4" style="width: 80px; height:20px;">{{ $contact->status }}</button>

                                            @break 
                                        @default
                                            <button class="btn btn-secondary  d-flex justify-content-center align-items-center ms-4" style="width:80px ;height:20px; ">{{$contact->status}} </button>
                                            
                                    @endswitch
                                        </p>
                                    </td> --}}

                                    {{-- <td class="align-middle text-center">
                                     
                                        <a href="{{ route('admin.sendmail', $contact->id ?? 0) }}"
                                            class="btn btn-primary btn-sm mx-1 text-white">
                                           Send Mail
                                        </a> 

                                    </td> --}}
                                    {{-- <td class="align-middle text-center"> 
                                    <a href="{{ route('admin.show-contact', $contact->id) }}">
                                        <i class="bi bi-eye-fill me-2" title="Show Details"></i>
                                    </a> --}}

                                    {{-- <a href="{{ route('admin.show-contact', $contact->id) }}">
                                         <i class="fa-solid fa-eye text-secondary font-weight-bold text-xs me-2" title="View"></i>
                                    </a> --}}
                                 
                                    {{-- <td>
                                     <a href="{{ route('admin.edit_contact', $contact->id) }}" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil" style="font-size: 1rem; color: #0d6efd;"></i>
                                        </a>
                                    </td> --}}
                                    
                                    {{-- <i class="bi bi-trash-fill text-secondary" role="button"
                                       data-bs-toggle="modal" data-bs-target="#deleteModal{{ $contact->id }}" title="Delete">
                                    </i> --}}
                                    {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $contact->id }}">
                                      <i class="fa-solid fa-trash text-secondary font-weight-bold text-xs" title="Delete"></i>
                                    </a> --}}
                                {{-- </td>
                                     
                                
                                    
                                </tr>
                                <div class="modal fade" id="deleteModal{{ $contact->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $contact->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $contact->id }}">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            Are you sure you want to delete <strong>{{ $contact->f_name }}{{ $contact->l_name }}</strong> status details?
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.delete-contact', $contact->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary">Delete</button>
                                            </form>
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

{{-- @section('scripts') --}}
<!-- <script>
    document.getElementById('addnewpage').addEventListener('click', function() {

        window.location.href = "{ { route('admin.add-page') }}";

    });
</script> -->
{{-- @endsection --}}

{{-- <form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form> --}}

{{-- <script>
    function deletePage(id) {
        if (confirm('Are you sure you want to delete this page?')) {
            var form = document.getElementById('delete-form');
            form.action = '/admin/cms/delete-page/' + id;
            form.submit();
        }
    }
</script> --}}