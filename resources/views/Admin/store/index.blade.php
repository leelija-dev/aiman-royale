@extends('Admin.layouts.master')
@section('source', 'Store')
@section('page-title', 'Store')

@section('title')
{{ config('app.name') }} - Store
@endsection


@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('store.index') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50 ">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;"
                            placeholder="Search by name, gst ,phone ,email" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1"
                            style="height:40px;">Search</button>
                        <a href="{{ route('store.index') }}" class="btn btn-danger mb-sm-3 mb-1"
                            style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                    
                    <a href="{{ route('store.create') }}" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-plus"></i> Add New Store
                    </a>
                </div>
            </div>
            <div class="card px-4 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">GST Number</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Gst Percentage (For Products Sale)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Phone Number</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Address</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">State</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stores as $store)
                            <tr>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            
                                          {{$store->name ? $store->name : 'N/A'}}
                                            
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        {{$store->gst_number ? $store->gst_number : 'N/A'}}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        {{$store->gst_percentage ? $store->gst_percentage : 'N/A'}}%
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                       {{ $store->phone_number ? $store->phone_number : 'N/A' }}
                                            
                                        
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                       {{ $store->email ? $store->email : 'N/A' }}
                                        
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        
                                            
                                               {{ $store->address ? \Illuminate\Support\Str::limit($store->address, 15) : '' }}
                                            
                                        
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        
                                            {{$store->state ? $store->state : '' }}

                                    </div>
                                </td>
                               
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span
                                                class="badge {{ $store->is_active == '1' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $store->is_active == '1' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                           {{$store->created_at->format('d-m-Y h:i A') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('store.edit', $store->id ?? 0)}}" class="text-secondary font-weight-bold text-xs me-4"
                                        >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form id="delete-form-{{ $store->id }}"
                                        action="{{ route('store.delete', $store->id) }}" 
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="javascript:void(0);" onclick="confirmDelete({{ $store->id }})">
                                        <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">
                                    <p class="text-muted">No Store found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <div>
                        {{ $stores->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to recover this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

@endsection