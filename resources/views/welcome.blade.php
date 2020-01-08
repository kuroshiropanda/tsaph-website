@extends('layouts.public')

@section('content')
<div class="content container py-5" style="height:80vh;">
    <div class="col">
        <div class="mb-5">
            <picture>
                <source media="(max-height: 117px)" srcset="{{ asset('img/tsaph@0,1x.png') }}">
                <source media="(max-height: 768px)" srcset="{{ asset('img/tsaph@0,25x.png') }}">
                <source media="(max-height: 1080px)" srcset="{{ asset('img/tsaph@0,5x.png') }}">
                <source media="(max-height: 1440px)" srcset="{{ asset('img/tsaph@1,25x.png') }}">
                <img class="img-fluid mx-auto" src="{{ asset('img/tsaph.png') }}" />
            </picture>
        </div>

        <div class="links">
            <a href="{{ url('https://facebook.com/tsaphofficial') }}"><i class="fab fa-facebook-f fa-2x"></i></a>
            <a href="{{ url('https://facebook.com/group/twitchsaph') }}"><i
                    class="fab fa-facebook-square fa-2x"></i></a>
            <!-- <a href="{{ url('https://instagram.com/tsaphofficial') }}">Instagram</a> -->
            <!-- <a href="{{ url('https://twitter.com/tsaphofficial') }}">Twitter</a> -->
            <a href="{{ url('https://twitch.tv/team/tsaph') }}"><i class="fab fa-twitch fa-2x"></i></a>
            <!-- <a href="{{ url('https://youtube.com/tsaphofficial') }}">Youtube</a> -->
        </div>
    </div>
</div>
@endsection
