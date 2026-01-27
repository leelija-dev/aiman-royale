@extends('Admin.layouts.master')
@section('source', 'Shops')
@section('page-title', 'Trashed Shops')

@section('title')
    {{ config('app.name') }} - Trashed Shops
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                
                    <div class=" px-0 pt-0 pb-2">
                        <a class="btn btn-sm btn-primary ms-4 mt-4" href="{{ route('shops.index') }}">Back to List</a>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Shop 
                                            Id</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Shop Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Mobile Number</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Address</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                            Deleted At</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($shops->isNotEmpty())
                                    @foreach ($shops as $shop)
                                    <tr>
                                    <td class="text-center">{{ $shop->id }}</td>
                                    <td class="text-center">{{$shop->shop_name}}</td>
                                    <td class="text-center">{{$shop->mobile_number??'N/A'}}</td>
                                    <td class="text-center">{{$shop->shop_address ?? 'N/A'}}</td>
                                    <td class="text-center">{{$shop->deleted_at->format('d M, Y h:i A')}}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-start gap-2">
                                            <!-- Restore Form -->
                                            <form action="{{ route('shops.restore', $shop->id) }}" method="POST" class="d-inline">
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
                                                data-bs-target="#deleteModal{{ $shop->id }}"
                                                title="Delete Permanently">
                                                <i class="fas fa-trash"></i> Delete Permanently
                                            </button>
                                        </div>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal{{ $shop->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $shop->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $shop->id }}">Confirm Permanent Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to permanently delete <strong><br>{{ $shop->shop_name }}</strong><br>?</p>
                                                        {{-- <p class="text-danger">This will also delete all products associated with this brand.</p> --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('shops.force-delete', $shop->id) }}" method="POST" class="d-inline">
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
                                        <td colspan="7" class="text-center">Trashed shops not available!</td>
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
