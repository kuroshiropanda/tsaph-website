@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row" style="height: 85vh;">
        <div class="col-md-6 h-100">
            <div class="card text-white bg-dark h-100">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Approved Applicants
                </div>
                <div class="card-body overflow-auto">
                    <div class="list-group">
                        @foreach($approved as $a)
                        <a href="{{ route('applicant', ['applicant' => $a->id]) }}" class="list-group-item list-group-item-action text-dark">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $a->name }}</h5>
                                <small>{{ $a->updated_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $a->username }}</p>
                            <small class="text-info">approved by: {{ $a->user->username }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 h-100">
            <div class="card text-white bg-dark h-100">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Invited Applicants
                </div>
                <div class="card-body overflow-auto">
                    <div class="list-group">
                        @foreach($invited as $i)
                        <a href="{{ route('applicant', ['applicant' => $i->id]) }}" class="list-group-item list-group-item-action text-dark">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $i->name }}</h5>
                                <small>{{ $i->updated_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $i->username }}</p>
                            <small class="text-info">approved by: {{ $i->user->username }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
