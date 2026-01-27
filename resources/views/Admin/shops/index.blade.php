@extends('Admin.layouts.master')
@section('source', 'Shops')
@section('page-title', 'Shops')

@section('title')
{{config('app.name')}} - Shops

@endsection

@section('content')
<style>
    .pagi-na-ou nav{
        width: 100% !important;
    }
</style>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex flex-wrap flex-xl-nowrap justify-content-between align-items-center">
                    <div class="d-flex align-items-center flex-wrap w-100 w-xl-50">
                        {{-- <h4 class="card-title">Stock Management</h4> --}}
                        <form method="GET" action="{{route('shops.index')}}" class="col-12 d-flex w-100 ">
                            <div class="col-12 mb-2 d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                                <div class="w-100">
                                    <input type="text" name="search" class="form-control" placeholder="Search by product name"
                                        value="{{ request('search') }}">
                                </div>

                                <button type="submit" class="btn btn-primary  mb-0">Search</button>
                                <a href="{{ route('shops.index') }}" class="btn btn-danger mb-0">Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex gap-sm-3 mb-2 justify-content-end w-100 w-xl-50 flex-sm-nowrap flex-wrap gap-2">
                        <a href="{{ route('shops.trashed') }}" class="btn btn-outline-secondary w-100 w-md-auto mb-0">
                            <i class="fas fa-trash"></i> View Trashed Shops
                        </a>
                    
                        <a href="{{ route('shops.create') }}" class="btn btn-primary w-100 w-md-auto mb-0">
                            <i class="fas fa-plus"></i> Add New Shop
                        </a>
                    </div>
                </div>
                <div class=" px-3 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="shopsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Shop Id</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8">Shop Name</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8">Mobile</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8">Address</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8">Due Amount</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8">Created At</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($shops as $shop)
                                    <tr>
                                        <td class="text-center">{{$shop->id }}</td>
                                        <td>{{ $shop->shop_name }}</td>
                                        <td>{{ $shop->mobile_number ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($shop->shop_address, 30) }}</td>
                                        <td>{{ config('app.rupees')}}{{ number_format($shop->due_amount, 2) }}</td>
                                        <td>{{ $shop->created_at->format('d M, Y') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('shops.show', $shop->id) }}" 
                                                   class="btn btn-link text-primary p-1 me-3"
                                                   data-bs-toggle="tooltip" 
                                                   data-bs-original-title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('shops.edit', $shop->id) }}" 
                                                   class="btn btn-link text-info p-1 me-3"
                                                   data-bs-toggle="tooltip" 
                                                   data-bs-original-title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form id="delete-form-{{ $shop->id }}" action="{{ route('shops.destroy', $shop->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type="button" 
                                                        class="btn btn-link text-danger p-1 "
                                                        onclick="confirmDelete({{ $shop->id }})"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-original-title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Shops not available!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3 pagi-na-ou">
                        {{ $shops->links('pagination::bootstrap-5') }}
                    </div>
                
                
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form-' + id);
                if (form) {
                    form.submit();
                } else {
                    console.error('Delete form not found for ID:', id);
                    Swal.fire(
                        'Error!',
                        'Could not find the form to submit. Please try again.',
                        'error'
                    );
                }
            }
        });
    }
</script>
@endpush
@endsection
