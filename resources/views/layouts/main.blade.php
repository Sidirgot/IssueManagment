<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body class="bg-gray-200">

        <div class="flex justify-between items-center bg-white p-4">
            <a href="{{ route('welcome') }}">Sidirgot</a>

            @guest
                <a href="{{ route('login') }}">Login</a>
            @else
                @if (Auth::user()->isManager())
                    <a href="{{ url('manage/dashboard') }}">Dashboard</a>
                @elseif (Auth::user()->isTester())
                    <a href="{{ url('team/dashboard') }}">Dashboard</a>
                @endif

                <form action="{{ route('logout') }}" method="post">
                    @csrf

                    <button type="submit" class="btn btn-teal">Logout</button>
                </form>
            @endguest
        </div>

        <div id="app">
            @yield('content')
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
