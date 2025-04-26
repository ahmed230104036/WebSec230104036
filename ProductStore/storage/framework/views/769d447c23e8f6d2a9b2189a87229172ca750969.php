

<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
    <h2>User Profile</h2>
    <table class="table">
        <tr>
            <th>Name:</th>
            <td><?php echo e($user->name); ?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?php echo e($user->email); ?></td>
        </tr>
        <tr>
            <th>Role:</th>
            <td><?php echo e(ucfirst($user->role)); ?></td>
        </tr>
        <tr>
            <th>Credit:</th>
            <td>$<?php echo e(number_format($user->credit, 2)); ?></td>
        </tr>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ex_web\ProductStore\resources\views/profile.blade.php ENDPATH**/ ?>



































