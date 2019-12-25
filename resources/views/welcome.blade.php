@extends('layouts.main')

@section('content')
<div class="title m-b-md">
    <img src="{{ asset('img/TSAPH logo.png') }}" style="width: auto; height: 50vh;" />
</div>

<div class="links">
    <a href="{{ url('http://facebook.com/tsaphofficial') }}">Facebook</a>
    <a href="{{ url('https://instagram.com/tsaphofficial') }}">Instagram</a>
    <a href="{{ url('https://twitter.com/tsaphofficial') }}">Twitter</a>
    <a href="{{ url('https://twitch.tv/team/tsaph') }}">Twitch</a>
    <a href="{{ url('https://youtube.com/tsaphofficial') }}">Youtube</a>
</div>
@endsection
