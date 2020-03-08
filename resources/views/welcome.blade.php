@extends('layouts.public')

@push('style')
<style>
    .tsaph-logo {
        width: 30vw;
        height: auto;
    }

    .fa-facebook-f {
        color: #4267B2;
    }

    .fa-facebook-square {
        color: #4267B2;
    }

    .fa-reddit {
        color: #FF4500;
    }

    .fa-twitch {
        color: #9146FF;
    }
</style>
@endpush

@section('content')
<div class="text-center container py-5">
    <div class="col">
        <div class="mb-5">
            <img class="img-fluid mx-auto tsaph-logo" src="{{ asset('img/tsaph.png') }}">
        </div>

        <div class="links">
            <a href="{{ url('https://facebook.com/tsaphofficial') }}" target="_blank">
                <i class="fab fa-facebook-square fa-2x"></i>
            </a>
            <!-- <a href="{{ url('https://facebook.com/group/twitchsaph') }}"><i
                    class="fab fa-facebook-square fa-2x"></i></a> -->
            <a href="{{ url('https://reddit.com/r/tsaph') }}" target="_blank">
                <i class="fab fa-reddit fa-2x"></i>
            </a>
            <!-- <a href="{{ url('https://instagram.com/tsaphofficial') }}">Instagram</a> -->
            <!-- <a href="{{ url('https://twitter.com/tsaphofficial') }}">Twitter</a> -->
            <a href="{{ url('https://twitch.tv/team/tsaph') }}" target="_blank"><i class="fab fa-twitch fa-2x"></i></a>
            <!-- <a href="{{ url('https://youtube.com/tsaphofficial') }}">Youtube</a> -->
        </div>
    </div>
</div>
@endsection
