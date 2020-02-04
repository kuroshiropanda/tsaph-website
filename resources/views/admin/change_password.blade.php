@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-white bg-dark">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Applicants
        </div>
        <div class="card-body" style="height: 100%; overflow-y: auto;">
            <form action="{{ route('user.update.password', ['user' => Auth::id()]) }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">New Password</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" id="password">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" id="cpassword">
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="old_password">Old Password</label>
                        <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" id="old_password">
                    </div>
                </div>
                @error('old_password')
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
