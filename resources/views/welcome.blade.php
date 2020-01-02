@extends('layouts.main')

@section('content')
<div class="mb-5">
    <img src="{{ asset('img/TSAPH logo.png') }}" style="width: auto; height: 50vh;" />
</div>

<div class="links">
    <a href="{{ url('https://facebook.com/tsaphofficial') }}"><i class="fab fa-facebook-f fa-2x"></i></a>
    <a href="{{ url('https://facebook.com/group/twitchsaph') }}"><i class="fab fa-facebook-square fa-2x"></i></a>
    <!-- <a href="{{ url('https://instagram.com/tsaphofficial') }}">Instagram</a> -->
    <!-- <a href="{{ url('https://twitter.com/tsaphofficial') }}">Twitter</a> -->
    <a href="{{ url('https://twitch.tv/team/tsaph') }}"><i class="fab fa-twitch fa-2x"></i></a>
    <!-- <a href="{{ url('https://youtube.com/tsaphofficial') }}">Youtube</a> -->
</div>
@endsection
