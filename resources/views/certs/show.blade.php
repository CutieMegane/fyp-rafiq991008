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
                <div class="card-header">Certificate for {{ $cert -> name  }}</div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <label for="details" class="col-md-4 col-form-label text-md-end">{{ __('Details') }}</label>

                            <div class="col-md-6">
                                <textarea id="details" type="text" class="form-control" rows="4" name="details" disabled">{{ $cert -> details }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">

                                <a class="btn btn-outline-secondary" href="{{route("home")}}">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection