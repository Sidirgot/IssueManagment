<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sidirgot - Application issue tracking</title>

        <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
    </head>
    <body class="bg-gray-200 min-h-screen">
            <section class="flex justify-center items-center min-h-screen" id="app">
                <div class="bg-white rounded shadow-xl w-full md:w-1/3 mx-2 md:mx-0 text-center">
                    <div class="flex justify-center items-center py-12">
                        <img class="h-20 mr-4" src="/assets/logo.png" alt="sidirgot logo">
                        <span class="text-2xl text-bold text-teal-600">Sidirgot</span>
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

    </body>
</html>
<?php /**PATH /home/vagrant/code/issueManagment/resources/views/auth/login.blade.php ENDPATH**/ ?>