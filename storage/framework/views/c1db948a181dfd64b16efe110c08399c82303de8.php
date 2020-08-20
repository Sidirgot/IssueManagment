

<?php $__env->startSection('title', '| Login'); ?>

<?php $__env->startSection('content'); ?>
<section class="flex justify-center items-center mt-12" id="app">
    <div class="bg-white rounded shadow-xl w-full md:w-1/3 mx-2 md:mx-0 text-center">
        <div class="flex justify-center items-center py-4">
            <h2 class="text-2xl text-bold text-sidirgot">Sidirgot</h2>
        </div>

        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-red-600 rounded text-white my-3 mx-6 p-3">
                    <?php echo e($error); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

       <form action="<?php echo e(route('login')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="my-8">
                <input type="text" name="email" placeholder="email" class="px-4 py-2 rounded shadow  w-2/3">
            </div>

            <div class="mb-8">
                <input type="password" name="password" placeholder="password" class="px-4 py-2 rounded shadow  w-2/3">
            </div>

            <div class="bg-gray-200 flex justify-center items-center py-6">
                <button class="text-white bg-teal-500 px-4 py-2 rounded shadow hover:bg-teal-400">Log In</button>
            </div>
        </form>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/code/issueManagment/resources/views/auth/login.blade.php ENDPATH**/ ?>