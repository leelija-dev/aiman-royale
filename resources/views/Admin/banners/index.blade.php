@extends('Admin.layouts.master')
@section('source', 'Banners')
@section('title', 'Banners')
@section('page-title', 'Banners')
@section('content')
<div class="container-fluid mt-4 mb-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 >Banners</h3>
                    <a href="{{ route('banners.create') }}" class="btn btn-primary float-right">
                        <i class="fas fa-plus"></i> Add Banner
                    </a>
                </div>
                <div class="card px-4 py-4">
                    <div class="table-responsive">
                         <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Image</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Title</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Subtitle</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Type</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Filter</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Sort Order</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($banners))
                                @foreach($banners as $banner)
                                <tr>
                                    <td class="text-center">{{ $banner->id }}</td>
                                    <td class="text-center">

                                        @if($banner->image)
                                        @php
                                        $imageUrl = $banner->image;
                                        $isCloudinary = str_contains($imageUrl, 'cloudinary.com');
                                        $isFullUrl = filter_var($imageUrl, FILTER_VALIDATE_URL);
                                        @endphp
                                        <img src="{{ $isCloudinary || $isFullUrl ? $imageUrl : url('img/uploads/banners/' . $banner->image) }}"
                                            alt="{{ $banner->title }}"
                                            style="width: 100px; height: 60px; object-fit: cover;">
                                        @else
                                        <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $banner->title }}</td>
                                    <td class="text-center">{{ $banner->subtitle ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($banner->type === 'main')
                                        <span class="badge bg-primary">Main</span>
                                        @elseif($banner->type === 'secondary')
                                        <span class="badge bg-info">Secondary</span>
                                        @elseif($banner->type === 'editor')
                                        <span class="badge bg-success">Editor's Pick</span>
                                        @else
                                        <span class="badge bg-secondary">{{ ucfirst($banner->type) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $banner->filter }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($banner->is_active)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $banner->sort_order }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                @endforeach
                                @else
                                <tr>
                                    <td colspan="9" class="text-center">No banners found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection