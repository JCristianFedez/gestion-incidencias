@extends('layouts.app')

@section('content')
<div class="row d-felx justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <div class="card shadow-lg">
            <div class="card-header bg-gradient-primary text-white h4">{{ __('Confirm Password') }}</div>

            <div class="card-body">
                {{ __('Please confirm your password before continuing.') }}

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>

                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-block shadow">
                            {{ __('Confirm Password') }}
                        </button>
                    </div>

                    <div class="form-group mb-0">
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection