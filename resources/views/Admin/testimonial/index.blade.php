@extends('Admin.layouts.master')
@section('source', 'FAQs')
@section('page-title', 'FAQs')
@section('content')
<div class="container-fluid py-4 ">
    <div class="row">
        
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-end"> 
                    
                    
                    <a href="{{ route('testimonial.add') }}"> 
                      <button class="btn btn-primary me-3"  >Add Testimonial</button>
                    </a>

                </div>
                 <div class="card px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatable">
                            <thead >
                                
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">Sl.No</th>
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">name</th>
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">Pages</th>
                               
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                            </thead>
                            <tbody>
                                @forelse($pageCounts as $testimonial)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$testimonial->name}}</td>
                                    <td class="text-center">
                                        <a href="{{route('testimonial.single',$testimonial->name)}}">{{$testimonial->total}}</a>
                                    </td>
                                    <td class="text-center"> 
                                        <a href="{{route('testimonial.single',$testimonial->name)}}">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                <td colspan="8" class="text-center text-prinary fw-bold py-4">
                                    No Testimonials exists.
                                </td>
                                </tr>
                                @endforelse
                              
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection