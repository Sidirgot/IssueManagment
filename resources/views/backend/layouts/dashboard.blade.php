<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Backend</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body class="bg-gray-300">

        <div id="app">
            <backend></backend>
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
