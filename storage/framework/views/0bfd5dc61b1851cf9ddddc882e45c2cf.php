<?php $__env->startSection('source', 'Product'); ?>
<?php $__env->startSection('page-title', 'Products'); ?>

<?php $__env->startSection('title'); ?>
<?php echo e(config('app.name')); ?> - Products
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="<?php echo e(route('admin.products')); ?>" class="mb-2 mb-md-0 d-flex w-100 w-lg-50 ">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;" placeholder="Search by product name, design no, or brand" value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1" style="height:40px;">Search</button>
                        <a href="<?php echo e(route('admin.products')); ?>" class="btn btn-danger mb-sm-3 mb-1" style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                    <a href="<?php echo e(route('admin.products-trashed')); ?>" class="btn btn-outline-secondary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-trash"></i> View Trashed Products
                    </a>
                    <a href="<?php echo e(route('admin.add-product')); ?>" class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1">
                        <i class="fas fa-plus"></i> Add New Product
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Design No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Brand</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <?php if($product->images->count() > 0): ?>
                                                <img src="<?php echo e(asset('uploads/products/' . $product->images->first()->image)); ?>" 
                                                     class="avatar avatar-sm me-3" alt="<?php echo e($product->name); ?>">
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('assets/img/placeholder.png')); ?>" 
                                                     class="avatar avatar-sm me-3" alt="<?php echo e($product->name); ?>">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm"><?php echo e($product->design_no); ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm"><?php echo e($product->name); ?></h6>
                                            <?php if($product->fabric): ?>
                                            <p class="text-xs text-secondary mb-0"><?php echo e($product->fabric); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm"><?php echo e($product->brand ?? 'N/A'); ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm"><?php echo e($product->category ? $product->category->name : 'N/A'); ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">$<?php echo e(number_format($product->price, 2)); ?></h6>
                                            <?php if($product->discount_price): ?>
                                            <p class="text-xs text-success mb-0">$<?php echo e(number_format($product->discount_price, 2)); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm"><?php echo e($product->stock); ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="badge <?php echo e($product->status == 'active' ? 'bg-success' : 'bg-danger'); ?>">
                                                <?php echo e($product->status); ?>

                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" class="text-secondary font-weight-bold text-xs me-4"
                                       data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($product->id); ?>"
                                       title="Edit product">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form id="delete-form-<?php echo e($product->id); ?>"
                                          action="<?php echo e(route('admin.products.delete', $product->id)); ?>"
                                          method="POST" style="display:none;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                    <a href="javascript:void(0);"
                                       onclick="confirmDelete(<?php echo e($product->id); ?>)">
                                        <i class="fa-solid fa-trash text-danger font-weight-bold text-xs"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?php echo e($product->id); ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo e($product->id); ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?php echo e($product->id); ?>">Edit Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="editForm<?php echo e($product->id); ?>"
                                              action="<?php echo e(route('admin.products.update', $product->id)); ?>"
                                              method="POST" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="modal-body text-start">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="edit_design_no_<?php echo e($product->id); ?>" class="form-label">Design Number <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="edit_design_no_<?php echo e($product->id); ?>" name="design_no" 
                                                                   value="<?php echo e($product->design_no); ?>" maxlength="40" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_name_<?php echo e($product->id); ?>" class="form-label">Product Name <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="edit_name_<?php echo e($product->id); ?>" name="name" 
                                                                   value="<?php echo e($product->name); ?>" maxlength="200" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_brand_<?php echo e($product->id); ?>" class="form-label">Brand</label>
                                                            <input type="text" class="form-control" id="edit_brand_<?php echo e($product->id); ?>" name="brand" 
                                                                   value="<?php echo e($product->brand); ?>" maxlength="100">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_fabric_<?php echo e($product->id); ?>" class="form-label">Fabric</label>
                                                            <input type="text" class="form-control" id="edit_fabric_<?php echo e($product->id); ?>" name="fabric" 
                                                                   value="<?php echo e($product->fabric); ?>" maxlength="100">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_fit_<?php echo e($product->id); ?>" class="form-label">Fit</label>
                                                            <select class="form-control" id="edit_fit_<?php echo e($product->id); ?>" name="fit">
                                                                <option value="">Select Fit</option>
                                                                <option value="Slim" <?php echo e($product->fit == 'Slim' ? 'selected' : ''); ?>>Slim</option>
                                                                <option value="Regular" <?php echo e($product->fit == 'Regular' ? 'selected' : ''); ?>>Regular</option>
                                                                <option value="A-line" <?php echo e($product->fit == 'A-line' ? 'selected' : ''); ?>>A-line</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="edit_category_id_<?php echo e($product->id); ?>" class="form-label">Category <span class="text-danger">*</span></label>
                                                            <select class="form-control" id="edit_category_id_<?php echo e($product->id); ?>" name="category_id" required>
                                                                <option value="">Select Category</option>
                                                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($category->id); ?>" <?php echo e($product->category_id == $category->id ? 'selected' : ''); ?>>
                                                                    <?php echo e($category->name); ?>

                                                                </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_occasion_id_<?php echo e($product->id); ?>" class="form-label">Occasion</label>
                                                            <select class="form-control" id="edit_occasion_id_<?php echo e($product->id); ?>" name="occasion_id">
                                                                <option value="">Select Occasion</option>
                                                                <?php $__currentLoopData = $occasions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $occasion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($occasion->id); ?>" <?php echo e($product->occasion_id == $occasion->id ? 'selected' : ''); ?>>
                                                                    <?php echo e($occasion->name); ?>

                                                                </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_price_<?php echo e($product->id); ?>" class="form-label">Price <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="edit_price_<?php echo e($product->id); ?>" name="price" 
                                                                   value="<?php echo e($product->price); ?>" step="0.01" min="0" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_discount_price_<?php echo e($product->id); ?>" class="form-label">Discount Price</label>
                                                            <input type="number" class="form-control" id="edit_discount_price_<?php echo e($product->id); ?>" name="discount_price" 
                                                                   value="<?php echo e($product->discount_price); ?>" step="0.01" min="0">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_stock_<?php echo e($product->id); ?>" class="form-label">Stock <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="edit_stock_<?php echo e($product->id); ?>" name="stock" 
                                                                   value="<?php echo e($product->stock); ?>" min="0" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_status_<?php echo e($product->id); ?>" class="form-label">Status <span class="text-danger">*</span></label>
                                                            <select class="form-control" id="edit_status_<?php echo e($product->id); ?>" name="status" required>
                                                                <option value="active" <?php echo e($product->status == 'active' ? 'selected' : ''); ?>>Active</option>
                                                                <option value="inactive" <?php echo e($product->status == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="edit_image_<?php echo e($product->id); ?>" class="form-label">Product Image</label>
                                                            <input type="file" class="form-control" id="edit_image_<?php echo e($product->id); ?>" name="image" accept="image/*">
                                                            <?php if($product->images->count() > 0): ?>
                                                            <small class="text-muted">Current: <?php echo e($product->images->first()->image); ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="edit_description_<?php echo e($product->id); ?>" class="form-label">Description</label>
                                                            <textarea class="form-control" id="edit_description_<?php echo e($product->id); ?>" name="description" rows="3"><?php echo e($product->description); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <p class="text-muted">No products found.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing <?php echo e($data->firstItem()); ?> to <?php echo e($data->lastItem()); ?> of <?php echo e($data->total()); ?> entries
                    </div>
                    <div>
                        <?php echo e($data->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
            this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\aiman-royale\resources\views/Admin/product/index.blade.php ENDPATH**/ ?>