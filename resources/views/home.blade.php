@extends('layouts.app')

@section('sidebar')
@endsection

@section('content')
<div class="container">
    <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div> -->
    <div class="card text-white bg-dark" style="height: 83vh;">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Activity Log
        </div>
        <div class="card-body" style="height: 100%; overflow-y: auto;">
            <table class="table table-borderless" style="height:100%; overflow-y:auto;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">user</th>
                        <th scope="col">Description</th>
                        <td scope="col">Activity</th>
                        <th scope="col">by</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $a)
                    <tr>
                        <th scope="row">{{ $a->id }}</th>
                        <td>{{ $a->changes['attributes']['username'] }}</td>
                        <td>
                            @if($a->changes['attributes']['approved'] == 1 && $a->changes['old']['approved'] == 0)
                            Approved
                            @elseif($a->changes['attributes']['denied'] == 1 && $a->changes['old']['denied'] == 0)
                            Denied
                            @elseif($a->changes['attributes']['invited'] == 1 && $a->changes['old']['invited'] == 0)
                            Invited
                            @else

                            @endif
                        </td>
                        <td>
                            @if($a->description == 'updated')
                            Processed
                            @else
                            Applied
                            @endif
                        </td>
                        <td>{{ $a->causer['username'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer small text-muted">
            {{ $activities->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
