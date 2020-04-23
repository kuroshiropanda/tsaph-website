@extends('layouts.index')

@section('content')
<div class="container">
    @if(!empty($email))
    <form action="{{ route('applicant.store') }}" method="POST">
        <div class="form-group">
            @csrf
            <input name="id" type="hidden" value="{{ $id }}" />
            <input name="email" type="hidden" value="{{ $email }}" />
            <input name="avatar" type="hidden" value="{{ $avatar }}" />
            <img class="img-thumnail rounded mx-auto d-block m-3" src="{{ $avatar }}" width="72" height="72">
            <p class="lead text-center">
                if you haven't submitted this form within an hour you'll be redirected to the home page and no info would be saved.
            </p>
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" class="form-control" type="text" value="{{ $username }}" readonly>
            </div>
            <div class="form-group">
                <label for="discord">Discord#</label>
                <input type="text" id="discord" name="discord" class="form-control" value="{{ $discord }}" readonly>
            </div>
            <div class="form-group">
                <label for="name">What is your full/fb name? if your full name is different from your fb name just input your fb name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            @foreach ($questions as $q)
            @if ($q->type === 'text')
            <div class="form-group">
                <label for="{{ $q->id }}">{{ $q->question }}</label>
                <input name="question_id[]" type="hidden" value="{{ $q->id }}" />
                <input id="{{ $q->id }}" class="form-control" name="answer[]" type="{{ $q->type }}" value="{{ old('answer.'.($loop->index - 1)) }}" required>
            </div>
            @elseif ($q->type === 'checkbox')
            <div class="form-group">
                <label for="checkbox">{{ $q->question }}</label>
                <!-- <input id="checkbox" type="hidden" value="{{ $q->id }}" /> -->
                @foreach ($types as $cb)
                <div class="form-check">
                    <input id="{{ $loop->iteration }}" class="form-check-input" name="checkbox[]" type="checkbox" value="{{ $cb->id }}" />
                    <label for="{{ $loop->iteration }}" class="form-check-label">{{ $cb->type }}</label>
                </div>
                @endforeach
            </div>
            @elseif ($q->type === 'textarea')
            <div class="form-group">
                <label for="{{ $q->id }}">{{ $q->question }}</label>
                <input name="question_id[]" type="hidden" value="{{ $q->id }}" />
                <textarea id="{{ $q->id }}" class="form-control" name="answer[]" required>{{ old('answer.'.($loop->index - 1)) }}</textarea>
            </div>
            @endif
            @endforeach
        </div>
        <p class="font-weight-bold text-uppercase text-center">
            disclaimer:<br>
            applications must be processed within 2 weeks.<br>
            if 2 weeks have passed, your application will be automatically deleted and you must re-apply again.<br>
            this is due to the amount of applicants applying who don't go through the interviews.
        </p>
        <p class="lead font-weight-bold text-uppercase text-center">
            you'll be redirected to tsaph's discord for the interview once you click submit
        </p>
        <div class="form-group text-center">
            <div class="h-captcha @error('h-captcha-response') is-invalid @enderror" data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
            @error('h-captcha-response')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="my-3">
            @if(session('status'))
            <div class="alert alert-info">
                {{ session('status') }}
            </div>
            @endif
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
    @else
    <div class="d-flex justify-content-center my-5 py-5">
        <blockquote class="blockquote">
            <p class="lead font-weight-bold text-uppercase text-center">
                you don't have a verified email address<br>
                please verify your twitch email and then refresh this tab<br>
                this is to prevent spam
            </p>
        </blockquote>
    </div>
    @endif
</div>
@endsection
