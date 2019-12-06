<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-md-3"></div>

            <div class="col-md-6 text-center">
                <h4>Login Via Google Account</h4>
                <hr>
                <?php if(!$is_logged_in): ?>
                <a href="<?php echo e($login_link); ?>" class="btn btn-light">Login Via Google</a>
                <?php endif; ?>
                <hr>
                <a href="<?php echo e(app_url()); ?>" class="text-decoration-none">Back to Home</a>
            </div>

            <div class="col-md-3"></div>
        </div>

        <div class="row text-center">
            <div class="col-12">
                <?php if($is_logged_in): ?>
                <p>You are now logged in with your <b>Google Account</b>. The details of your account are shown below:</p>
                <p>An email was also sent with the provided email address below:</p>
                <p><b>Name:</b> <?php echo e($name); ?><b>Email Address:</b> <?php echo e($email); ?></p>
                <p><b>Reload this page</b> to try a different login service. <a href="<?php echo e(app_url('google')); ?>" class="text-decoration-none">Reload Page</a>.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\PHP-TEST\App\Views/google.blade.php ENDPATH**/ ?>