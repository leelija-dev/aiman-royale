@extends('Admin.layouts.master')
@section('source', 'Users')
@section('page-title', 'Edit User')
@section('title')
{{ config('app.name') }} - Edit User

@endsection

@section('content')


<div id="create-page" class="mt-4 mx-3">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">

            </div>
            <div class="px-0 pt-0 pb-2">

                <form action="{{ route('admin.users.update',$user->user_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row px-4">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="service" class="text-uppercase text-secondary  ">Username</label>
                                <input type="text" name="username" id="name" placeholder="Regular"
                                    value="{{$user['username'];}}" class="form-control" />
                            </div>
                            @error('username')
                                       <div>
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $message }}
                                            </span>
                                        </div>
                            @enderror

                            <div class="form-group">
                                <label for="service" class="text-uppercase text-secondary  ">Email</label>
                                <input type="text" name="email" id="email" placeholder="Regular"
                                    value="{{$user['email'];}}" class="form-control" />
                            </div>
                            @error('email')
                                       <div>
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $message }}
                                            </span>
                                        </div>
                            @enderror

                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="mb-2 text-uppercase text-secondary">Assign Role</label>
                            <div class="row">
                                @foreach ($roles as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">

                                        <input type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->name }}"
                                            class="form-check-input"
                                            id="perm_{{ $permission->id }}"
                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @error('permission')
                                       <div>
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $message }}
                                            </span>
                                        </div>
                            @enderror
                        </div>



                    </div>

                    <div class="d-flex justify-content-start mt-2 ms-4">
                        <a href="{{route('admin.users.show')}}" role="button" class="btn btn-secondary btm-sm ">Cancel</a>
                        <button type="submit" class="btn btn-primary btm-sm ms-3">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection