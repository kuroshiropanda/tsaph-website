@extends('layouts.public')

@push('style')
<style>
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

    .fa-youtube {
        color: #C4302B;
    }
</style>
@endpush

@section('content')
<div class="container text-center pt-3">
    <div class="row">
        <div class="col">
            <p class="lead font-weight-bold text-uppercase text-center">
                contact us through:
            </p>
            <p class="lead text-center font-weight-bold">
                email: <a href="mailto:tsaph.business@gmail.com">tsaph.business@gmail.com</a>
            </p>
            <div class="links">
                <a href="{{ url('https://facebook.com/tsaphofficial') }}" target="_blank">
                    <i class="fab fa-facebook-square fa-2x"></i>
                </a>
                <a href="{{ url('https://reddit.com/r/tsaph') }}" target="_blank"><i class="fab fa-reddit fa-2x"></i></a>
                <a href="{{ url('https://twitch.tv/team/tsaph') }}" target="_blank"><i class="fab fa-twitch fa-2x"></i></a>
                <a href="{{ url('https://www.youtube.com/channel/UCsUV3M1vIHoX3itMtPsgmww') }}" target="_blank"><i class="fab fa-youtube fa-2x"></i></a>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <div class="card text-white bg-dark">
                <div class="card-header">
                    <h4 class="text-uppercase">Feedback Form</h4>
                </div>
                <div class="card-body">
                    <form id="feedback" action="{{ route('feedback.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name (optional)</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="message">Feedback</label>
                            <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="h-captcha @error('h-captcha-response') is-invalid @enderror" data-theme="dark" data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
                            @error('h-captcha-response')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit Feedback">
                        <div class="mt-3">
                            @if(session('status'))
                                <div class="alert alert-info">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
