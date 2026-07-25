@extends('Admin.layouts.master')
@section('source', 'Offers')
@section('page-title', 'Offers')

@section('title')
{{ config('app.name') }} - Offers
@endsection


@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('offer.index') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50 ">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;"
                            placeholder="Search by name, code type, remarks " value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1"
                            style="height:40px;">Search</button>
                        <a href="{{ route('offer.index') }}" class="btn btn-danger mb-sm-3 mb-1"
                            style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                    
                    <a href="{{ route('offer.create') }}" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-plus"></i> Add New Offer
                    </a>
                </div>
            </div>
            <div class="card px-4 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Sl. No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">offer Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Discount</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Apply On</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Start Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">End Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Duration</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Is Timer</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Created At</th>
                                
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offers as $offer)
                            <tr>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            
                                          {{$loop->iteration}}
                                            
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        {{$offer->name ? $offer->name : 'N/A'}}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        {{$offer->discount ? $offer->discount : 'N/A'}}%
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                       {{ $offer->apply_on ? $offer->apply_on : 'N/A' }}
                                            
                                        
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                       {{ \Carbon\Carbon::parse($offer->start_date)->format('d-m-Y h:i A') }}
                                        
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                      {{ \Carbon\Carbon::parse($offer->end_date)->format('d-m-Y h:i A') }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        
                                            {{$offer->duration ? $offer->duration : '' }} Day

                                    </div>
                                </td>
                                
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span
                                                class="badge {{ $offer->is_active == '1' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $offer->is_active == '1' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                               <td class="text-center">
                                    @if($offer->is_timer == '1')
                                        <span class="text-success fs-4">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    @else
                                        <span class="text-danger fs-4">
                                            <i class="fas fa-times-circle"></i>
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                           {{$offer->created_at->format('d-m-Y h:i A') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('offer.edit', $offer->id ?? 0)}}" class="text-secondary font-weight-bold text-xs me-4"
                                        >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form id="delete-form-{{ $offer->id }}"
                                        action="{{ route('offer.delete', $offer->id) }}" 
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="javascript:void(0);" onclick="confirmDelete({{ $offer->id }})">
                                        <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <p class="text-muted">No offer found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <div>
                        {{ $offers->links('pagination::bootstrap-5') }}
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