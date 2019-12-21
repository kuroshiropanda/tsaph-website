<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>TSAPH Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta name="theme-color" content="#563d7c">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/signin.css') }}" rel="stylesheet">
</head>

<body class="text-center">
    <form method="POST" action="{{ route('login') }}" class="form-signin">
        @csrf
        <img class="mb-4" src="{{ asset('img/TSAPH logo.png') }}" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">TSAPH ADMIN</h1>
        <label for="username" class="sr-only">{{ __('Username') }}</label>
        <input type="text" id="username" class="form-control" placeholder="Username" name="username"
            value="{{ old('username') }}" required autocomplete="username" autofocus>
        <label for="password" class="sr-only">{{ __('Password') }}</label>
        <input type="password" id="password" class="form-control" placeholder="Password" name="password" required
            autocomplete="current-password">
        <div class="checkbox mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
            <!-- <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label> -->
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <div>
            @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
            @endif
        </div>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
    </form>
</body>

</html>
