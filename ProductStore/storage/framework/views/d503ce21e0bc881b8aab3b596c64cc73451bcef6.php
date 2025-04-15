

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <div class="text-center">
        <h1>Welcome to ProductStore</h1>
        <p>Manage and purchase products efficiently.</p>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">View Products</a>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-success">Login to continue</a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ex_web\ProductStore\resources\views/home.blade.php ENDPATH**/ ?>