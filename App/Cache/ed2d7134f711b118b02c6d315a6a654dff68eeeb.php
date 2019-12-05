<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="container">
        <div class="row mt-5 mb-4">
            <div class="col-md-3"></div>

            <div class="col-md-6 text-center">
                <h1>Login Via Service Providers Below (Demo)</h1>
                <hr>
                <a href="<?php echo e(app_url('google')); ?>" class="btn btn-light">Google Login Demo</a>
            </div>

            <div class="col-md-3"></div>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PHP-TEST\App\Views/index.blade.php ENDPATH**/ ?>