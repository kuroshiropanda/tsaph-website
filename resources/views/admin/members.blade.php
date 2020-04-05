@extends('layouts.app')

@push('styles')
<style>
    #members {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    #members>li>a {
        border: 1px solid #ddd;
        margin-top: -1px;
        background-color: #f6f6f6;
        padding: 12px;
        text-decoration: none;
        font-size: 32px;
        color: black;
        display: block;
    }

    #members>li>a>img {
        width: auto;
        height: 32px;
        margin-right: 10px;
    }

    #members>li>a:hover:not(.header) {
        background-color: #eee;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="card text-white bg-dark" style="height: 85vh;">
        <div class="card-header">
            <p class="m-0 p-0"><i class="fas fa-table"></i> Member List - Total Members: {{ $members->count() }}</p>
        </div>
        <div class="card-body overflow-auto">
            <div class="col">
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
    document.addEventListener('DOMContentLoaded', function() {
        $("#adminSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#members li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endpush
