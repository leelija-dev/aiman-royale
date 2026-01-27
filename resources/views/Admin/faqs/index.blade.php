{{-- 
@extends('Admin.layouts.master')
@section('source', 'FAQs')
@section('page-title', 'FAQs')
@section('content')
<div class="container-fluid py-4 ">
    <div class="row">
        
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-end"> 
                    
                    
                    <a href="{{ route('faq.add') }}"> 
                      <button class="btn btn-primary me-3"  >Add Faqs</button>
                    </a>
                </div> 
                <div class="card px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatable">
                            <thead >
                                
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">SL.No</th>
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">Service/Page</th>
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">Total FAQs</th>
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                            </thead>
                            <tbody>
                                @forelse($faqs as $faq)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$faq->page->meta_title}}</td>
                                    <td class="text-center"><a href="{{ route('faq.all-question',['page_id' => $faq->page_id]) }}">{{$faq->total}}</a></td>
                                    <td class="text-center">
                                        <a href="{{ route('faq.all-question',['page_id' => $faq->page_id]) }}">
                                        <i class="bi bi-eye"></i></a></td>

                                </tr>
                                @empty
                                <tr>
                                <td colspan="8" class="text-center text-prinary fw-bold py-4">
                                    No FAQs exists.
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

@endsection --}}