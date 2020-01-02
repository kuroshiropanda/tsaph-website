@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-white bg-dark" style="height: 83vh;">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Denied Applicants
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th></th>
                            <th scope="col">Username</th>
                            <th scope="col">by</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($denied as $d)
                        <tr>
                            <td scope="row">{{ $d->id }}</td>
                            <td><img src="{{ $d->avatar }}" style="width:auto; height:8vh;" /></td>
                            <td>{{ $d->username }}</td>
                            <td>{{ $d->user['username'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">
            {{ $denied->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
