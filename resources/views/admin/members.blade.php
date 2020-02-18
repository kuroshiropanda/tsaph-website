@extends('layouts.app')

@push('styles')
<style>
    #members {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    #members > li > a {
        border: 1px solid #ddd;
        margin-top: -1px;
        background-color: #f6f6f6;
        padding: 12px;
        text-decoration: none;
        font-size: 32px;
        color: black;
        display: block;
    }

    #members > li > a > img {
        width: auto;
        height: 32px;
        margin-right: 10px;
    }

    #members > li > a:hover:not(.header) {
        background-color: #eee;
    }

</style>
@endpush

@section('content')
<div class="container">
    <div class="card text-white bg-dark" style="height: 88vh;">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Member List
            @can('edit roles')
            <button type="button" id="updateMembers" class="btn btn-primary">UPDATE</button>
            @endcan
        </div>
        <div class="card-body" style="height: 100%; overflow-y: auto;">
            <div class="row">
                <div class="col">
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle" style="display:block" data-ad-format="fluid"
                        data-ad-layout-key="-h2+d+5c-9-3e" data-ad-client="ca-pub-7308274596514016"
                        data-ad-slot="3012804204"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});

                    </script>
                </div>
            </div>
            <div class="row">
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
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $("#adminSearch").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#members li").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('#updateMembers').click(function (event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('members.update') }}',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                complete: function () {
                    window.location.reload(true);
                }
            });
        });
    });
</script>
@endpush
