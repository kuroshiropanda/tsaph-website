<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-154118791-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-154118791-2');
    </script>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>

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

        footer {
            font-size: 8px;
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

        a {
            color: #999;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
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

    </style>
    @stack('style')
    <script src="https://cdn.jsdelivr.net/npm/@widgetbot/crate@3" async defer>
    new Crate({
        server: '504692743524843521',
        channel: '504692743524843523',
        shard: 'https://disweb.dashflo.net'
    })
    </script>
    <script data-name="BMC-Widget" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js" data-id="kuroshiropanda" data-description="Support me on Buy me a coffee!" data-message="created by kuroshiropanda. buy me a ☕" data-color="#79D6B5" data-position="left" data-x_margin="18" data-y_margin="18"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand mr-5" href="{{ url('/') }}" style="width:5vw; height:5v;">
            @if(Request::path() === '/')
            {{ config('app.name') }}
            @else
            <img src="{{ asset('img/tsaph@0,1x.png') }}" style="width:auto; height:5vh;">
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rules') }}">Rules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('apply')}}">Apply</a>
                </li>
            </ul>
        </div>
    </nav>
    <main role="main" class="flex-center" style="height:80vh;">
        @yield('content')
    </main>
    <footer class="mt-auto py-3">
        <div class="text-center">
            <a href="https://twitch.tv/kuroshiropanda" class="text-decoration-none"><span style="color: #9146FF;">
                    <i class="fab fa-twitch"></i>
                </span>kuroshiropanda</a>
        </div>
    </footer>
</body>

</html>
