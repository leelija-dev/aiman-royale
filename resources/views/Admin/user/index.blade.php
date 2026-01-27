@extends('Admin.layouts.master')
@section('source', 'Users')
@section('page-title', 'Users')
@section('title')
    {{ config('app.name') }} - Users

@endsection

@section('content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-end">
                        {{-- <h6>Pages</h6> --}}
                        {{-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addPageModal"
                            id="addnewpage"> Add New Admin
                        </button> --}}
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th
                                            class=" text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            SL.NO
                                        </th>
                                        <th
                                            class=" text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            image</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">
                                            Name</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            email</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            username</th>

                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>

                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                {{-- <div class="d-flex px-2 py-1"> --}}

                                                <div class="text-xs font-weight-bold mb-0">
                                                    {{ $loop->iteration }}
                                                </div>
                                                {{-- </div> --}}
                                            </td>
                                            <td>
                                                <div>
                                                    <img src="{{ $user->image ? asset('upload_image/' . $user->image) : asset('images/icons/default-user.webp') }}" width="40"
                                                        height="40" class="rounded-circle none">
                                                </div>

                                            </td>

                                            <td>
                                                <div class="text-xs font-weight-bold mb-0">
                                                    {{ $user->fname }} {{ $user->lname }}
                                                </div>
                                            </td>

                                            <td>
                                                <div class="text-xs font-weight-bold mb-0">
                                                    {{ $user->email }}
                                                </div>

                                            </td>
                                            <td>
                                                <div class="text-xs font-weight-bold mb-0">

                                                    {{ $user->username }}
                                                </div>
                                            </td>


                                            <td class="align-middle text-center">
                                                {{-- <a href="{{ route('admin.users.edit',$user->user_id ?? 0)}}"
                                            class="text-secondary font-weight-bold text-xs"
                                            data-toggle="tooltip" data-original-title="Edit user">
                                            <i class="fa-solid fa-eye pe-4"></i>
                                        </a> --}}
                                                <a href="{{ route('admin.users.edit-password', $user->user_id) }}"><i
                                                        class="fa fa-edit"></i></a>

                                                {{-- <a href="#" class="text-secondary font-weight-bold text-xs ms-3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editStatusModal{{ $user->user_id }}" title="Edit user">
                                                    <i class="fa-solid fa-eye pe-4"></i>
                                                </a> --}}

                                                {{-- start modal --}}

                                                {{-- <div class="modal fade" id="editStatusModal{{ $user->user_id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="editStatusModalLabel{{ $user->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">

                                                            <!-- Header -->
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editStatusModalLabel{{ $user->user_id }}">Update
                                                                    User</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div> --}}

                                                <!-- Modal Body  -->

                                                {{-- <div class="d-flex align-items-end gap-2 mb-1 ms-5"> --}}
                                                {{-- @if ($errors->any())
                                                    <div class="alert alert-warning">
                                                        <strong>Validation failed:</strong>
                                                        Please check your input in the form.
                                                    </div>
                                                @endif --}}

                                                {{-- <form id="userUpdateForm{{ $user->user_id }}"
                                                                action="{{ route('admin.users.update', $user->user_id ?? 0) }}"
                                                                method="POST" enctype="multipart/form-data" novalidate>
                                                                @csrf
                                                                <div class="modal-body text-start">

                                                                    <!-- Row for Left and Right Columns -->
                                                                    <div class="row">

                                                                        <!-- Left Column -->
                                                                        <div class="col-md-6">
                                                                            <input type="hidden" name="user_id"
                                                                                value="{{ $user->user_id }}">

                                                                            <div class="form-group mb-3">
                                                                                <label
                                                                                    class="text-uppercase text-secondary">First
                                                                                    Name</label>
                                                                                <input type="text" name="fname"
                                                                                    id="fname" placeholder="First Name"
                                                                                    value="{{ $user->fname }}"
                                                                                    class="form-control" required />
                                                                                <div class="invalid-feedback">First name can
                                                                                    not be blank!</div>
                                                                                @error('fname')
                                                                                    <span
                                                                                        class="invalid-feedback d-block">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group mb-3">
                                                                                <label
                                                                                    class="text-uppercase text-secondary">Last
                                                                                    Name</label>
                                                                                <input type="text" name="lname"
                                                                                    id="lname" placeholder="Last Name"
                                                                                    value="{{ $user->lname }}"
                                                                                    class="form-control" required />
                                                                                <div class="invalid-feedback">Last name can
                                                                                    not be blank!</div>
                                                                                @error('lname')
                                                                                    <span
                                                                                        class="invalid-feedback d-block">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <div class="form-group mb-3">
                                                                                <label
                                                                                    class="text-uppercase text-secondary">Email</label>
                                                                                <input type="text" name="email"
                                                                                    id="email" placeholder="Email"
                                                                                    value="{{ $user->email }}"
                                                                                    class="form-control" required />
                                                                                <div class="invalid-feedback">Email can not
                                                                                    be blank!</div>
                                                                                @error('email')
                                                                                    <span
                                                                                        class="invalid-feedback d-block">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <!-- Right Column -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group mb-3">
                                                                                <label
                                                                                    class="text-uppercase text-secondary">Image</label>
                                                                                <input type="file" name="image"
                                                                                    accept=".jpg,.png,.jpeg"
                                                                                    class="form-control">
                                                                                @error('image')
                                                                                    <span
                                                                                        class="invalid-feedback d-block">{{ $message }}</span>
                                                                                @enderror
                                                                            </div> --}}

                                                {{-- <div class="form-group position-relative mb-3">
                                                            <label class="text-uppercase text-secondary">Password</label>
                                                            <input type="password" name="password" id="password_{{ $user->user_id }}"
                                                                placeholder="Password" class="form-control" />
                                                            <!-- Eye Icon -->
                                                            <span class="position-absolute" 
                                                                style="right: 15px; top: 38px; cursor: pointer;" 
                                                                onclick="togglePassword({{ $user->user_id }})">
                                                                <i class="fa fa-eye" id="togglePasswordIcon_{{ $user->user_id }}"></i>
                                                            </span>
                                                            @error('password')
                                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                            @enderror
                                                        </div> --}}

                                                {{-- <div class="form-group mb-3">
                                                                                <label
                                                                                    class="text-uppercase text-secondary">Description</label>
                                                                                <textarea name="description" id="description" placeholder="Description" class="form-control">{{ $user->description }}</textarea>
                                                                                @error('description')
                                                                                    <span
                                                                                        class="invalid-feedback d-block">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>


                                                                            <!-- Roles Section -->
                                                                            <label
                                                                                class="mb-2 text-uppercase text-secondary">Assign
                                                                                Role</label>
                                                                            <div class="row">
                                                                                @foreach ($roles as $permission)
                                                                                    @php
                                                                                        $rolePermissions = $user->roles
                                                                                            ->pluck('id')
                                                                                            ->toArray();
                                                                                    @endphp
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-check">
                                                                                            <input type="checkbox"
                                                                                                name="permissions[]"
                                                                                                value="{{ $permission->name }}"
                                                                                                class="form-check-input"
                                                                                                id="perm_{{ $permission->id }}"
                                                                                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label"
                                                                                                for="perm_{{ $permission->id }}">
                                                                                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                            </div>

                                                                        </div> --}}
                                                {{-- @endforeach --}}
                                                {{-- </div> --}}

                                                {{-- <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"
                                onclick="location.reload();">Close</button>
                            <button type="submit" class="btn btn-secondary">Save</button>
                        </div>
                    </div>
                    </form>




                </div>
            </div>
        </div>
 --}}

                                                {{-- <a href="#" onclick="event.preventDefault(); deletePage(< ?= $user->user_id ?>);" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete user">
                                            <i class="fa-solid fa-trash"></i>
                                        </a> --}}
                                                {{-- <i class="fa-solid fa-trash text-secondary font-weight-bold text-xs" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->user_id }}" title="Delete">
                                        </i> --}}


                                                {{-- <div class="modal fade" id="deleteModal{{ $user->user_id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->user_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $user->user_id}}">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                Are you sure you want to delete <strong>{{ $user->username }}</strong> application details?
                                            </div>

                                            <div class="modal-footer"> --}}
                                                {{-- <button type="reset" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                                                 --}}
                                                {{-- <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>


                                                <a href="" class="btn btn-secondary">Delete</a> 'admin.users.delete',$user->user_id --}}
                                                {{-- </div>
                                               
                                        </div>
                                    </div>
                                </div> --}}


                                            </td>


                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>



@endsection
@if ($errors->any())
    {{-- modal error handle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('editStatusModal{{ $user->user_id }}'));
            myModal.show();
        });
    </script>
@endif
@section('scripts')
    <script>
        document.getElementById('addnewpage').addEventListener('click', function() {

            window.location.href = "{{ route('admin.users.create') }}";

        });
    </script>


    {{-- <form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form> --}}

    {{-- <script>
    function deletePage(id) {
        if (confirm('Are you sure you want to delete this page?')) {
            var form = document.getElementById('delete-form');
            form.action = '/admin/users/delete/' + id;
            form.submit();
        }
    }
</script> --}}
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
        function togglePassword(userId) {
            const password = document.getElementById("password_" + userId);
            const icon = document.getElementById("togglePasswordIcon_" + userId);

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
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


@endsection
