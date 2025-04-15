<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(route('home')); ?>">ProductStore</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('products.index')); ?>">Products</a>
                </li>

                <?php if(auth()->check()): ?>
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('users.index')); ?>">Manage Users</a>
                        </li>
                    <?php endif; ?>

                    <?php if(auth()->user()->role === 'employee'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('customers.index')); ?>">Manage Customers</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('profile')); ?>">
                            <?php echo e(auth()->user()->name); ?> (<?php echo e(number_format(auth()->user()->credit, 2)); ?>$)
                        </a>
                    </li>

                    <li class="nav-item">
                        <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('register')); ?>">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\ex_web\ProductStore\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>