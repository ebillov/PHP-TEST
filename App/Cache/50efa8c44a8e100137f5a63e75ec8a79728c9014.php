<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e($title); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(app_url('node_modules/jquery/dist/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(app_url('App/Assets/custom.js')); ?>" defer></script>
    <script src="<?php echo e(app_url('node_modules/bootstrap/dist/js/bootstrap.min.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="<?php echo e(app_url('node_modules/bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(app_url('App/Assets/custom.css')); ?>" rel="stylesheet">
</head>
<body>
    <main class="py-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PHP-TEST\App\Views/layouts/app.blade.php ENDPATH**/ ?>