

<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Available Products</h2>

        <?php if(auth()->user()->role === 'employee' || auth()->user()->role === 'admin'): ?>
            <div class="text-end mb-3">
                <a href="<?php echo e(route('products.create')); ?>" class="btn btn-success">Add New Product</a>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($product->name); ?></h5>
                            <p class="card-text"><?php echo e($product->description ?? 'No description available.'); ?></p>
                            <p><strong>Price:</strong> $<?php echo e(number_format($product->price, 2)); ?></p>
                            <p><strong>Stock:</strong> 
                                <span class="badge bg-<?php echo e($product->stock > 0 ? 'success' : 'danger'); ?>">
                                    <?php echo e($product->stock > 0 ? $product->stock . ' Available' : 'Out of Stock'); ?>

                                </span>
                            </p>

                            <?php if(auth()->user()->role === 'customer' && $product->stock > 0): ?>
                                <form action="<?php echo e(route('products.buy', $product->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-primary w-100">Buy Now</button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <?php if(auth()->user()->role === 'employee' || auth()->user()->role === 'admin'): ?>
                            <div class="card-footer text-center">
                                <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php if(auth()->user()->role === 'customer' && $product->stock > 0): ?>
    <form action="<?php echo e(route('products.buy', $product->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-primary w-100">Buy Now</button>
    </form>
<?php endif; ?>

<?php if(auth()->user()->role === 'employee' || auth()->user()->role === 'admin'): ?>
    <div class="card-footer text-center">
        <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
        <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" class="d-inline"
              onsubmit="return confirm('Are you sure you want to delete this product?');">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </div>
<?php endif; ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ex_web\ProductStore\resources\views/products/index.blade.php ENDPATH**/ ?>