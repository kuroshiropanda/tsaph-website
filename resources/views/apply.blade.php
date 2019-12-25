<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <main role="main" class="flex-center position-ref full-height">
        <div class="container">
            <form action="{{ url('apply/create') }}" method="POST">
                <div class="form-group">
                    @csrf
                    <input name="id" type="hidden" value="{{ $id }}" />
                    <input name="email" type="hidden" value="{{ $email }}" />
                    <input name="username" type="hidden" value="{{ $name }}" />
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" class="form-control" type="text" value="{{ $name }}" disabled />
                    </div>
                    <div class="form-group">
                        <label for="name">What is your full name?</label>
                        <input type="text" id="name" name="name" class="form-control" />
                    </div>
                    @foreach ($questions as $q)
                    @if ($q->type === 'text')
                    <div class="form-group">
                        <label for="{{ $q->id }}">{{ $q->question }}</label>
                        <input id="{{ $q->id }}" class="form-control" name="answer[]" type="{{ $q->type }}" />
                    </div>
                    @elseif ($q->type === 'textarea')
                    <div class="form-group">
                        <label for="{{ $q->id }}">{{ $q->question }}</label>
                        <textarea id="{{ $q->id }}" class="form-control" name="answer[]"></textarea>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
