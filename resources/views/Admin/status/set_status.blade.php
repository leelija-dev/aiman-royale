@extends('Admin.layouts.master')
@section('source', 'Status')
@section('page-title', 'Add Status')
@section('content')
<div class="container-fluid py-4">
    {{-- <a href="{{ url()->previous() }}">
                    <p class="bi bi-arrow-left">Back</p>
            </a> --}}
    <div class="col-12">
       <div class="row">
            <div class="col-md-7">
                <div class="card mb-4">
              
                    <table class="table  table-borderless text-center align-middle w-100 mb-0">
                        <thead style="font-family: Libertinus Math, sans-serif;">
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                STATUS ID
                            </th>
                                  
                           
                            <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                STATUS
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                ACTION
                            </th>
                            
                        </thead>
                        <tbody>
                        @forelse($data as $status)
                            <tr>
                                <td class="ms-2">{{$status->status_id}}</td>
                                <td  class="ms-2">{{$status->status}}</td>
                                <td class="align-middle text-center ">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $status->id }}" title="Edit"> 
                                        <i class="bi bi-pencil-square me-3" ></i>             
                                        </a>     
                                      
                                    <i class="bi bi-trash-fill text-secondary" role="button"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $status->id }}" title="Delete">
                                        </i>
                                </td>
                                </tr>  
                                            <div class="modal fade" id="editStatusModal{{ $status->id }}" tabindex="-1" aria-labelledby="editStatusModalLabel{{ $status->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                    <!-- Modal header -->
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editStatusModalLabel{{ $status->id }}">Update Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <!-- Modal form -->
                                                    
                                                    <form action="{{ route('admin.setup.status.update', $status->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $status->id }}" >

                                                        <div class="modal-body">
                                                            <div class="d-flex align-items-end gap-2 mb-1 ms-5">
                                                                <div class="form-group">
                                                                    <label for="status_id" class="text-uppercase text-secondary">Status Id</label>
                                                                    <input type="text" class="form-control" id="status_id" name="status_id" style="width: 50px;" value="{{ $status->status_id }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="status" class="text-uppercase text-secondary">Status</label>
                                                                    <input type="text" class="form-control" id="status_{{ $status->id }}" name="status" style="width: 150px;" value="{{ $status->status }}" required>
                                                                </div>
                                                            </div> 
                                                             <div class="d-flex align-items-end  mb-1 ms-5">
                                                            <div class="form-group">
                                                            @error('status_id', 'editStatus')
                                                                    <div style="width:100px">
                                                                        <span class="invalid-feedback d-block" >{{ $message }}</span>
                                                                    </div>
                                                            @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                @error('status', 'editStatus')
                                                                    <div style="width:200px">
                                                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                                                                        
                                                    </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                       <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                                                        
                                                        <button type="submit" class="btn btn-secondary">Save</button>
                                                        </div>
                                                    </form>
                                                  
                                                    </div>
                                                </div>
                                            </div>     {{--end modal --}}
                                <div class="modal fade" id="deleteModal{{ $status->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $status->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $status->id}}">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                Are you sure you want to delete <strong>{{ $status->status }}</strong> application details?
                                            </div>

                                            <div class="modal-footer">
                                                {{-- <button type="reset" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                                                 --}}
                                                 <button type="button" class="btn btn-outline-dark"  data-bs-dismiss="modal">Cancel</button>


                                                <a href="{{route('admin.setup.status.delete',$status->id)}}" class="btn btn-secondary">Delete</a>
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
                    <div class="col-md-5">
                        <div class="card p-3">
                            
                            <form action="{{ route('admin.setup.status.set') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-auto">
                                        <label for="status_id" class="form-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" >Status Id</label>
                                        <input type="text" class="form-control" id="status_id" name="status_id" style="width: 50px;" required >
                                    </div>
                                    

                                    <div class="col-auto">
                                        <label for="status" class="form-label text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" required>Status</label>
                                        <input type="text" class="form-control" id="status" name="status" style="width: 165px;" >
                                    </div>
                                    <div class="col-auto d-flex align-items-end ">
                                        <button type="submit" class="btn btn-secondary mb-0  ">Save</button>
                                    </div>
                                    @error('status_id')
                                          <div style="width:100px">
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $message }}
                                            </span>
                                            </div>
                                    @enderror
                                    @error('status')
                                        <div style="width:150px" >
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $message }}
                                            </span>
                                        </div>
                                    @enderror
                                </div>
                            </form>
                         
                        </div>
                    
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
@if ($errors->hasBag('editStatus') && $errors->editStatus->any())
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var myModal = new bootstrap.Modal(document.getElementById('editStatusModal{{ old('id') }}'));
    myModal.show();
  });
</script>
@endif
 @endsection

