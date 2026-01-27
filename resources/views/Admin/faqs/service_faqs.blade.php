{{-- @extends('Admin.layouts.master')
@section('source', 'FAQs')
@section('page-title', 'FAQs')
@section('content')
    <div class="container-fluid py-4 ">
        <div class="row">
            
            <div class="col-12">
                <div class="card mb-4"> --}}
                    {{-- <div class="card-header pb-0 d-flex justify-content-end"> 
                        
                        
                        <a href="{{ route('admin.add') }}"> 
                        <button class="btn btn-primary me-3"  >Add Faqs</button>
                        </a>
                    </div>  --}}
                    {{-- <div class="card px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 datatable">
                                <thead >
                                    
                                    <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">id</th>
                                    <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">Question</th>
                                    <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                                
                                </thead>
                                <tbody>
                                    @forelse($data as $service)
                                    <tr>
                                        <td class="text-center">{{$service->id}}</td>
                                        <td class="text-center">{{$service->question}}</td>
                                        <td class="text-center">
                                            <a href="{{route('faq.question-answer',['id'=>$service->id])}}">
                                            <i class="bi bi-eye "></i></a>
                                            <i class="bi bi-trash-fill text-secondary ms-2" role="button"
                                             data-bs-toggle="modal" data-bs-target="#deleteModal{{ $service->id }}" title="Delete">
                                            </i>
                                        </td>
                                        
                                            
                                    </tr>
                                    @empty
                                    <tr>no service exist</tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal{{ $service->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $service->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $service->id }}">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            Are you sure you want to delete <strong>{{ $service->service }}</strong>  details?
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('faq.delete-question', $service->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary">Delete</button>
                                            </form>
                                        </div>
                                         

                                    </div>
                                </div>
                            </div>
@endsection --}}
