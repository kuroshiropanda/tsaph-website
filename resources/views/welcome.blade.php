@extends('layouts.public')

@push('style')
<style>
    .tsaph-logo {
        width: 25vw;
        height: auto;
    }
</style>
@endpush

@section('content')
<div class="text-center container py-5">
    <div class="col">
        <div class="mb-5">
            <img class="img-fluid mx-auto tsaph-logo" src="{{ asset('img/tsaph.png') }}">
        </div>
    </div>
</div>
@endsection
