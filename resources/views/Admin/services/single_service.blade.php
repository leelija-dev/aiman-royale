
@extends('Admin.layouts.master')
@section('source', 'Service')
@section('page-title', 'Service Details')
@section('content')

<div class="container-fluid py-4">
    {{-- <a href="{{ route('admin.show_service') }}">
                    <p class="bi bi-arrow-left">Back</p>
            </a> --}}

    <div class="col-12">
        <div class="card mb-4">
           
                <div class="card-body" style="height:auto">
                    <div class="row ">
                        <!-- Left Side -->
                        <div class="col-md-8">
                            <div class="mb-2">
                                    <span class="text-dark fw-bold text-uppercase">Name:</span> {{ $data->name }}
                            </div>
                            <div class="mb-2">
                                    <span class="text-dark fw-bold text-uppercase">Slug:</span> {{ $data->slug }}
                            </div>
                            <div class="mb-2">
                                <span class="text-dark fw-bold text-uppercase">Status:</span>
                                @if($data->status == 1)
                                    <span class="badge text-bg-success text-white">Active</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactive</span>
                                @endif

                            </div>
                            <div class="mb-2">
                                <span class="text-dark fw-bold text-uppercase">Accept lead:</span>{{$data->accept_lead}}
                            </div>
                            
                            <div class="mb-2">
                                <span class="text-dark fw-bold text-uppercase">Description:</span> {{ $data->description }}
                            </div>
                        </div>
                        <!-- Right Side -->
                        <div class="col-md-4 ">
                            <div class="text-dark fw-bold text-uppercase">Date & Time : {{$data->created_at->format('d-m-Y h:i:s')}}</div>
                            <div >
                            @if(isset($data->image) && $data->image)
                                <img src="{{ asset('upload_image/' . $data->image) }}" width="200" height="200" style="object-fit: cover; border-radius: 10px;">
                            @else
                                <p>No Image</p>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>

   {{-- <a href="{{ route('admin.show_service') }}" class="btn btn-secondary btn-sm " style="height: 40px; width:100px">Back</a>

</div> --}} 
@endsection