@extends('Admin.layouts.master')
@section('source', 'Unit')
@section('page-title', 'Unit')
@section('title')
    {{ config('app.name') }} - Unit

@endsection

@section('content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 px-3">
                    <div class="card-header pb-0 d-flex justify-content-end">
                        {{-- <h6>Pages</h6> --}}
                        <a href="{{ route('admin.add-unit') }}">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#addPageModal" id="addnewpage"> Add New Unit
                            </button>
                        </a>
                    </div>
                    <div class="px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-5">
                                            SL.NO
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">
                                            Unit Code</th>

                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">
                                            Unit Name</th>


                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>

                                    </tr>
                                </thead>
                                <tbody class="text-center ">
                                    @if ($units->isNotEmpty())
                                        @foreach ($units as $unit)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">

                                                        <div class="text-xs font-weight-bold ms-2">
                                                            {{ $loop->iteration }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-xs font-weight-bold mb-0">
                                                        {{ $unit->code }}
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="text-xs font-weight-bold mb-0">
                                                        {{ $unit->name }}
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('admin.unit.update', $unit->id) }}">
                                                       <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>

                                                    {{-- <form id="delete-form-{{ $unit->id }}" action="{{ route('unit.delete', $unit->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <a href="javascript:void(0);" onclick="confirmDelete({{ $unit->id }})"> 
                                                <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                            </a>
                                          </form>   --}}

                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center text-primary fw-bold">
                                            <td colspan="4">Unit not available!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            'use strict'

            // Select all forms that start with "userUpdateForm"
            const forms = document.querySelectorAll('form[id^="userUpdateForm"]');

            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>
    {{-- <script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be delete this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script> --}}



@endsection
