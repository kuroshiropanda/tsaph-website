@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-white bg-dark">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Applicants
        </div>
        <div class="card-body" style="height: 100%; overflow-y: auto;">
            <form action="{{ route('user.update', ['user' => Auth::id()]) }}" method="POST">
                @csrf
                <input type="hidden" name="api_token" value="{{ Auth::user()->api_token }}">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">{{ __('Username') }}</label>
                        <input type="text" name="username" class="form-control" id="username"
                            value="{{ $user->username }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">New Password</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" id="password">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="cpassword">
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#password, #cpassword').on('keyup', function () {
            if ($('#password').val() == $('#cpassword').val()) {

            }
        });
    });

</script>
@endpush
