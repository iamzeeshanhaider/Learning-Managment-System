@extends('layouts.backend.master')


@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Dashboard"
        previous=""
        previousLink=""
        current="Dashboard"
    />
@endsection



@section('content')
    <div class="row">
        @if (auth()->user()->hasRole('Student'))
            @include('jambasangsang.backend.users.student_home')
        @else
            @include('jambasangsang.backend.users.admin_home')
        @endif
    </div>
@endsection

@section('script')
    <script src="{{ asset('jambasangsang/backend/vendors/chart.js/dist/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/assets/js/widgets.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/vendors/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <script src="{{ asset('jambasangsang/backend/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
@endsection
