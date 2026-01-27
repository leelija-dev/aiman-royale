@extends('Admin.layouts.master')
@section('source', 'Products')
@section('page-title', 'Trashed Products')

@section('title')
    {{ config('app.name') }} - Trashed Products

@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">

                                <thead>
                                    <tr class="mt-4">
                                        <td
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            sl. No</td>
                                        <td
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Product Code</td>

                                        <td
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Product Name</td>
                                        
                                        <td
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Actions</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if($data->isNotEmpty())
                                    @foreach ($data as $product)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $product->sku }}</td>
                                            <td class="text-center">{{ $product->name }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Restore Form -->
                                                    <form action="{{ route('product.restore', $product->id) }}" method="POST"
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
                                                        data-bs-target="#deleteModal{{ $product->id }}"
                                                        title="Delete Permanently">
                                                        <i class="fas fa-trash"></i> Delete Permanently
                                                    </button>
                                                </div>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $product->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $product->id }}">Confirm
                                                                    Permanent Deletion</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to permanently delete
                                                                    <strong><br>{{ $product->name }}</strong>?</p>
                                                                {{-- <p class="text-danger">This will also delete all products associated with this brand.</p> --}}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <form
                                                                    action="{{ route('product.force-delete', $product->id) }}"
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
                                    <tr class="text-center">
                                        <td colspan="5">Trashed products not available! </td>
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
