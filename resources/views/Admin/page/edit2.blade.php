{{-- @extends('Admin.layouts.guest')
@section('content')
<div id="create-page">
    <form action="{{route('Admin.content-edit',$page->id)}}" method="POST">
    @csrf
        <div class="form-group">
            <label for="name">Page Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $page->name }}"required>
        </div>
        <div class="form-group">
            <label for="name">Page Type</label>
            <input type="text" class="form-control" id="page_type" name="page_type" value="{{ $page->page_type }}">
        </div>
        <div class="form-group">
            <label for="text">Page Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ $page->slug }}">
        </div>
        <div class="form-group">
            <label for="text">URL</label>
            <input type="text" class="form-control" id="url" name="url" value="{{ $page->url }}"required>
        </div>
        <div class="form-group">
            <label for="text">Page Status</label>
            <input type="boolean" class="form-control" id="status" name="status" value="{{ $page->status }}"required>
        </div>
        <div class="form-group">
            <label for="text">Page Description</label>
            <input type="text" class="form-control" id="description" name="description"value="{{ $page->description }}" >
        </div>
        <div class="form-group">
            <label for="text">Page Header</label>
            <input type="text" class="form-control" id="header" name="header"value="{{ $page->header }}" >
        </div>
        <div class="form-group">
            <label for="text">Used Layout</label>
            <input type="text" class="form-control" id="used_layout" name="used_layout" value="{{ $page->used_layout }}">
        </div>
    <button type="submit" class="btn btn-primary">Edit</button>
    <button type="cancel" class="btn btn-danger">Cancel</button>
    </form>
</div>
@endsection
 --}}
