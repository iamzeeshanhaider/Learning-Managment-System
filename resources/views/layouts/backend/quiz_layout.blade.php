<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ Config::get('settings.name') }} | QUIZ</title>
    <meta name="description" content="{{ Config::get('settings.description') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="{{ asset('jambasangsang/backend/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('jambasangsang/backend/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('jambasangsang/backend/vendors/themify-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('jambasangsang/backend/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('jambasangsang/backend/vendors/selectFX/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('jambasangsang/backend/vendors/jqvmap/dist/jqvmap.min.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('jambasangsang/backend/assets/css/style.css') }}">
    <script src="{{ asset('jambasangsang/backend/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

    {{-- Select 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- Select 2 --}}
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

</head>

@yield('css')
@flashStyle
<style>
    [x-cloak] {
        display: none !important;
    }

    body {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
</style>
@livewireStyles

</head>

<body onmousedown="return false" onselectstart="return false">

    {{-- Handle session alerts --}}
    {{ sessionAlert() }}

    <div class="quiz__container">
        @yield('content')
    </div>
    @include('layouts.backend.footer')

    @jQuery


    @livewireScripts
    @include('layouts.backend.partials.scripts')
    @stack('scripts')

    @flashScript
    @flashRender

    <script>
        $(document).ready(function() {
            $("body").on("contextmenu", function(e) {
                return false;
            });
        });
    </script>
</body>

</html>
