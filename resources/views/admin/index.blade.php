@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @canany(['invite applicants', 'update applicants'])
        <div class="card text-white bg-dark" style="height: 85vh;">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Activity Log
            </div>
            <div class="card-body overflow-auto h-100 pt-0 mt-0">
                <table class="table table-borderless table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="sticky-top" scope="col">#</th>
                            <th class="sticky-top" scope="col">user</th>
                            <th class="sticky-top" scope="col">Description</th>
                            <th class="sticky-top" scope="col">Activity</th>
                            <th class="sticky-top" scope="col">by</th>
                            <th class="sticky-top" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $a)
                        <tr>
                            <td scope="row">{{ $a->id }}</td>
                            <td>{{ $a->changes['attributes']['username'] }}</td>
                            <td>
                                @if(!isset($a->changes['old']))
                                Deleted
                                @elseif($a->changes['attributes']['approved'] == 1 && $a->changes['old']['approved'] == 0)
                                Approved
                                @elseif($a->changes['attributes']['denied'] == 1 && ($a->changes['old']['denied'] == 0 || $a->changes['old']['denied'] == 1))
                                Denied
                                @elseif($a->changes['attributes']['invited'] == 1 && $a->changes['old']['invited'] == 0)
                                Invited / New Member
                                @else
                                Updated info
                                @endif
                            </td>
                            <td>
                                @if($a->description === 'updated')
                                Processed
                                @elseif($a->description === 'created')
                                Applied
                                @else
                                Deleted
                                @endif
                            </td>
                            <td>
                            @if($a->causer != NULL)
                            {{ $a->causer['username'] }}
                            @endif
                            </td>
                            <td>{{ $a->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer small text-muted">
                {{ $activities->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    @else
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
        <p class="lead display-4 font-weight-bold text-center text-uppercase">
        please contact kuroshiropanda to gain access
        </p>
    </div>
    @endcanany
</div>
@endsection
