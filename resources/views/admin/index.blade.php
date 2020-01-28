@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-dark" style="height: 88vh;">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Activity Log
                </div>
                <div class="card-body" style="height: 100%; overflow-y: auto;">
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th scope="col" style="width:10%;">#</th>
                                <th scope="col" style="width:20%;">user</th>
                                <th scope="col" style="width:20%;">Description</th>
                                <td scope="col" style="width:30%;">Activity</th>
                                <th scope="col" style="width:20%;">by</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $a)
                            <tr>
                                <th scope="row">{{ $a->id }}</th>
                                <td>{{ $a->changes['attributes']['username'] }}</td>
                                <td>
                                    @if($a->changes['attributes']['approved'] == 1 && $a->changes['old']['approved'] ==
                                    0)
                                    Approved
                                    @elseif($a->changes['attributes']['denied'] == 1 && $a->changes['old']['denied'] ==
                                    0)
                                    Denied
                                    @elseif($a->changes['attributes']['invited'] == 1 && $a->changes['old']['invited']
                                    == 0)
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
        </div>
        <div class="col-3">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- side ad -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7308274596514016"
                data-ad-slot="2676642727" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});

            </script>
        </div>
    </div>
</div>
@endsection
