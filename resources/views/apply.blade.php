@extends('layouts.index')

@section('content')
<div class="container">
    <form action="{{ route('applicant.create') }}" method="POST">
        <div class="form-group">
            @csrf
            <input name="id" type="hidden" value="{{ $id }}" />
            <input name="email" type="hidden" value="{{ $email }}" />
            <input name="avatar" type="hidden" value="{{ $avatar }}" />
            <img class="img-thumnail rounded mx-auto d-block m-3" src="{{ $avatar }}" width="72" height="72" />
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" class="form-control" type="text" value="{{ $username }}" readonly />
            </div>
            <div class="form-group">
                <label for="name">What is your full/fb name?</label>
                <input type="text" id="name" name="name" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="discord">What is your discord id? (click on your name on discord [bottom left])</label>
                <input type="text" id="discord" name="discord" class="form-control" required />
            </div>
            @foreach ($questions as $q)
            @if ($q->type === 'text')
            <div class="form-group">
                <label for="{{ $q->id }}">{{ $q->question }}</label>
                <input name="question_id[]" type="hidden" value="{{ $q->id }}" />
                <input id="{{ $q->id }}" class="form-control" name="answer[]" type="{{ $q->type }}" required />
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
                <textarea id="{{ $q->id }}" class="form-control" name="answer[]" required></textarea>
            </div>
            @endif
            @endforeach
        </div>
        <p class="lead font-weight-bold text-uppercase text-center">
            once you click submit you'll be redirected to tsaph's discord for the interview<br>
            once you're there wait for an admin to conduct an interview<br>
            they'll be announcing it on the #interview channel on discord
        </p>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
</div>
@endsection
