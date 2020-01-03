@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
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
                                <th scope="col" style="width:40%;">Username</th>
                                <th scope="col" style="width:30%;">by</th>
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
                <div class="card-footer small text-muted">
                    {{ $denied->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
        <div class="col-3">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- side ad -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7308274596514016"
                data-ad-slot="2676642727" data-adtest="on" data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
</div>
@endsection
