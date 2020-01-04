@extends('layouts.index')

@section('content')
<div class="container my-5 py-5">
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-center">
                <blockquote class="blockquote">
                    <h1 class="display-1">
                        {{ $alert }}
                    </h1>
                    <footer class="blockquote-footer"><a href="{{ url('https://twitch.tv/tapangking') }}"
                            class="text-decoration-none">tapangking</a></footer>
                </blockquote>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            @if($type === 'member')
            <p class="lead">
                you're already a member. go check our facebook page or join our facebook group and/or discord
            </p>
            @else
            <p class="lead">
                go wait on discord for an interview. click <a href="{{ url('/discord') }}"
                    class="text-decoration-non">here</a>.
            </p>
            @endif
            <div class="links pt-2">
                <a href="{{ url('/facebook') }}">Facebook page</a>
                <a href="{{ url('/fbgroup') }}">Facebook group</a>
                <a href="{{ url('/discord') }}">Discord</a>
            </div>
        </div>
    </div>
</div>
@endsection
