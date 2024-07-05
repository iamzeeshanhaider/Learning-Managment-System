@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="h1 py-3">{{ __('Reset Password') }}</div>

        <div class="form-group mb-3">
            {{-- <label for="email" class="col-form-label">{{ __('Email Address') }}</label> --}}

            <input type="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" autocomplete="email" autofocus />
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="py-3">
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn px-4 btn-outline-light">{{ __('Send Password Reset Link') }}</button>
                @if (Route::has('password.request'))
                    <a class="text-white" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
@endsection
