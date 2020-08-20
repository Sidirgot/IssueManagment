<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
    </head>
    <body class="bg-gray-200">

        <div class="flex justify-between items-center bg-white p-4">
            <a href="<?php echo e(route('welcome')); ?>">Sidirgot</a>

            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>">Login</a>
            <?php else: ?>
                <?php if(Auth::user()->isManager()): ?>
                    <a href="<?php echo e(url('manage/dashboard')); ?>">Dashboard</a>
                <?php elseif(Auth::user()->isTester()): ?>
                    <a href="<?php echo e(url('team/dashboard')); ?>">Dashboard</a>
                <?php endif; ?>

                <form action="<?php echo e(route('logout')); ?>" method="post">
                    <?php echo csrf_field(); ?>

                    <button type="submit" class="btn btn-teal">Logout</button>
                </form>
            <?php endif; ?>
        </div>

        <div id="app">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <script src="<?php echo e(mix('js/app.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /home/vagrant/code/issueManagment/resources/views/layouts/main.blade.php ENDPATH**/ ?>