@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <div class="py-3 h1">{{ __('Reset Password') }}</div>

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3 form-group">
            {{-- <label for="email" class="col-form-label">{{ __('Email Address') }}</label> --}}

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email Address"
                value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 form-group">
            {{-- <label for="password" class="col-form-label">{{ __('Password') }}</label> --}}

            <input type="password" name="password" placeholder="Password" autocomplete="new-password"
                class="form-control @error('password') is-invalid @enderror" />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 form-group">
            {{-- <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label> --}}

            <input type="password" id="password-confirm" name="password_confirmation" placeholder="Confirm Password"
                autocomplete="new-password" class="form-control @error('password_confirmation') is-invalid @enderror" />
            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="py-3">
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn px-4 btn-outline-light">{{ __('Reset Password') }}</button>
            </div>
        </div>
    </form>
@endsection
