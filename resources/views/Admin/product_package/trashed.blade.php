@extends('Admin.layouts.master')
@section('source', 'Products Package')
@section('page-title', 'Trashed product package')

@section('title')
    {{ config('app.name') }} - Trashed Products Package
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class=" px-0 pt-0 pb-2">
                        <a class="btn btn-primary ms-3 mt-3" href="{{ route('admin.product-package.index') }}"><i class="fa-solid fa-left-long "></i> Back</a>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">

                                <thead>
                                    <tr class="mt-4">
                                        <th class=" text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            sl. No</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Package Type</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                           Date</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @if($packages->isNotEmpty())
                                    @foreach($packages as $package)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{$package->package_type}}</td>
                                            <td class="text-center">{{$package->created_at->format('d M, Y h:i A')}}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Restore Form -->
                                                    <form action="{{ route('admin.product-package.restore', $package->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn btn-success px-3 py-2 d-flex justify-content-center align-items-center gap-2"
                                                            title="Restore">
                                                            <i class="fas fa-trash-restore"></i> Restore
                                                        </button>
                                                    </form>

                                                    <!-- Delete Permanently Button (opens modal) -->
                                                    <button type="button"
                                                        class="btn btn-danger px-3 py-2 d-flex justify-content-center align-items-center gap-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $package->id }}"
                                                        title="Delete Permanently">
                                                        <i class="fas fa-trash"></i> Delete Permanently
                                                    </button>
                                                </div>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal{{ $package->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $package->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $package->id }}">Confirm
                                                                    Permanent Deletion</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to permanently delete
                                                                    <strong><br>{{ $package->package_type }}</strong>?</p>
                                                                {{-- <p class="text-danger">This will also delete all products associated with this brand.</p> --}}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <form
                                                                    action="{{ route('admin.product-package.force-delete', $package->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="fas fa-trash"></i> Delete Permanently
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center">Trashed product packages not available!</td>
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