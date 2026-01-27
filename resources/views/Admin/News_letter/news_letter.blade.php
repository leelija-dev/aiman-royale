{{-- @extends('Admin.layouts.master')
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
                <div class="card-body px-0 pt-0 pb-2">
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
                                        Status</th>
                                        <th
                                        class=" text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                         Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $newsletter)
                                <tr class="{{ $newsletter->viewed ? '' : 'bg-light unviewed-row' }}" 
                                style="{{ $newsletter->viewed ? '' : 'bg-primary text-white p-3' }}">
                                    
                                <td class="position-relative text-center">
                                    

                                     @if(!$newsletter->viewed)
                                        <span class="badge bg-primary rounded-pill py-1 px-1 position-absolute start-0 top-50 translate-middle-y ms-1" style="font-size: 7px;">
                                        New
                                        </span>
                                    @endif
                                    {{ $loop->iteration }}  
                                </td>
                                <td class="position-relative text-center">
                                    <div class="d-flex  flex-column  justify-content-center">
                                            {{$newsletter->email}}
                                    </div>
                                </td>
                                <td class="position-relative text-center">
                                    <div class="d-flex  flex-column  justify-content-center">
                                            {{$newsletter->status}}
                                    </div>                            
                                </td>
                                <td class="position-relative text-center">
                                    <div class="d-flex  flex-column  justify-content-center">
                                            {{$newsletter->created_at->format('d-m-Y') }}
                                    </div>
                                </td>
                                <td class="position-relative text-center"> 
                                    <a href="{{ route('admin.show-Email', $newsletter->id) }}">
                                                <i class="bi bi-eye-fill me-2" title="Show Details"></i>
                                                
                                            </a>
                                </td>
                             </tr>
                            @endforeach
                    </tbody>
                        </table>     


            </div>
        </div>
    </div>
</div>

@endsection --}}