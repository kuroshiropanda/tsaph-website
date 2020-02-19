@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card text-white bg-dark" style="height: 88vh;">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Denied Applicants
        </div>
        <div class="card-body" style="height: 100%; overflow-y: auto;">
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="width:10%;">#</th>
                        <th scope="col" style="width:20%;"></th>
                        <th scope="col" style="width:15%;">Username</th>
                        <th scope="col" style="width:15%;">Discord</th>
                        <th scope="col" style="width:20%;">Denied by</th>
                        <th scope="col" style="width:10%;">Form</th>
                        <th scope="col" style="width:10%;">reason</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($denied as $d)
                    <tr>
                        <td scope="row">{{ $d->id }}</td>
                        <td><img src="{{ $d->avatar }}" style="width:auto; height:8vh;" /></td>
                        <td>{{ $d->username }}</td>
                        <td>{{ $d->discord }}</td>
                        <td>{{ $d->user->username }}</td>
                        <td><a href="{{ route('applicant', ['applicant' => $d->id]) }}" class="btn btn-primary">Form</a></td>
                        <td>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#{{ $d->username }}">Reason</button>
                            <div class="modal fade" id="{{ $d->username }}" tabindex="-1" role="dialog" aria-labelledby="{{ $d->username }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-dark" id="{{ $d->username }}Label">Reason</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-dark">
                                            {{ $d->reason->reason }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer small text-muted">
            {{ $denied->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
