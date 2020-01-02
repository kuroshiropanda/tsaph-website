@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-white bg-dark" style="height: 83vh;">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Member List
            @can('edit roles')
                <button type="button" id="updateMembers" class="btn btn-primary">UPDATE</button>
            @endcan
        </div>
        <div class="card-body" style="height: 100%; overflow-y: auto;">
            <div class="col-12">
                <ul id="members">
                    @foreach($members as $m)
                    <li>
                        <a href="https://twitch.tv/{{ $m->username }}">
                            <img src="{{ $m->avatar }}">
                            {{ $m->username }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $("#adminSearch").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#members li").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('#updateMembers').click(function (event) {
            event.preventDefault();
            initialize();
        });

        var clientId = 'c9kjxs4tawdkqnnpg2lpzkraceam6g';

        var xhttp = new XMLHttpRequest();

        function initialize() {
            xhttp.addEventListener('load', initializeMembers);
            xhttp.open('GET', 'https://api.twitch.tv/kraken/teams/tsaph');
            xhttp.setRequestHeader('Client-ID', clientId);
            xhttp.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json');
            xhttp.send();
        }

        function initializeMembers() {
            memList = JSON.parse(xhttp.responseText);
            memLength = memList.users.length;

            var data = [];
            for (i = 0; i < memLength; i++) {
                data.push({
                    'twitch_id': memList.users[i]._id,
                    'username': memList.users[i].name,
                    'avatar': memList.users[i].logo
                });
            }

            $.ajax({
                url: '/api/members/update',
                data: {
                    data: data,
                    'api_token': '{{ Auth::user()->api_token }}'
                },
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
    });

</script>
<!-- <script src="{{ asset('js/members.js') }}"></script> -->
@endpush
