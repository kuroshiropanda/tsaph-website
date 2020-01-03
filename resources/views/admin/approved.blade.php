@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
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
                                <th scope="col" style="width:20%;">Username</th>
                                <th scope="col" style="width:20%;">Approved by</th>
                                <th scope="col" style="width:15%;">go to their</th>
                                <th scope="col" style="width:15%;">click button if</th>
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
                                        <input type="hidden" name="api_token" value="{{ Auth::user()->api_token }}">
                                        <input type="hidden" value="invite">
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