@extends('Admin.layouts.master')
@section('source', 'Brands')
@section('page-title', ' Brand Details')

@section('title')
{{config('app.name')}} - Brand Details
@endsection
{{-- @section('title', 'View Brand: ' . $brand->name) --}}

@section('content')
    <div class="row w-100 px-3 mt-3 m-0 " >
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Brand Details</h4>
                    <div class="d-flex justify-content-start gap-2 flex-sm-nowrap flex-wrap">
                        <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn px-3 py-2  d-flex justify-content-center  mb-0 align-items-center gap-1 btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form id="delete-form-{{ $brand->id }}" 
                            action="{{ route('admin.brands.destroy', $brand->id) }}" 
                            method="POST" 
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="btn px-3 py-2 d-flex justify-content-center mb-0 align-items-center gap-1 btn-danger" 
                                    onclick="confirmDelete({{ $brand->id }})">
                                <i class="fas fa-trash"></i> Move to Trash
                            </button>
                        </form>
                        <a href="{{ route('admin.brands.index') }}" class="btn px-3 py-2  d-flex justify-content-center  mb-0 align-items-center gap-1 btn-light">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class=" overflow-visible mh-100 py-0 pb-3">
                    <div class="row mx-0">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">ID</th>
                                    <td>{{ $brand->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $brand->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $brand->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    {{-- <td>  {{ $brand->is_active ? 'Active' : 'Inactive' }}
                                        <span class="{{ $brand->is_active ? 'badge-success' : 'badge-danger' }}">
                                           
                                        </span> --}}
                                        <td>
                                        @if($brand->is_active)
                                        <span class="badge bg-success rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i> Active
                                        </span>
                                        @else
                                        <span class="badge bg-danger rounded-pill">
                                            <i class="fas fa-times-circle me-1"></i> Inactive
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $brand->created_at->format('d M, Y h:i A') }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Updated At</th>
                                    <td>{{ $brand->updated_at->format('d M, Y h:i A') }}</td>
                                </tr> --}}
                                @if($brand->deleted_at)
                                <tr>
                                    <th>Deleted At</th>
                                    <td>{{ $brand->deleted_at->format('d M, Y h:i A') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($brand->description)
                    <div class="row mt-4 mx-0">
                        <div class="col-12">
                            <h5>Description</h5>
                            <div class="border p-3 rounded-3 py-2">
                                {!! nl2br(e($brand->description)) !!}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row w-100 px-3 mt-3 m-0 mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Products in this Brand</h5>
                </div>
                <div class=" overflow-visible mh-100 py-0">
                    @if($brand->products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Product Code</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brand->products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                              
                                                    {{ $product->name }}
                                              
                                            </td>
                                            <td>{{ $product->sku ?? 'N/A' }}</td>
                                            <td>{{ number_format($product->price, 2) }}</td>
                                            <td>
                                                <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            Products not available for this brand!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->


<script>
function confirmDelete(brandId) {
    Swal.fire({
        title: "Are you sure?",
        text: "This brand will be moved to trash!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, move it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + brandId).submit();
        }
    });
}
</script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Done!',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@endsection
