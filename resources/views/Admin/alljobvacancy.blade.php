{{-- @extends('Admin.layouts.master')
@section('source', 'Careers')
@section('page-title', 'All Job Vacancy')
@section('content')
<div class="container py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-footer text-end">
                <a href="{{ route('jobvacancyform') }}">
                    <button class="btn btn-primary btn-sm">Add New Vacancy</button>
                </a>
            </div>
                     <div class="card px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatable">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Id</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                      Job Role</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Experience</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                      Location</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                       Skills</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                       Department</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                       Status</th>
                                       
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                        
                                        
                                </tr>

                            </thead>
              
                    <tbody class="text-center">
                        @forelse ($data as $user)
                            <tr>
                                <td class="text-center">
                                    {{ $user->id }}</td>
                                    
                                <td class="text-center">
                                    {{ $user->job_role }}</td>
                                    
                                <td class="text-center">{{ $user->exprience }}</td>
                                <td class="text-center" >{{ $user->location }}</td>
                                <td class="text-center">{{ $user->skills }}</td>
                                <td class="text-center">{{ $user->department }}</td>
                                <td class="text-center">{{ $user->status }}</td>
                                <td class="text-center ">
                                    <a href="{{ route('show-vacancy', $user->id) }}">
                                        <i class="bi bi-eye-fill me-2" title="Show Details"></i>
                                    </a>
                                
                                    <a href="{{ route('editvacancy', $user->id) }}">
                                        <i class="bi bi-pencil-square me-2" title="Edit"></i>
                                    </a>
                                
                                    <i class="bi bi-trash-fill text-secondary" role="button"
                                       data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}" title="Delete">
                                    </i>
                                </td>
                            </tr>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            Are you sure you want to delete <strong>{{ $user->job_role }}</strong> job's details?
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('deletevacancy', $user->id) }}" class="btn btn-secondary">Delete</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @empty
                            <td>
                            <h5 class="text-secondary">Data Not Exist</h5></td>
                            @endforelse
                    </tbody>
                </table>
            </div> 
        </div>
    </div> 
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
</div>

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
