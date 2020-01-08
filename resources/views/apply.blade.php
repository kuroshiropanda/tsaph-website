@extends('layouts.index')

@section('content')
<div class="container">
    <form action="{{ route('apply') }}" method="POST">
        <div class="form-group">
            @csrf
            <input name="id" type="hidden" value="{{ $id }}" />
            <input name="email" type="hidden" value="{{ $email }}" />
            <input name="username" type="hidden" value="{{ $username }}" />
            <input name="avatar" type="hidden" value="{{ $avatar }}" />
            <img class="img-thumnail rounded mx-auto d-block m-3" src="{{ $avatar }}" width="72" height="72" />
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" class="form-control" type="text" value="{{ $username }}" disabled />
            </div>
            <div class="form-group">
                <label for="name">What is your full name?</label>
                <input type="text" id="name" name="name" class="form-control" required />
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
                <input id="checkbox" name="question_id[]" type="hidden" value="{{ $q->id }}" />
                @foreach ($checkbox as $cb)
                <div class="form-check">
                    <input id="{{ $loop->iteration }}" class="form-control" name="checkbox[]" type="checkbox" value="{{ $cb->type }}" />
                    <label for="{{ $loop->iteration }}">Streamer</label>
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
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
</div>
@endsection
