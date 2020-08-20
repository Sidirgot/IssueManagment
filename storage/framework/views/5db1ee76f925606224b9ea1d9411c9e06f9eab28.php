<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Backend</title>

        <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
    </head>
    <body class="bg-gray-200">

        <div id="app">
            <backend></backend>
        </div>

        <script src="<?php echo e(mix('js/app.js')); ?>"></script>
    </body>
</html>
<?php /**PATH /home/vagrant/code/issueManagment/resources/views/backend/layouts/dashboard.blade.php ENDPATH**/ ?>