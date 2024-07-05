@extends('layouts.app')

@section('content')
    <div class="container d-flex align-items-center align-content-center" style="height: 100vh;">
        <div class="col-md-6 text-center">
            <a class="navbar-brand" href="{{ route('dashboard') }}"><img src="{{ Config::get('settings.logo') }}" height="200px"
                    width="200px" alt="Logo"></a>
        </div>
        <div class="col-md-6 m-auto">
            <div class="card border-0 shadow-lg rounded">

                <div class="card-body">
                    <div class="h4 py-3">{{ __('Verify Your Email Address') }}</div>

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <div class="text-center">
                            <button type="submit" class="btn btn-bd-download main-btn">{{ __('Click here to request another') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
