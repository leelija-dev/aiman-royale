@extends('Admin.layouts.master')
@section('source', 'Users')
@section('page-title', 'Add User')
@section('title')
{{ config('app.name') }} - Add User

@endsection
@section('content')


<div id="create-page" class="mt-4 mx-3">
    <div class="col-12">
        <div class="card mb-4">
            {{-- <div class="card-header pb-0">

            </div> --}}
            <div class="card px-0 pt-0 pb-2">

                <form id="userForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row px-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-uppercase text-secondary  ">Username</label>
                                <input type="text" name="username" id="name" placeholder="Username"
                                     class="form-control " required/>
                            <div class="invalid-feedback">
                                Username can not be blank!
                            </div>
                           
                            @error('username')
                                <div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                </div>
                            @enderror
                             </div>

                            <div class="form-group">
                                <label for="email" class="text-uppercase text-secondary  ">Email</label>
                                <input type="text" name="email" id="email" placeholder="exmaple@gmail.com"
                                    class="form-control" required/>
                                <div class="invalid-feedback">
                                    Email can not be blank!
                                </div>

                                @error('email')
                                    <div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </span>
                                    </div>
                                @enderror
                            </div>

                            <div  class="form-group">
                                <label for="lname" class="text-uppercase text-secondary  ">Image</label>
                                <input type="file" name="image" accept=".jpg,.png,.jpeg" class="form-control" aria-label="image" aria-describedby="basic-addon1" >
                            </div>
                            
                            @error('image')
                                <div>
                                    <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                    <label for="fname" class="text-uppercase text-secondary  ">First Name</label>
                                    <input type="text" name="fname" id="fname" placeholder="Fast Name"
                                        class="form-control" required/>
                                <div class="invalid-feedback">
                                    First Name can not be blank!
                                </div>
                                @error('fname')
                                <div><span class="invalid-feedback d-block">{{$message}}</span></div>
                                @enderror
                            </div>
                            <div class="form-group">
                                    <label for="lname" class="text-uppercase text-secondary  ">Last Name</label>
                                    <input type="text" name="lname" id="lname" placeholder="Last Name"
                                        class="form-control" required/>
                                <div class="invalid-feedback">
                                    Last Name can not be blank!
                                </div>  
                                @error('lname')
                                <div><span class="invalid-feedback d-block">{{$message}}</span></div>
                                @enderror
                            </div>
                            <div class="form-group position-relative">
                                    <label for="service" class="text-uppercase text-secondary  ">Password</label>
                                    <input type="password" name="password" id="password" placeholder="password"
                                        class="form-control" required/>
                                        <!-- Eye Icon -->
                                    <span class="position-absolute" 
                                        style="right: 15px; top: 38px; cursor: pointer;" 
                                        onclick="togglePassword()">
                                        <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                    </span>
                                <div class="invalid-feedback">
                                    Password can not be blank!  
                                </div>
                            
                                @error('password')
                                    <div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </span>
                                    </div>
                             @enderror
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="description" class="text-uppercase text-secondary  ">Description</label>
                                <textarea type="text" name="description" id="description" placeholder="Description"
                                    class="form-control" ></textarea>
                        </div>
                        @error('description')
                        <div><span class="invalid-feedback d-block">{{$message}}</span></div>
                        @enderror

                        
                        <div class="col-md-12 mt-2">
                            <label class="mb-2 text-uppercase text-secondary  ">Assign Role</label>
                            <div class="row">
                                @foreach ($roles as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">

                                        <input type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->name }}"
                                            class="form-check-input"
                                            id="perm_{{ $permission->id }}" >

                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                        </label>
                                        
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>



                    

                        <div class="d-flex justify-content-end mt-2">
                            <a href="{{route('admin.users.show')}}" role="button" class="btn btn-danger btm-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary btm-sm ms-3">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script>
function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.getElementById("togglePasswordIcon");

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
(function () {
    'use strict'
    const form = document.getElementById('userForm');
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
})();
</script>



@endsection