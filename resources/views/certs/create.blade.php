@extends('base')

@section('content')
<script>
    document.getElementById('nav1').classList.remove('active');
    document.getElementById('nav2').classList.remove('active');
    document.getElementById('nav3').classList.remove('active');
</script>

<title>Add Certificates - eCert Signing System</title>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add new certificates.</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('certs.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Recipient Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Ali Abu Bakar" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="details" class="col-md-4 col-form-label text-md-end">{{ __('Event details') }}</label>

                            <div class="col-md-6">
                                <textarea id="details" type="text" class="form-control" rows="4" name="details" value="{{ old('details') }}" placeholder="Karnival iCTFF 2022 - Capture the Flag" ></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Recipient e-mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="ali_abu@gmail.com" >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone_no" class="col-md-4 col-form-label text-md-end">{{ __('Recipient contact no') }}</label>

                            <div class="col-md-6">
                                <input id="phone_no" type="tel" class="form-control @error('phone_no') is-invalid @enderror" name="phone_no" value="{{ old('phone_no') }}" autocomplete="tel" placeholder="0123456789"  >

                                @error('phone_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end" for="customFile">Certificate file</label>
                            <div class="col-md-6">
                                <input type="file" required class="form-control" id="image" name="image" />

                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-primary">
                                    {{ __('Add certs') }}
                                </button>

                                <a class="btn btn-outline-secondary" href="{{ route("certs.index")}}">
                                    Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection