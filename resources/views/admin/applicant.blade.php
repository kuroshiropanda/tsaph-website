@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="card" style="width: auto;">
                <img src="{{ $applicant->avatar ?? '' }}" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title text-dark">Info</h5>
                    <p class="card-text text-dark">Name: {{ $applicant->name }}</p>
                    <p class="card-text text-dark">Twitch: {{ $applicant->username }}</p>
                    <p class="card-text text-dark">Discord: {{ $applicant->discord }}</p>
                    <p class="card-text text-dark font-weight-bold">
                        @foreach($types as $t)
                            {{ $t->type }}
                        @endforeach
                    </p>
                    <div class="row">
                        <div class="col d-flex justify-content-start">
                            <form action="{{ route('applicant.update', ['id' => $applicant->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="api_token" value="{{ Auth::user()->api_token }}">
                                <input type="hidden" name="id" value="{{ $applicant->id }}">
                                <input type="hidden" name="update" value="approve">
                                <button type="submit" class="btn btn-primary">Approve</button>
                            </form>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <form action="{{ route('applicant.update', ['id' => $applicant->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="api_token" value="{{ Auth::user()->api_token }}">
                                <input type="hidden" name="id" value="{{ $applicant->id }}">
                                <input type="hidden" name="update" value="deny">
                                <button type="submit" class="btn btn-danger">Deny</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col accordion" id="qna" style="height: 89vh; overflow-y: auto;">
            @foreach($answers as $a)
            <div class="card bg-dark">
                <div class="card-header bg-dark text-white" id="heading{{ $loop->iteration }}">
                    <h2 class="mb-0">
                        <button class="btn btn-dark collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse{{ $loop->iteration }}" aria-expanded="false"
                            aria-controls="collapse{{ $loop->iteration }}">
                            {{ \App\Question::find($a->pivot->question_id)->question }}
                        </button>
                    </h2>
                </div>
                <div id="collapse{{ $loop->iteration }}" class="collapse"
                    aria-labelledby="heading{{ $loop->iteration }}" data-parent="#qna">
                    <div class="card-body bg-secondary">
                        {{ $a->answer }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-3">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- side ad -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7308274596514016"
                data-ad-slot="2676642727" data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});

            </script>
        </div>
    </div>
</div>
@endsection
