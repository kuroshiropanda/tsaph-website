@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-9">
            <div class="card text-white bg-dark" style="height: 88vh;">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Applicants
                </div>
                <div class="card-body" style="height: 100%; overflow-y: auto;">
                    <table id="applicants" class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th scope="col" style="width:10%;">#</th>
                                <th scope="col" style="width:20%;"></th>
                                <th scope="col" style="width:20%;">Username</th>
                                <th scope="col" style="width:20%;">Discord</th>
                                <th scope="col" style="width:15%;">go to their</th>
                                <th scope="col" style="width:15%;">open their</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applicants as $a)
                            <tr>
                                <td scope="row">{{ $a->id }}</td>
                                <td><img src="{{ $a->avatar }}" style="width:auto; height:8vh;" />
                                </td>
                                <td>{{ $a->username }}</td>
                                <td>{{ $a->discord }}</td>
                                <td>
                                    <a href="{{ url('https://twitch.tv/'.$a->username) }}"
                                        class="btn btn-secondary">Channel</a>
                                </td>
                                <td>
                                    <a href="{{ route('applicant', ['id' => $a->id]) }}"
                                        class="btn btn-primary">Form</a>
                                </td>
                                <td>
                                    <form action="{{ route('applicant.delete', ['id' => $a->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $("#adminSearch").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#applicants tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

</script>
@endpush
