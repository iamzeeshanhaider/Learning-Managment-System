@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="h1 pb-3">{{ __('Login') }}</div>

        <div class="form-group mb-3">
            {{-- <label for="email" class="col-form-label">{{ __('Email Address') }}</label> --}}

            <input type="email" name="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', request()->get('email') ?? '') }}" autocomplete="email" autofocus />
            @error('email')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            {{-- <label for="password" class="col-form-label">{{ __('Password') }}</label> --}}

            <input type="password" name="password" placeholder="Password" autocomplete="password"
                class="form-control @error('password') is-invalid @enderror" />
            @error('password')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3 d-none">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="py-3">
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn px-4 btn-outline-light">{{ __('Login') }}</button>
                @if (Route::has('password.request'))
                    <a class="text-white" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>

    </form>
@endsection
