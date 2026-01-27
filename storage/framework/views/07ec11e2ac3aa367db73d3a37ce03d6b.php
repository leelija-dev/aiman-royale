<?php $__env->startSection('source', 'Categories'); ?>
<?php $__env->startSection('page-title', ' Product Categories'); ?>

<?php $__env->startSection('title'); ?>
<?php echo e(config('app.name')); ?> - Product Categories
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-md-nowrap flex-wrap">
      <h5 class="card-title">Product Categories</h5>
      <div class="d-flex gap-2 flex-sm-nowrap flex-wrap">
        <a href="<?php echo e(route('admin.categories.trash')); ?>" class="btn btn-outline-secondary">
          <i class="fas fa-trash"></i>  View Trashed Category
        </a>
        
        <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary ">
          <i class="fas fa-plus"></i> Add New Category
        </a>
      </div>
    </div>
    <div class="ms-3 me-3">
      <?php if(session('success')): ?>
        <div class="alert alert-success">
          <?php echo e(session('success')); ?>

        </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table align-items-center mb-0 ">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">#</th>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name</th>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Slug</th>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Created At</th>
              <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($category->name); ?></td>
                <td><?php echo e($category->slug); ?></td>
                <td>
                  <?php if($category->is_active): ?>
                    <span class="badge bg-success rounded-pill">
                      <i class="fas fa-check-circle me-1"></i> Active
                    </span>
                  <?php else: ?>
                    <span class="badge bg-danger rounded-pill">
                      <i class="fas fa-times-circle me-1"></i> Inactive
                    </span>
                  <?php endif; ?>
                </td>
                <td><?php echo e($category->created_at->format('d M, Y')); ?></td>
                <td>
                  <div class="d-flex justify-content-start gap-2">
                    <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" 
                       class="btn btn-primary mb-0 px-3 d-flex justify-content-center align-items-center" 
                       title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form id="delete-form-<?php echo e($category->id); ?>" action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" 
                          method="POST" >
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      </form>
                      <button type="submit" class="btn btn-danger mb-0 px-3 d-flex justify-content-center align-items-center" title="Move to Trash" onclick="confirmDelete(<?php echo e($category->id); ?>)">
                        <i class="fas fa-trash"></i>
                      </button>
                    
                  </div>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="6" class="text-center">Categories not available!</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <div class="mt-3">
        <?php echo e($categories->links('pagination::bootstrap-5')); ?>

      </div>
    </div>
  </div>
</div>

<script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be delete this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\aiman-royale\resources\views/Admin/categories/index.blade.php ENDPATH**/ ?>