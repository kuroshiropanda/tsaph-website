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
                        <label for="password">Password Confirmation</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
                    </div>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
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
