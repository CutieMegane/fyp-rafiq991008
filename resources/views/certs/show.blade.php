@extends('base')

@section('content')
<script>
    document.getElementById('nav1').classList.remove('active');
    document.getElementById('nav2').classList.remove('active');
    document.getElementById('nav3').classList.remove('active');
</script>

<title>Verify Certificates - eCert Signing System</title>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Certificate issued for {{ $cert -> name  }}.</div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <label for="details" class="col-md-4 col-form-label text-md-end">{{ __('Event details') }}</label>

                            <div class="col-md-6">
                                <textarea id="details" type="text" class="form-control-plaintext" rows="4" name="details" disabled">{{ $cert -> details }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="created_at" class="col-md-4 col-form-label text-md-end">{{ __('Issued at') }}</label>

                            <div class="col-md-6">
                                <label id="created_at" type="text" class="form-control" name="created_at" ">{{ $cert -> created_at }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="col-md-4 col-form-label">{{ __('Email') }}</label>
                                <label id="email" type="text" class="form-control" name="email" ">
                                    @if ($cert -> email)
                                    {{$cert -> email}}
                                    @else
                                      empty
                                    @endif
                                </label>
                            </div>

                            <div class="col-md-6">
                                <label for="phone_no" class="col-md-4 col-form-label ">{{ __('Contact') }}</label>
                                <label id="phone_no" type="text" class="form-control" name="phone_no" ">
                                    @if ($cert -> phone_no)
                                    {{$cert -> phone_no}}
                                    @else
                                     empty
                                    @endif
                                </label>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">

                                <a class="btn btn-outline-secondary" href="{{ URL::previous()}}">
                                    Back
                                </a>
                                  <a class="btn btn-outline-secondary" data-bs-toggle="collapse" href="#aCollapse" role="button" aria-expanded="false" aria-controls="aCollapse">
                                    Additional details
                                </a>
                            </div>
                        </div>

                        <div class="collapse mt-4" id="aCollapse">
                            <div class="row">
                                <label for="hash" class="col-md col-form-label">{{ __('Certificate image hash') }}</label>
                            </div>

                            <div class="row mb-3 pl-3">
                                <label id="hash" type="text" class="form-control" name="hash" ">{{ $cert -> hash }}</label>
                            </div>

                            <div class="row">
                                <label for="stego_mark" class="col-md col-form-label">{{ __('Secret text') }}</label>
                            </div>

                            <div class="row mb-3 pl-3">
                                <label id="stego_mark" type="text" class="form-control" name="stego_mark" ">{{ $cert -> stego_mark }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection