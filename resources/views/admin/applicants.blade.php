@extends('layouts.app')

@section('content')
<div class="container-fluid" style="height: 85vh;">
    <div class="card text-white bg-dark h-100">
        <div class="card-header">
            <p class="m-0 p-0"><i class="fas fa-table"></i> Applicants - Current Applicants Total: {{ $applicants->count() }}</p>
        </div>
        <div class="card-body h-100 overflow-auto">
            <table id="applicants" class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col">Username</th>
                        <th scope="col">Discord</th>
                        <th scope="col">Form</th>
                        @can('edit roles')
                        <th>Update</th>
                        <th>Twitch</th>
                        <th>Discord</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($applicants as $a)
                    <tr>
                        <td scope="row">{{ $a->id }}</td>
                        <td><img src="{{ $a->avatar }}" style="width:auto; height:8vh;" />
                        </td>
                        <td><a href="{{ url('https://twitch.tv/'.$a->username) }}" target="_blank" class="btn btn-outline-info">{{ $a->username }}</a></td>
                        <td>{{ $a->discord }}</td>
                        <td>
                            <a href="{{ route('applicant', ['applicant' => $a->id]) }}" class="btn btn-primary">Form</a>
                        </td>
                        @can('edit roles')
                        <td>
                            <form action="{{ route('applicant.data', ['applicant' => $a->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary"><i class="fas fa-download"></i></button>
                            </form>
                        </td>
                        <form action="{{ route('applicant.update', ['applicant' => $a->id]) }}" method="POST">
                            @csrf
                            <td>
                                <div class="form-group">
                                    <!-- <label for="username">Twitch Name</label> -->
                                    <input type="text" class="form-control" id="username" name="username">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <!-- <label for="discord">Discord</label> -->
                                    <input type="text" class="form-control" id="discord" name="discord">
                                </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-warning"><i class="far fa-edit"></i></button>
                            </td>
                        </form>
                        <td>
                            <form action="{{ route('applicant.delete', ['applicant' => $a->id]) }}" method="POST">
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
