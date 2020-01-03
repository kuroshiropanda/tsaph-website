@extends('layouts.public')

@section('content')
<div class="content container pt-5">
    <div class="row" style="height: 85vh;">
        <div class="col-3">
            <rssapp-carousel id="KXp4oODoWuf5Ryro"></rssapp-carousel>
            <script src="https://widget.rss.app/v1/carousel.js" type="text/javascript" async></script>
        </div>
        <div class="col-6">
            <div class="mb-5">
                <img src="{{ asset('img/TSAPH logo.png') }}" style="width: auto; height: 50vh;" />
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
        <div class="col-3">
            <rssapp-carousel id="0DTCsYXqFuTYgcr4"></rssapp-carousel>
            <script src="https://widget.rss.app/v1/carousel.js" type="text/javascript" async></script>
        </div>
    </div>
    <div class="row">
        <rssapp-wall id="eDVNFJirgvNwj4Y3"></rssapp-wall>
        <script src="https://widget.rss.app/v1/wall.js" type="text/javascript" async></script>
    </div>
</div>
@endsection
