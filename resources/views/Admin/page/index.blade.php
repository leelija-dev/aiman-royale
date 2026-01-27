{{-- @extends('Admin.layouts.master')
@section('source','CMS')
@section('page-title', 'Pages')
@section('title')
Leelija - Pages
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
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatable">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        SL.NO</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Page Title</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Service</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pages as $page)
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
                                            {{$page->meta_title}}
                                        </p>
                                    </td>

                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{$page->service->name}}
                                        </p>
                                    </td>

                                    @php
                                    $name = $page->status == 'active' ? 'Active' : 'Inactive';
                                    $classes = $page->status == 'active' ? 'bg-gradient-success' : 'bg-gradient-danger';
                                    @endphp
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm {{ $classes }}">
                                            {{$name}}
                                        </span>
                                    </td>


                                    <td class="align-middle text-center">
                                        <a href="{{ route('admin.page.edit-page',$page->page_id ?? 0)}}"
                                            class="text-secondary font-weight-bold text-xs"
                                            data-toggle="tooltip" data-original-title="Edit user">
                                            <i class="fa-solid fa-eye pe-4"></i>
                                        </a>
                                        {{-- <a href="#" onclick="event.preventDefault(); deletePage(<?= $page->page_id ?>);" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete user">
                                            <i class="fa-solid fa-trash"></i>
                                        </a> --}}
                                        <!-- <i class="fa-solid fa-trash text-secondary font-weight-bold text-xs" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $page->page_id }}" title="Delete">
                                        </i> -->

                                        <i class="fa-solid fa-trash text-secondary font-weight-bold text-xs"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $page->page_id }}"
                                            title="Delete">
                                        </i>

<div class="modal fade" id="deleteModal{{ $page->page_id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $page->page_id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $page->page_id}}">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                Are you sure you want to delete <strong>{{ $page->page_title }}</strong>?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>

                <form action="{{ route('admin.page.delete-page', $page->page_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>

        </div>
    </div>
</div>

                                        <!-- <div class="modal fade" id="deleteModal{{ $page->page_id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $page->page_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $page->page_id}}">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        Are you sure you want to delete <strong>{{ $page->page_title }}</strong> application details?
                                                    </div>

                                                    <div class="modal-footer">
                                                        {{-- <button type="reset" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                                                 --}}
                                                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>


                                                        <a href="{{route('admin.page.delete-page',$page->page_id)}}" class="btn btn-secondary">Delete</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div> -->
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
<!-- Bootstrap Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session("success") }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        showClass: {
            popup: ''
        },
        hideClass: {
            popup: ''
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
@endif
@endsection

@section('scripts')
<script>
    document.getElementById('addnewpage').addEventListener('click', function() {

        window.location.href = "{{ route('admin.page.add') }}";

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
            form.action = '/admin/cms/delete-page/' + id;
            form.submit();
        }
    }
</script> --}} --}}