<!doctype html>
<html lang="en">

<head>

    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">


    <!--====== Title ======-->
    <title>{{ Config::get('settings.name') }} | {{ Config::get('settings.description') }}</title>
    <meta name="description" content="{{ Config::get('settings.description') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ Config::get('settings.logo') }}" type="image/png">

    <!--====== Slick css ======-->
    {{-- <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/slick.css') }}"> --}}

    <!--====== Animate css ======-->
    {{-- <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/animate.css') }}"> --}}

    <!--====== Nice Select css ======-->
    {{-- <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/nice-select.css') }}"> --}}

    <!--====== Nice Number css ======-->
    {{-- <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/jquery.nice-number.min.css') }}"> --}}

    <!--====== Magnific Popup css ======-->
    {{-- <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/magnific-popup.css') }}"> --}}

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/bootstrap.min.css') }}">

    <!--====== Fontawesome css ======-->
    {{-- <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/font-awesome.min.css') }}"> --}}

    <!--====== Default css ======-->
    {{-- <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/default.css') }}"> --}}

    <!--====== Style css ======-->
    {{-- <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/style.css') }}"> --}}

    <!--====== Responsive css ======-->
    {{-- <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/responsive.css') }}"> --}}

    @flashStyle
    @livewireStyles

    <style>
        body {
            margin: 0;
            border: 0;
            height: 100vh;
            overflow: hidden;
        }

        .content {
            width: 100%;
            height: 100vh;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-image: url({{ asset('jambasangsang/login_bg.jpg') }});
        }
    </style>
</head>

<body>

    <div class="content">
        {{ sessionAlert() }}

        <div class="container text-white d-flex justify-content-center align-items-center align-content-center"
            style="height: 100%;">

            <div class="col-8 col-md-6 col-lg-5 mx-auto">
                <div class="ml-3">
                    <div class="text-center mt-3">
                        <a class="" href="{{ route('dashboard') }}">
                            <img class="border border-white" style="border-radius: 15px;" src="{{ Config::get('settings.logo') }}" height="130px" width="130px" alt="Logo">
                        </a>
                    </div>

                    <div class="">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

    </div>

    @livewireScripts

    @flashScript
    @flashRender
</body>

</html>
