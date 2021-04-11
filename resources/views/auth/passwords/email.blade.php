@extends('layouts.app')

@section('content')
<div class="row d-felx justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-primary text-white h4">{{ __('Reset Password') }}</div>

            <div class="card-body">
                @include('layouts.includes.messages.status')

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">{{ __('E-Mail Address') }}</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-info btn-block shadow">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection