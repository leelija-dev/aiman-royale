@extends('Admin.layouts.master')
@section('source', 'Status')
@section('page-title', 'Update Status')
@section('content')
<form action="{{route('admin.setup.status.update',$data->id)}}" method="POST" enctype="multipart/form-data" >
    @csrf
    <div class="d-flex align-items-end gap-2 mb-1 ms-5">
        <div class="form-group">
            <label for="text">Status Id</label>
            <input type="text" class="form-control" id="status_id"  name="status_id" style="width: 50px;" value={{$data->status_id}}>
        </div>
        @error('status_id')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        
        <div class="form-group">
            <label for="text">Status</label>
            <input type="text" class="form-control" id="status" name="status" style="width: 150px;" value={{$data->status}}>
        </div>
        @error('status')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
       <button type="submit" class="btn btn-secondary ms-5" >save</button>
       
    </div>
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