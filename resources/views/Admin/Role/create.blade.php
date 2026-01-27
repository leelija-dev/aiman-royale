@extends('Admin.layouts.master')
@section('source','Roles')
@section('page-title','Add Roles')
@section('title')
{{config('app.name')}} - Add Roles
@endsection
@section('content')


<div id="create-page" class="mt-4 mx-3">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">

            </div>
            <div class="card px-0 pt-0 pb-2">

                <form action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row px-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service" class="text-uppercase text-secondary" >Permission</label>
                                <input type="text" name="name" id="name" placeholder="Regular"
                                    class="form-control" />
                            </div>

                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="mb-2 text-uppercase text-secondary">Assign Permissions</label>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input" id="perm_{{ $permission->id }}">
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end mt-2 px-3">
                        <a href="{{route('admin.roles')}}" role="button" class="btn btn-secondary btm-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btm-sm ms-3">Add</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection