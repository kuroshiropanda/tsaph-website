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
            <div class="links pt-2">
                <a href="{{ url('/facebook') }}">Facebook page</a>
                <a href="{{ url('/fbgroup') }}">Facebook group</a>
                <a href="{{ url('/discord') }}">Discord</a>
            </div>
            @else
            <p class="lead">
                go wait on discord for an interview. click <a href="{{ route('interview') }}"
                    class="text-decoration-none font-weight-bold">HERE</a>.
                <br/>or if you're already approved
                <br/>check your team invites on twitch. click <a href="{{ url('https://dashboard.twitch.tv/settings/channel') }}" class="text-decoration-none">here</a>.
            </p>
            @endif
        </div>
    </div>
</div>
@endsection
