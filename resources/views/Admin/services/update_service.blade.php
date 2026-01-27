@extends('Admin.layouts.master')
@section('source', 'Service')
@section('page-title', 'Update Service')
@section('content')
    <div class="container-fluid py-4">
        {{-- <a href="{{ url()->previous() }}">
                    <p class="bi bi-arrow-left">Back</p>
            </a> --}}
        <div class="col-12">
            <div class="card mb-4">
                <div class="cards px-0 pt-0 pb-2">
                    <form action={{ route('admin.service.edit', $data->id) }} method="POST" enctype="multipart/form-data">
                    @csrf
                     <div class="row px-4">
                            <div class="col-md-7">
                                <!-- Left Column - Description -->
                                <div class="form-group">
                                    <label for="description" class="text-uppercase text-secondary  ">Description</label>
                                    <textarea type="text" name="description" id="description" class="form-control" rows="13" style="height:410px">{{ $data->description }}</textarea>
                                </div>
                                @error('description')
                                    <div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </span>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-5 ">


                                <div class="form-group">
                                    <label for="name" class="text-uppercase text-secondary  ">Name</label>
                                    <input type="text" name="name" id="meta_title" value="{{ $data->name }}"
                                        class="form-control" />
                                </div>
                                @error('name')
                                    <div>
                                        <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </span>
                                    </div>
                                @enderror
                                <div class="form-group text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    <label for="parent_id">Parent Service</label>
                                    <select name="parent_id" class="form-select">
                                        <option value="" selected hidden>{{$parent_name}}</option>
                                        @foreach($parent as $parent)
                                        <option value={{$parent->id}}>
                                            {{ $parent->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label for="slug" class="text-uppercase text-secondary">Slug</label>
                                    <input type="text" name="slug" id="slug"
                                        value="{{ old('slug', $data->slug ?? '') }}" class="form-control" />
                                </div>
                                @error('slug')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group">
                                    @if (isset($data->image) && $data->image)
                                        <img src="{{ asset('upload_image/' . $data->image) }}" width="50" height="50"
                                            style="object-fit: cover; border-radius: 10px;">
                                    @else
                                        No Image
                                    @endif
                                </div>
                                <div class="input-group mb-3 " style="max-width: 500px;">
                                    <label for="name"></label><br>
                                    <span class="input-group-text" id="basic-addon1"></span>
                                    <input type="file" name="image" accept=".jpg,.png,.jpeg" class="form-control"
                                        aria-label="image" aria-describedby="basic-addon1">
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
                                        value="1" {{ $data->status ? 'checked' : '' }}>
                                </div>
                                <div class="form-check form-switch">
                                    <label class="form-check-label text-uppercase text-secondary  "
                                        for="accept_leadSwitch">Accept Lead</label>
                                    <input class="form-check-input" type="checkbox" name="accept_lead"
                                        id="accept_leadSwitch" value="1" {{ $data->accept_lead ? 'checked' : '' }}>
                                </div>

                                <div class="input-group mb-3 ms-1 mt-2">
                                    <button type="submit" class="btn btn-secondary btn-sm">Save</button>
                                </div>

                            </div>
                        
                        </div>
                    </form>
                </div>
            </div>
        <div>
    </div>
@endsection
