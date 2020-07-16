@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-white bg-dark">
        <div class="card-header">
            <i class="fas fa-table"></i>
            {{ $applicant->username }}
        </div>
        <div class="card-body overflow-auto h-100">
            <div id="warning-popup" class="alert alert-danger">
                Warning do not edit If you don't know what you're doing!
            </div>
            <form action="{{ route('applicant.update', ['applicant' => $applicant->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $applicant->name }}">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="twitchId">{{ __('Twitch ID') }}</label>
                        <input type="text" name="twitchId" class="form-control" id="twitchId" value="{{ $applicant->twitch_id }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="twitchUsername">{{ __('Twitch Username') }}</label>
                        <input type="text" name="twitchUsername" class="form-control" id="twitchUsername" value="{{ $applicant->username }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="discordId">{{ __('Discord ID') }}</label>
                        <input type="text" name="discordId" class="form-control" id="discordId" value="{{ $applicant->discordData->discord_id }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="discordTag">{{ __('Discord Tag') }}</label>
                        <input type="text" name="discordTag" class="form-control" id="discordTag" value="{{ $applicant->discordData->username }}" disabled>
                    </div>
                </div>
                <div class="h-captcha @error('h-captcha-response') is-invalid @enderror" data-theme="dark" data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
                @error('h-captcha-response')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
