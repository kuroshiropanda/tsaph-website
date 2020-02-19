@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card text-white bg-dark" style="height: 88vh;">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Approved Applicants
        </div>
        <div class="card-body" style="height: 100%; overflow-y: auto;">
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="width:10%;">#</th>
                        <th scope="col" style="width:20%;"></th>
                        <th scope="col" style="width:15%;">Username</th>
                        <th scope="col" style="width:15%;">Discord</th>
                        <th scope="col" style="width:10%;">Approved by</th>
                        <th scope="col" style="width:10%;">Form</th>
                        <th scope="col" style="width:10%;">channel</th>
                        <th scope="col" style="width:10%;">click button if</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($approved as $a)
                    <tr>
                        <td scope="row">{{ $a->id }}</td>
                        <td><img src="{{ $a->avatar }}" style="width:auto; height:8vh;" /></td>
                        <td>{{ $a->username }}</td>
                        <td>{{ $a->discord }}</td>
                        <td>{{ $a->user->username }}</td>
                        <td><a href="{{ route('applicant', ['applicant' => $a->id]) }}" class="btn btn-primary">Form</a></td>
                        <td>
                            <a href="{{ url('https://twitch.tv/'.$a->username) }}"
                                class="btn btn-secondary">channel</a>
                        </td>
                        <td>
                            <form action="{{ route('applicant.process', ['applicant' => $a->id, 'update' => 'invite']) }}" method="POST">
                                @csrf
                                <button class="btn btn-success">Invited</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer small text-muted">
            {{ $approved->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
