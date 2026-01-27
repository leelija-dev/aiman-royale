@extends('Admin.layouts.master')
@section('source', 'Service')
@section('page-title', 'Services')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-end">
                        <a href="{{ route('admin.add-service-form') }}">
                            <button class="btn btn-primary me-3">Add Services </button>
                        </a>
                    </div>
                    <div class="card px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Image
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Name
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Parent Service
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Description
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Accept lead
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>

                                </thead>
                               <tbody>
                                    @forelse($data as $service)
                                        <tr>
                                            <td>
                                                <div class="d-flex content-center ms-2">
                                                    @if (isset($service->image) && $service->image)
                                                        <img src="{{ asset('upload_image/' . $service->image) }}"
                                                            width="40" height="40"
                                                            style="object-fit: cover; border-radius: 10px;">
                                                    @else
                                                        No Image
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex  flex-column  justify-content-center">
                                                    {{ $service->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <span class="badge text-bg-info">
                                                        @php
                                                            $parentName = '0';
                                                            foreach ($data as $parent) {
                                                                if ($parent->id == $service->parent_id) {
                                                                    $parentName = $parent->name;
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        {{ $parentName }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex  justify-content-center">
                                                    {{ $service->description }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    @if($service->status == 1)
                                                        <span class="badge text-bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge text-bg-secondary text-white">Inctive</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex  justify-content-center">
                                                    {{ $service->accept_lead }}
                                                </div>
                                            </td>


                                            <td>
                                                <div class="d-flex  justify-content-evenly">
                                                    <a href="{{ route('admin.service.single', $service->id) }}">
                                                        <i class="bi bi-eye-fill" title="Show Details"></i>
                                                    </a>
                                                    <a href="{{ route('admin.service.update', $service->id) }}"
                                                        data-bs-toggle="tooltip" title="Edit">
                                                        <i class="bi bi-pencil"
                                                            style="font-size: 1rem; color: #0d6efd;"></i>
                                                    </a>
                                                    <i class="bi bi-trash-fill text-secondary" role="button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $service->id }}" title="Delete">
                                                    </i>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="deleteModal{{ $service->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $service->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $service->id }}">
                                                            Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        Are you sure you want to delete
                                                        <strong>{{ $service->name }}</strong> status details?
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-dark"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <a href="{{ route('admin.service.delete', $service->id) }}"
                                                            class="btn btn-secondary">Delete</a>
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
                            <!-- Bootstrap Toast Container -->
                            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
                                <div id="successToast" class="toast align-items-center text-bg-success border-0"
                                    role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            {{ session('success') }}
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                            data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>

                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            @if (session('success'))
                                <script>
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: '{{ session('success') }}',
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
