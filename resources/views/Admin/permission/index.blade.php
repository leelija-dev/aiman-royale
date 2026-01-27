@extends('Admin.layouts.master')

@section('source', 'Permission')
@section('page-title', 'Permission')

@section('title')
{{config('app.name')}} - Permission
@endsection

@section('content')
<div class="container-fluid py-4 " >
    {{-- <div class="card mb-4"> --}}
        
            <div class="row ">
                
                <div class="col-md-7  order-md-1 order-2">
                    <div class="card">
                    <div class="table-responsive">
                        <table class="table table-borderless align-test-center ">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SL.NO</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Page Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $role->name }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        {{-- <a href="{{ route('admin.edit-permission', $role->id ?? 0) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                                            <i class="fa-solid fa-eye pe-4"></i>
                                        

                                        </a> --}}

                                        <a href="#"
                                            class="text-secondary font-weight-bold text-xs"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPermissionModal{{ $role->id }}"
                                            title="Edit ">
                                        <i class="fa-solid fa-eye pe-4"></i>
                                        </a>
                                        {{--start modal --}}
                                        <div class="modal fade" id="editPermissionModal{{ $role->id }}" tabindex="-1" aria-labelledby="editPermissionModalLabel{{ $role->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">

                                        <!-- Header -->
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPermissionModalLabel{{ $role->id }}">Update Permission</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <!-- Modal Body  -->
                                                
                                                    {{-- <div class="d-flex align-items-end gap-2 mb-1 ms-5"> --}}
                                                <form action="{{route('admin.permissions.update', $role->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body text-start">
                                                        <div class="form-group">
                                                            <label for="service" class="text-uppercase text-secondary">Permission</label>
                                                            <input type="text" name="name" id="name" placeholder="Regular"
                                                            value="{{$role['name'];}}" class="form-control"  required/>
                                                       
                                                        @error('name')
                                                            <div>
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    {{ $message }}
                                                                </span>
                                                            </div>
                                                        @enderror
                                                        </div>
                                                    </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                                                           
                                                           
                                                            <button type="submit" class="btn btn-secondary">Save</button>
                                                            
                                                        </div>   
                                                    </form>
                                                    
                                              
                                                </div>
                                             </div>
                                        </div>

                                        <a href="#" onclick="event.preventDefault(); deletePage({{ $role->id }});" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center fw-bold py-4">No data exists.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
                
                <div class="col-md-5 order-md-2 order-1 mb-md-0 mb-3">
                    <div class="card p-3">
                     <form action="/admin/permissions/create" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3  text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" >
                            <label for="name">PERMISSION</label>
                            <input type="text" name="name" id="name" placeholder="Regular" class="form-control" required/>
                        </div>
                        @error('name')
                             <div>
                                <span class="invalid-feedback d-block" role="alert">
                                    {{ $message }}
                                </span>
                            </div>
                        @enderror
                        <div class="form-group mb-0 pb-0 d-flex justify-content-end  gap-3">
                            {{-- <a href="" role="button" class="btn btn-secondary btn-sm me-3">RESET</a> --}}
                            <button type="reset" class="btn btn-secondary btn-sm mb-0">RESET</button>

                            <button type="submit" class="btn btn-primary btn-sm mb-0">ADD</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function deletePage(id) {
        if (confirm('Are you sure you want to delete this page?')) {
            var form = document.getElementById('delete-form');
            form.action = '/admin/permissions/delete-permission/' + id;
            form.submit();
        }
    }
</script>


<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
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
@endsection

