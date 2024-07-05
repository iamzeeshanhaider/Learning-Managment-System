<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ Config::get('settings.name') }} | {{ Config::get('settings.description') }}</title>
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
    @include('layouts.backend.partials.scripts')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

@flashStyle
@yield('css')

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@livewireStyles

</head>

<body>
    {{-- Handle session alerts --}}
    {{ sessionAlert() }}
    {{-- Handle session alerts --}}

    <!-- Left Panel -->
    @include('layouts.backend.sidebar')
    <!-- Left Panel -->

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">

        <!-- Header-->
        @include('layouts.backend.header')
        <!-- Header-->

        @yield('breadcrumbs')

        <div class="mt-3 content">

            @yield('content')

        </div> <!-- .content -->
    </div>
    <!-- Right Panel -->

    @include('layouts.backend.footer')

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}
    @jQuery
    @flashScript
    @flashRender
    @livewireScripts
    @livewireCalendarScripts

    @stack('scripts')
    @include('layouts.backend.partials.modal')

</body>

</html>
