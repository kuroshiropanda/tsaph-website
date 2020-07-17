@extends('layouts.app')

@section('content')
<div class="container-fluid" style="height: 85vh;">
    <div class="card text-white bg-dark h-100">
        <div class="card-header">
            <p class="m-0 p-0"><i class="fas fa-table"></i> Applicants - Current Applicants Total: {{ $applicants->count() }}</p>
        </div>
        <div class="card-body h-100 overflow-auto pt-0 mt-0">
            <table id="applicants" class="table table-borderless table-hover">
                <thead class="thead-light">
                    <tr>
                        <th class="sticky-top" scope="col">#</th>
                        <th class="sticky-top" scope="col"></th>
                        <th class="sticky-top" scope="col">Username</th>
                        <th class="sticky-top" scope="col">Discord</th>
                        <th class="sticky-top" scope="col">Form</th>
                        @can('edit roles')
                        <th class="sticky-top">Delete</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($applicants as $a)
                    <tr>
                        <td scope="row">{{ $a->id }}</td>
                        <td><img src="{{ $a->avatar }}" loading="lazy" style="width:auto; height:8vh;" />
                        </td>
                        <td><a href="{{ url('https://twitch.tv/'.$a->username) }}" target="_blank" class="btn btn-outline-info">{{ $a->username }}</a></td>
                        <td>{{ $a->discordData->username }}</td>
                        <td>
                            <a href="{{ route('applicant.show', ['applicant' => $a->username]) }}" class="btn btn-primary">Form</a>
                        </td>
                        @can('edit roles')
                        <td>
                            <form action="{{ route('applicant.destroy', ['applicant' => $a->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $("#adminSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#applicants tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endpush
