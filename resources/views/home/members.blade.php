@extends('layouts.public')

@push('style')
<style>
    #members {
        list-style-type: none;
        padding: 0;
        margin: 0;
        height: 80vh;
    }

    #members li a {
        border: 1px solid #ddd;
        margin-top: -1px;
        background-color: #f6f6f6;
        padding: 12px;
        text-decoration: none;
        font-size: 28px;
        color: black;
        display: block;
    }

    #members li a img {
        width: auto;
        height: 28px;
        margin-right: 10px;
    }

    #members li a:hover:not(.header) {
        background-color: #AAA;
    }
</style>
@endpush

@section('content')
<div class="container">
    <input type="text" id="search" class="form-control" placeholder="Search..">
    <div class="row">
        <div id="memberlist" class="col">
            <ul id="members" class="overflow-auto">
                @foreach($members as $m)
                <li>
                    <a href="https://twitch.tv/{{ $m->username }}" target="_blank">
                        <img src="{{ $m->avatar }}">
                        {{ $m->username }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $(() => {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#members li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    });
</script>
@endpush
