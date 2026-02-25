@extends('Admin.layouts.master')
@section('source', 'News Letter')
@section('page-title', 'All News Letter')
@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-end">
                    <a href=" ">
                      <button class="btn btn-primary me-3"  >Add news letter </button>
                    </a>
                </div>
                <div class="card-body px-47 pt-2 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatable">
                            <thead>
                                <tr>
                                    <th
                                        class=" text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Id</th>
                                        <th
                                        class=" text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email</th>
                                        
                                        <th
                                        class=" text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                         Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->count()>0)
                            @foreach($data as $newsletter)
                                <tr >
                                    
                                <td class="position-relative text-center">
                                    

                                   
                                    {{ $loop->iteration }}  
                                </td>
                                <td class="position-relative text-center">
                                    <div class="d-flex  flex-column  justify-content-center">
                                            {{$newsletter->email}}
                                    </div>
                                </td>
                                
                                <td class="position-relative text-center">
                                    <div class="d-flex  flex-column  justify-content-center">
                                            {{$newsletter->created_at->format('d M, Y h:i A') }}
                                    </div>
                                </td>
                                
                             </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="3" class="text-center">No news letter found!</td>
                            </tr>
                            @endif
                    </tbody>
                        </table>     

                        <div class="mt-4">
                            {{ $data->links('pagination::bootstrap-5') }}
                        </div>
            </div>
            
        </div>
    </div>
</div>

@endsection