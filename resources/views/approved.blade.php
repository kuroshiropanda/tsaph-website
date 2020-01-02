@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-white bg-dark" style="height: 80vh;">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Approved Applicants
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th></th>
                            <th scope="col">Username</th>
                            <th scope="col">Approved by</th>
                            <th scope="col">go to their</th>
                            <th>click button if</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approved as $a)
                        <tr>
                            <td scope="row">{{ $a->id }}</td>
                            <td><img src="{{ $a->avatar }}" style="width:auto; height:8vh;" /></td>
                            <td>{{ $a->username }}</td>
                            <td>{{ $a->user['username'] }}</td>
                            <td>
                                <a href="{{ url('https://twitch.tv/'.$a->username) }}"
                                    class="btn btn-secondary">channel</a>
                            </td>
                            <td>
                                <form action="{{ route('applicant.update', ['id' => $a->id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="invite">
                                    <button class="btn btn-success">Invited</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">
            {{ $approved->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
