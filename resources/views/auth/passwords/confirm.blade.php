@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="h1 py-3">{{ __('Confirm Password') }}</div>

        {{ __('Please confirm your password before continuing.') }}

        <div class="form-group mb-3">
            <label for="password" class="col-form-label">{{ __('Password') }}</label>

            <input type="password" name="password" placeholder="Password" autocomplete="password"
                class="form-control @error('password') is-invalid @enderror" />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="py-3">
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn px-4 btn-outline-light">{{ __('Confirm Password') }}</button>
                @if (Route::has('password.request'))
                    <a class="text-white" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
@endsection
