@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3">
            <div class="card" style="width: 18rem;">
                <img src="{{ $applicant->avatar ?? '' }}" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-dark">Info</h5>
                    <p class="card-text text-dark">Twitch Name: {{ $applicant->username }}</p>
                    <p class="card-text text-dark">Real Name: {{ $applicant->name }}</p>
                    <div class="row">
                        <div class="col-6">
                            <form action="{{ route('applicant.update', ['id' => $applicant->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $applicant->id }}">
                                <input type="hidden" name="update" value="approve">
                                <button type="submit" class="btn btn-primary">Approve</button>
                            </form>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('applicant.update', ['id' => $applicant->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $applicant->id }}">
                                <input type="hidden" name="update" value="deny">
                                <button type="submit" class="btn btn-danger">Deny</button>
                            </form>
                        </div>
                    </div>
                    <!-- <a href="{{ url('/applicant/'.$applicant->id.'/approve') }}" class="btn btn-primary">Approve</a>
                    <a href="{{ url('/applicant/'.$applicant->id.'/deny') }}" class="btn btn-danger">Deny</a> -->
                </div>
            </div>
        </div>
        <div class="col-8 ml-5" style="height: 83vh; overflow-y: auto;">
            <table class="table table-bordered table-striped">
                <tbody>
                    @foreach($answers as $a)
                    <tr>
                        <td><strong>{{ $a->question }}</strong></td>
                    </tr>
                    <tr>
                        <td>{{ $a->answer }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
