@extends('Admin.layouts.master')
@section('source', 'Customers')
@section('page-title', 'Customers')

@section('title')
    {{ config('app.name') }} - Customers
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                    <!-- Search Form -->
                    {{-- <form method="GET" action="#" class="mb-2 mb-md-0 d-flex w-100 w-lg-50 ">
                        <div
                            class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                            <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;"
                                placeholder="Search by customer name, email, or phone" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1"
                                style="height:40px;">Search</button>
                            <a href="{{ route('admin.products') }}" class="btn btn-danger mb-sm-3 mb-1"
                                style="height:40px;">Reset</a>
                        </div>
                    </form> --}}

                    <!-- Action Buttons -->
                    {{-- <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                        <a href="{{ route('admin.products-trashed') }}"
                            class="btn btn-outline-secondary w-100 w-sm-auto mb-sm-3 mb-1">
                            <i class="fas fa-trash"></i> View Trashed Products
                        </a>
                        <a href="{{ route('admin.add-product') }}" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                    </div> --}}
                </div>
                <div class="card-body px-4 pt-2 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                                    <th class="text-uppercase text-secondary   text-xxs font-weight-bolder opacity-7">Customer
                                        Name</th>
                                    <th class="text-uppercase text-secondary  text-center text-xxs font-weight-bolder opacity-7">Email
                                    </th>
                                    <th class="text-uppercase text-secondary  text-xxs font-weight-bolder opacity-7">Phone

                                    </th>
                                    <th class="text-uppercase text-secondary  text-xxs font-weight-bolder opacity-7">Date
                                        
                                    </th>
                                    <th class="text-uppercase text-secondary  text-xxs font-weight-bolder opacity-7">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $customer)
                                    <tr>
                                      
                                        <td class="text-center">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $customer->id ?? ''}}</h6>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex px-2 py-1 text-center ">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $customer->name ?? '' }}</h6>
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $customer->email ?? '' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center"> 
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $customer->phone ?? '' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center"> 
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $customer->created_at->format('d M, Y H:i A') ?? '' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        
                                      
                                        <td class="align-middle text-center">

                                            <form id="delete-form-{{ $customer->id }}"
                                                action="#" method="POST"
                                                style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="#" >{{-- onclick="confirmDelete({{ $customer->id }})"> --}}
                                                <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                            </a>
                                        </td>
                                    </tr>


                            
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-muted">No products found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{-- <div class="text-muted">
                            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
                        </div> --}}
                        <div>
                            {{ $data->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDelete(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                document.getElementById('delete-form-' + productId).submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Form validation for edit modals
            document.querySelectorAll('form[id^="editForm"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const productId = this.id.replace('editForm', '');
                    const designNo = document.getElementById('edit_design_no_' + productId);
                    const name = document.getElementById('edit_name_' + productId);
                    const categoryId = document.getElementById('edit_category_id_' + productId);
                    const price = document.getElementById('edit_price_' + productId);
                    const stock = document.getElementById('edit_stock_' + productId);
                    const status = document.getElementById('edit_status_' + productId);

                    let isValid = true;

                    // Reset validation states
                    this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove(
                        'is-invalid'));

                    // Validate required fields
                    if (!designNo.value.trim()) {
                        designNo.classList.add('is-invalid');
                        isValid = false;
                    }

                    if (!name.value.trim()) {
                        name.classList.add('is-invalid');
                        isValid = false;
                    }

                    if (!categoryId.value) {
                        categoryId.classList.add('is-invalid');
                        isValid = false;
                    }

                    if (!price.value || price.value < 0) {
                        price.classList.add('is-invalid');
                        isValid = false;
                    }

                    if (!stock.value || stock.value < 0) {
                        stock.classList.add('is-invalid');
                        isValid = false;
                    }

                    if (!status.value) {
                        status.classList.add('is-invalid');
                        isValid = false;
                    }

                    if (!isValid) {
                        e.preventDefault();
                        alert('Please fill in all required fields correctly.');
                    }
                });
            });
        });
    </script>
@endsection
