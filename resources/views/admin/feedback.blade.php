@extends('layouts.app')

@section('content')
<div class="container-fluid" style="height: 85vh;">
    <div class="card text-white bg-dark h-100">
        <div class="card-header">
            <p class="m-0 p-0"><i class="fas fa-table"></i> Feedback - Current Feedback Total: {{ $feedbacks->count() }}</p>
        </div>
        <div class="card-body h-100 overflow-auto pt-0 mt-0">
            <table id="applicants" class="table table-borderless table-hover">
                <thead class="thead-light">
                    <tr>
                        <th class="sticky-top" scope="col">Name</th>
                        <th class="sticky-top" scope="col">Message</th>
                        <th class="sticky-top" scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feedbacks as $f)
                        <tr>
                            <td>{{ $f->name ? $f->name : null }}</td>
                            <td>{{ $f->message }}</td>
                            <td>{{ $f->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
