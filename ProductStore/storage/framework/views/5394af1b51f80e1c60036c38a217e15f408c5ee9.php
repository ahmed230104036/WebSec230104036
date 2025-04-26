

<?php $__env->startSection('title', 'Manage Customers'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <h2 class="text-center">Customers List</h2>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Credit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($customer->name); ?></td>
                    <td><?php echo e($customer->email); ?></td>
                    <td>$<?php echo e(number_format($customer->credit, 2)); ?></td>
                    <td>
                        <form action="<?php echo e(route('customers.addCredit', $customer->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <input type="number" name="amount" class="form-control d-inline w-50" min="1" required>
                            <button type="submit" class="btn btn-success btn-sm">Add Credit</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ex_web\ProductStore\resources\views/customers/index.blade.php ENDPATH**/ ?>


























