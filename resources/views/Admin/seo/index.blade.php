@extends('admin.layout.admin-layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">SEO Management</h4>
                </div>
                <div class="card-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="seoTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="categories-tab" data-toggle="tab" href="#categories" role="tab">
                                <i class="fas fa-folder"></i> Categories SEO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="products-tab" data-toggle="tab" href="#products" role="tab">
                                <i class="fas fa-box"></i> Products SEO
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="seoTabContent">
                        <!-- Categories Tab -->
                        <div class="tab-pane fade show active" id="categories" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped" id="categoriesTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Meta Title</th>
                                            <th>Meta Description</th>
                                            <th>Meta Keywords</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Categories will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Products Tab -->
                        <div class="tab-pane fade" id="products" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped" id="productsTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Meta Title</th>
                                            <th>Meta Description</th>
                                            <th>Meta Keywords</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Products will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SEO Edit Modal -->
<div class="modal fade" id="seoEditModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit SEO Data</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="seoEditForm">
                    <input type="hidden" id="seoId">
                    <input type="hidden" id="seoType">
                    
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" maxlength="255">
                        <small class="form-text text-muted">Recommended: 50-60 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea class="form-control" id="meta_description" rows="3" maxlength="500"></textarea>
                        <small class="form-text text-muted">Recommended: 150-160 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="meta_keyword">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keyword" maxlength="500">
                        <small class="form-text text-muted">Separate keywords with commas</small>
                    </div>

                    <div class="form-group">
                        <label for="meta_tags">Meta Tags</label>
                        <input type="text" class="form-control" id="meta_tags" maxlength="500">
                        <small class="form-text text-muted">Separate tags with commas</small>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-info btn-sm" id="generateSuggestions">
                            <i class="fas fa-magic"></i> Generate Suggestions
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveSeoData">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    let categoriesTable, productsTable;

    // Initialize Categories DataTable
    categoriesTable = $('#categoriesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/seo/categories',
            type: 'GET'
        },
        columns: [
            { data: 'name' },
            { data: 'meta_title' },
            { 
                data: 'meta_description',
                render: function(data) {
                    return data ? data.substring(0, 50) + '...' : '';
                }
            },
            { 
                data: 'meta_keyword',
                render: function(data) {
                    return data ? data.substring(0, 30) + '...' : '';
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary" onclick="editSeo('category', ${row.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                    `;
                }
            }
        ]
    });

    // Initialize Products DataTable
    productsTable = $('#productsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/seo/products',
            type: 'GET'
        },
        columns: [
            { data: 'name' },
            { data: 'meta_title' },
            { 
                data: 'meta_description',
                render: function(data) {
                    return data ? data.substring(0, 50) + '...' : '';
                }
            },
            { 
                data: 'meta_keyword',
                render: function(data) {
                    return data ? data.substring(0, 30) + '...' : '';
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary" onclick="editSeo('product', ${row.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                    `;
                }
            }
        ]
    });

    // Handle tab switching
    $('#seoTabs a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Edit SEO function
    window.editSeo = function(type, id) {
        $('#seoType').val(type);
        $('#seoId').val(id);
        
        // Load current data
        const url = type === 'category' ? '/admin/seo/categories' : '/admin/seo/products';
        
        // For simplicity, we'll just open the modal and let user edit
        $('#seoEditModal').modal('show');
    };

    // Save SEO data
    $('#saveSeoData').on('click', function() {
        const type = $('#seoType').val();
        const id = $('#seoId').val();
        const url = type === 'category' ? `/admin/seo/categories/${id}` : `/admin/seo/products/${id}`;
        
        const data = {
            meta_title: $('#meta_title').val(),
            meta_description: $('#meta_description').val(),
            meta_keyword: $('#meta_keyword').val(),
            meta_tags: $('#meta_tags').val()
        };

        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#seoEditModal').modal('hide');
                    alert('SEO data updated successfully!');
                    // Refresh the appropriate table
                    if (type === 'category') {
                        categoriesTable.ajax.reload();
                    } else {
                        productsTable.ajax.reload();
                    }
                }
            },
            error: function(xhr) {
                alert('Error updating SEO data: ' + xhr.responseJSON.message);
            }
        });
    });

    // Generate suggestions
    $('#generateSuggestions').on('click', function() {
        const type = $('#seoType').val();
        const id = $('#seoId').val();
        
        $.ajax({
            url: '/admin/seo/generate-suggestions',
            type: 'GET',
            data: {
                type: type,
                id: id
            },
            success: function(suggestions) {
                $('#meta_title').val(suggestions.meta_title);
                $('#meta_description').val(suggestions.meta_description);
                $('#meta_keyword').val(suggestions.meta_keyword);
                $('#meta_tags').val(suggestions.meta_tags);
            },
            error: function() {
                alert('Error generating suggestions');
            }
        });
    });
});
</script>
@endpush
