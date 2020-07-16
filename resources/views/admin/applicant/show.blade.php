@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @error('h-captcha-response')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div class="row mt-2" style="height: 85vh;">
        <div class="col-md-3">
            <div class="card">
                <img src="{{ $applicant->avatar ?? '' }}" class="card-img-top">
                <div class="card-body text-dark">
                    <h5 class="card-title">Name: {{ $applicant->name }}</h5>
                    <p class="card-text">Twitch: <a class="text-info" href='{{ url("https://twitch.tv/{$applicant->username}") }}' target="_blank" rel="noopener noreferrer">{{ $applicant->username }}</a></p>
                    <p class="card-text">Discord: {{ $applicant->discordData->username }}</p>
                    <p class="card-text font-weight-bold">
                        @foreach($types as $t)
                        {{ $t->type }}
                        @endforeach
                    </p>
                    <div class="row">
                        @if(($applicant->denied === 1 || $applicant->denied === 0) && $applicant->approved === 0)
                        <div class="col d-flex justify-content-center">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal">Approve</button>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#denyModal">Deny</button>
                        </div>
                        @endif
                        <div class="col d-flex justify-content-start">
                            <a class="btn btn-warning" href="{{ route('applicant.edit', ['applicant' => $applicant->id]) }}">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 mt-2">
            <div class="accordion overflow-auto" id="qna">
                @foreach($answers as $a)
                <div class="card bg-dark">
                    <div class="card-header bg-dark text-white" id="heading{{ $loop->iteration }}">
                        <h2 class="mb-0">
                            <button class="btn btn-dark collapsed" type="button" data-toggle="collapse" data-target="#collapse{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapse{{ $loop->iteration }}">
                                {{ \App\Question::find($a->pivot->question_id)->question }}
                            </button>
                        </h2>
                    </div>
                    <div id="collapse{{ $loop->iteration }}" class="collapse" aria-labelledby="heading{{ $loop->iteration }}" data-parent="#qna">
                        <div class="card-body bg-secondary">
                            {{ $a->answer }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="approveModalLabel">Approve Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('applicant.process', ['applicant' => $applicant->id, 'update' => 'approve']) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="h-captcha @error('h-captcha-response') is-invalid @enderror" data-theme="dark" data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
                        @error('h-captcha-response')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="denyModal" tabindex="-1" role="dialog" aria-labelledby="denyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="denyModalLabel">Deny Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="denyForm" action="{{ route('applicant.process', ['applicant' => $applicant->id, 'update' => 'deny']) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reason" class="text-dark">Reason?</label>
                        <textarea id="reason" class="form-control" name="reason" required>{{ old('reason') }}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="h-captcha @error('h-captcha-response') is-invalid @enderror" data-theme="dark" data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
                        @error('h-captcha-response')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="formReset()" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Deny</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function formReset() {
        document.getElementById("denyForm").reset();
    }
</script>
@endpush
