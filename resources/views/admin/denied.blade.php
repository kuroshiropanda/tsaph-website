@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card text-white bg-dark" style="height: 85vh;">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Denied Applicants
        </div>
        <div class="card-body h-100 overflow-auto pt-0 mt-0">
            <table class="table table-borderless table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="sticky-top" scope="col">#</th>
                        <th class="sticky-top" scope="col"></th>
                        <th class="sticky-top" scope="col">Username</th>
                        <th class="sticky-top" scope="col">Discord</th>
                        <th class="sticky-top" scope="col">Denied by</th>
                        <th class="sticky-top" scope="col">Form</th>
                        <th class="sticky-top" scope="col">reason</th>
                        <th class="sticky-top" scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($denied as $d)
                    <tr>
                        <td scope="row">{{ $d->id }}</td>
                        <td><img src="{{ $d->avatar }}" style="width:auto; height:8vh;" /></td>
                        <td><a href="{{ url('https://twitch.tv/'.$d->username) }}" target="_blank" class="btn btn-outline-info">{{ $d->username }}</a></td>
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
                                            <div class="list-group">
                                                @foreach($d->reason as $reason)
                                                <div class="list-group-item">
                                                    <p class="mb-1">{{ $reason->reason }}</p>
                                                    <small>{{ $reason->created_at->diffForHumans() }}</small>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $d->updated_at->diffForHumans() }}</td>
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
