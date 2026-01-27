<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('title'); ?>
<?php echo e(config('app.name')); ?> - Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    .btn-group .btn {
        margin-right: 5px;
    }
</style>

<div class="container-fluid mt-3">
    
   <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="px-3 py-4 text-center">
                    <h3>Welcome Admin</h3>
                   
                </div>
            </div>
        </div>
    </div>
</div> 

<!-- Custom Date Modal -->

<?php $__env->stopSection(); ?> 


<?php echo $__env->make('Admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\aiman-royale\resources\views/Admin/home.blade.php ENDPATH**/ ?>