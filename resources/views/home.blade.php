@extends('base')

@section('content')
<title>Verify - eCert Signing System</title>
<script>
    document.getElementById('nav1').classList.add('active');
    document.getElementById('nav2').classList.remove('active');
    document.getElementById('nav3').classList.remove('active');
</script>

@if ($message = Session::get('success2'))
<div class="alert alert-danger">
    <p>{{ $message }}</p>
</div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Please upload the certificate to start</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('certs.validate') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end" for="customFile">Certificate file</label>
                            <div class="col-md-6">
                                <input type="file" required class="form-control" id="file" name="file" />

                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-secondary">
                                    {{ __('Verify :)') }}
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection