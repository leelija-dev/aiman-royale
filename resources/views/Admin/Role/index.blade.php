@extends('Admin.layouts.master')
@section('source', 'Roles')
@section('page-title', 'Roles')
@section('title')
{{config('app.name')}} - Roles

@endsection

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-end">
                    {{-- <h6>Pages</h6> --}}
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                        data-target="#addPageModal" id="addnewpage"> Add New Page
                    </button>
                </div>
                <div class="card px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatable">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        SL.NO</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Page Name</th>
                                    <!-- <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Slug</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th> -->
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">

                                            <div class="d-flex flex-column justify-content-center">
                                                {{ $loop->iteration }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$role->name}}
                                        </p>
                                    </td>

                                   


                                    <td class="align-middle text-center">
                                      <a href="{{ route('admin.roles.edit-role',$role->id ?? 0)}}"
                                            class="text-secondary font-weight-bold text-xs"
                                            data-toggle="tooltip" data-original-title="Edit user">
                                            <i class="fa-solid fa-eye pe-4"></i>
                                        </a>
                                        {{-- <a href="#" onclick="event.preventDefault(); deletePage(< ?= $role->id ?>);" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete user">
                                            <i class="fa-solid fa-trash"></i>
                                        </a> --}}
                                        <i class="fa-solid fa-trash text-secondary font-weight-bold text-xs" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}" title="Delete">
                                        </i>

                                   
                                    <div class="modal fade" id="deleteModal{{ $role->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $role->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $role->id}}">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                Are you sure you want to delete <strong>{{ $role->name }}</strong> application details?
                                            </div>

                                            <div class="modal-footer">
                                                {{-- <button type="reset" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                                                 --}}
                                                 <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>


                                                <a href="" class="btn btn-secondary">Delete</a> {{-- {{route('admin.delete-role',$role->id)}}--}}
                                            </div>
                                               
                                        </div>
                                    </div>
                                </div>

                                    </td>
                                </tr>
                                 @empty
                                <tr>
                                <td colspan="8" class="text-center text-prinary fw-bold py-4">
                                    No data exists.
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

@section('scripts')
<script>
    document.getElementById('addnewpage').addEventListener('click', function() {

        window.location.href = "{{ route('admin.roles.create') }}";

    });
</script>
@endsection

{{-- <form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form> --}}

{{-- <script>
    function deletePage(id) {
        if (confirm('Are you sure you want to delete this page?')) {
            var form = document.getElementById('delete-form');
            form.action = '/admin/roles/delete-role/' + id;
            form.submit();
        }
    }
</script> --}}
