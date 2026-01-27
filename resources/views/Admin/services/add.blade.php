@extends('Admin.layouts.master')
@section('source', 'Service')
@section('page-title', 'Add Service')
@section('content')

<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="cards p-4">
                <form action="{{route('admin.service.add')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <label for="text">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description" style="height:360px;" >{{old('description')}}</textarea>
                            </div>
                                @error('description')
                                        <div>
                                                <span class="invalid-feedback d-block" role="alert">
                                                    {{ $message }}
                                                </span>
                                            </div>
                                @enderror
                        </div>
                        <div class="col-md-5">  
                            <div class="form-group text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
                            </div>
                                @error('name')
                                <div>
                                 <span class="invalid-feedback d-block" role="alert"> {{ $message }}</span>
                                </div>
                                @enderror
                                <div class="form-group text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    <label for="slug">Slug (Optional)</label>
                                    <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug')}}">
                                </div>
                                @error('slug')
                                <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                                <div class="form-group text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    <label for="parent_id">Parent Service</label>
                                    <select name="parent_id" class="form-select">
                                        <option value="" selected hidden>Parent Service</option>
                                        @foreach($data as $parent)
                                        <option value={{$parent->id}}>
                                            {{ $parent->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    <label for="text">Image</label>
                                    <input type="file" name="image" accept=".jpg,.png,.jpeg" class="form-control" aria-label="image" aria-describedby="basic-addon1">
                                </div>
                            
                                @error('image')
                                    <div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </span>
                                    </div>
                                @enderror
                                <div class="form-check form-switch">
                                    <label class="form-check-label text-uppercase text-secondary  "
                                        for="statusSwitch">Status</label>
                                    <input class="form-check-input" type="checkbox" name="status" id="statusSwitch"
                                        value="1" {{ old('status') ? 'checked' : '' }}>
                                </div>
                                <div class="form-check form-switch">
                                    <label class="form-check-label text-uppercase text-secondary  "
                                        for="accept_leadSwitch">Accept Lead</label>
                                    <input class="form-check-input" type="checkbox" name="accept_lead"
                                        id="accept_leadSwitch" value="1" {{  old('accept_lead') ? 'checked' : '' }}>
                                </div>
                                
                                <button type="submit" class="btn btn-primary mb-0">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection