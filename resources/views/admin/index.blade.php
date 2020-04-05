@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @canany(['invite applicants', 'update applicants'])
        <div class="card text-white bg-dark" style="height: 85vh;">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Activity Log
            </div>
            <div class="card-body overflow-auto h-100">
                <table class="table table-borderless table-hover">
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
                                @elseif($a->changes['attributes']['denied'] == 1 && ($a->changes['old']['denied'] == 0 || $a->changes['old']['denied'] == 1))
                                Denied
                                @elseif($a->changes['attributes']['invited'] == 1 && $a->changes['old']['invited'] == 0)
                                Invited / New Member
                                @elseif(isset($a->changes['old']['discord']) || isset($a->changes['old']['username']))
                                    @if($a->changes['old']['discord'] !== $a->changes['attributes']['discord'] && $a->changes['old']['username'] !== $a->changes['attributes']['username'])
                                        discord from: {{ $a->changes['old']['discord'] }} to: {{ $a->changes['attributes']['discord'] }}
                                        twitch from: {{ $a->changes['old']['username'] }} to: {{ $a->changes['attributes']['username'] }}
                                    @elseif($a->changes['old']['discord'] !== $a->changes['attributes']['discord'])
                                        discord from: {{ $a->changes['old']['discord'] }} to: {{ $a->changes['attributes']['discord'] }}
                                    @elseif($a->changes['old']['username'] !== $a->changes['attributes']['username'])
                                        twitch from: {{ $a->changes['old']['username'] }} to: {{ $a->changes['attributes']['username'] }}
                                    @else
                                        Updated data
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($a->description === 'updated')
                                Processed
                                @else
                                Applied
                                @endif
                            </td>
                            <td>
                            @if($a->causer != NULL)
                            {{ $a->causer['username'] }}
                            @endif
                            </td>
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
