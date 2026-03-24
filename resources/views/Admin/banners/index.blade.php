@extends('Admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Banners</h3>
                    <a href="{{ route('banners.create') }}" class="btn btn-primary float-right">
                        <i class="fas fa-plus"></i> Add Banner
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Type</th>
                                    <th>Filter</th>
                                    <th>Status</th>
                                    <th>Sort Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($banners))
                                @foreach($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>
                                        @if($banner->image)
                                        <img src="{{ asset('uploads/banners/' . $banner->image) }}"
                                            alt="{{ $banner->title }}"
                                            style="width: 100px; height: 60px; object-fit: cover;">
                                        @else
                                        <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $banner->title }}</td>
                                    <td>{{ $banner->subtitle ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $banner->type == 'main' ? 'primary' : 'info' }}">
                                            {{ ucfirst($banner->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $banner->filter }}</span>
                                    </td>
                                    <td>
                                        @if($banner->is_active)
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $banner->sort_order }}</td>
                                    <td>
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