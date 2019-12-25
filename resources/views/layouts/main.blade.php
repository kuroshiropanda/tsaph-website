<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('tsaph.ico') }}" rel="icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #111;
            color: white;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 15%;
            top: 5vh;
        }

        .top-left {
            position: absolute;
            top: 1vh;
            left: 15%;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #999;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

    </style>
</head>

<body>
    <nav class="fixed-top">
        <div class="top-left links">
            <!-- <a href="{{ url('/') }}"> -->
                <!-- <img src="img/TSAPH logo.png" width="72" height="72" /> -->
                <!-- {{ config('app.name') }} -->
            <!-- </a> -->
        </div>
        <div class="top-right links">
            <a href="{{ url('/about') }}">About Us</a>
            <a href="{{ url('/rules') }}">Rules</a>
            <a href="{{ url('/contact') }}">Contact Us</a>
            <a href="{{ url('/twitch/login')}}">Apply</a>
        </div>
    </nav>
    <main role="main" class="flex-center position-ref full-height">
        <div class="content">
            @yield('content')
        </div>
    </main>
</body>

</html>
