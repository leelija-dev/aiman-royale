{{-- @extends('Admin.layouts.guest')
@section('content')
<div id="create-page">
    <form action="{{ route('Admin.content-add') }}" method="POST">
    @csrf
        <div class="form-group">
            <label for="name">Page Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="text">Page Type</label>
            <input type="text" class="form-control" id="page_type" name="page_type" required>
        </div>
        <div class="form-group">
            <label for="text">Page Slug</label>
            <input type="text" class="form-control" id="slug" name="slug">
        </div>
        <div class="form-group">
            <label for="text">URL</label>
            <input type="text" class="form-control" id="url" name="url" required>
        </div>
        
        <div class="form-group">
            <label for="text">Page Status</label>
            <input type="boolean" class="form-control" id="status" name="status" required>
        </div>
        <div class="form-group">
            <label for="text">Page Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group">
            <label for="text">Page Header</label>
            <input type="text" class="form-control" id="header" name="header" required>
        </div>
        <div class="form-group">
            <label for="text">Used Layout</label>
            <input type="text" class="form-control" id="used_layout" name="used_layout" required>
        </div>
    <button type="submit" class="btn btn-primary">Add</button>
    <button type="cancel" class="btn btn-danger">Cancel</button>
    </form>
</div>
@endsection
 --}}
