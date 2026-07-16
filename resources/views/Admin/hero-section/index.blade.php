@extends('Admin.layouts.master')
@section('source', 'Hero Section')
@section('page-title', 'Hero Section')

@section('title')
{{ config('app.name') }} - Hero Section
@endsection


@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('hero-section.index') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50 ">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;"
                            placeholder="Search by title, offer ,postion ,redirect url, description" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1"
                            style="height:40px;">Search</button>
                        <a href="{{ route('hero-section.index') }}" class="btn btn-danger mb-sm-3 mb-1"
                            style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                    
                    <a href="{{ route('hero-section.create') }}" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-plus"></i> Add New Hero Section
                    </a>
                </div>
            </div>
            <div class="card px-4 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Image</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Title</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Offer</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Position</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Description</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Redirct Link</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bannerDetails as $banner)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            
                                            @if($banner->image)
                                                <img src="{{ $banner->image }}" class="avatar avatar-sm me-3" alt="Banner">
                                            @else
                                                <span>No Image</span>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $banner->title ? \Illuminate\Support\Str::limit($banner->title) : '' }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $banner->offer ? $banner->offer : '0' }}%</h6>
                                            
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $banner->position ? ucfirst($banner->position) : 'N/A' }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">
                                               {{ $banner->short_description ? \Illuminate\Support\Str::limit($banner->short_description, 15) : '' }}
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{$banner->redirect_link ? \Illuminate\Support\Str::limit($banner->redirect_link, 15) : '' }}</h6>
                                           
                                        </div>
                                    </div>
                                </td>
                               
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span
                                                class="badge {{ $banner->is_active == '1' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $banner->is_active == '1' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                           {{$banner->created_at->format('d-m-Y h:i A') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('hero-section.edit', $banner->id ?? 0)}}" class="text-secondary font-weight-bold text-xs me-4"
                                        >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form id="delete-form-{{ $banner->id }}"
                                        action="{{ route('hero-section.delete', $banner->id) }}" 
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="javascript:void(0);" onclick="confirmDelete({{ $banner->id }})">
                                        <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">
                                    <p class="text-muted">No hero Section found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <div>
                        {{ $bannerDetails->links('pagination::bootstrap-5') }}
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