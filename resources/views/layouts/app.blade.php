<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script data-ad-client="ca-pub-7308274596514016" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-154118791-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-154118791-2');

    </script>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="dns-prefetch" href="//static-cdn.jtvnw.net">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')

    <script data-name="BMC-Widget" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js" data-id="kuroshiropanda" data-description="Support me on Buy me a coffee!" data-message="Thank you for visiting. You can support me by buying me a coffee!" data-color="#FF813F" data-position="right" data-x_margin="18" data-y_margin="18"></script>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark" style="height:8vh;">
            <div class="container">
                <a class="navbar-brand" href="{{ route('admin') }}" style="height:8vh;">
                    <img class="img-fluid" src="{{ asset('img/tsaph@0,1x.png') }}" style="height:100%;" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav mr-auto">
                        @canany(['invite applicants', 'update applicants'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin') }}">Activity Log</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link">Users</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('members') }}" class="nav-link">Members</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('applicants') }}" class="nav-link">Applicants</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('denied') }}" class="nav-link">Denied</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('approved') }}" class="nav-link">Approved</a>
                        </li>
                        @endcanany
                    </ul>

                    @if(Request::path() === 'admin/members' || Request::path() === 'admin/applicants')
                    <ul class="navbar-nav mx-auto">
                        <input type="text" class="form-control" id="adminSearch" placeholder="Search..">
                    </ul>
                    @endif
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @can('edit roles')
                                <a class="dropdown-item" href="{{ route('users') }}">
                                    {{ __('Manage Users') }}
                                </a>
                                @endcan
                                <a class="dropdown-item" href="{{ route('user.edit', ['user' => Auth::id()]) }}">
                                    {{ __('Edit Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('user.password', ['user' => Auth::id()]) }}">
                                    {{ __('Change Password') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="pt-2">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>

</html>
