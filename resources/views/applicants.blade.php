@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-white bg-dark" style="height: 83vh;">
        <div class="card-header">
            <i class="fas fa-table"></i>
            Applicants
        </div>
        <div class="card-body" style="height: 100%; overflow-y: auto;">
            <div class="table-responsive">
                <table id="applicants" class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th scope="col" style="width:10%;">#</th>
                            <th scope="col" style="width:30%;"></th>
                            <th scope="col" style="width:40%;">Username</th>
                            <th scope="col" style="width:10%;">go to their</th>
                            <th scope="col" style="width:10%;">open their</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applicants as $a)
                        <tr>
                            <td scope="row" style="width:10%;">{{ $a->id }}</td>
                            <td style="width:20%;"><img src="{{ $a->avatar }}" style="width:auto; height:8vh;" /></td>
                            <td style="width:30%;">{{ $a->username }}</td>
                            <td style="width:10%;">
                                <a href="{{ url('https://twitch.tv/'.$a->username) }}"
                                    class="btn btn-secondary">Channel</a>
                            </td>
                            <td style="width:10%;">
                                <a href="{{ route('applicant', ['id' => $a->id]) }}" class="btn btn-primary">Form</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
            $("#applicants tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endpush
