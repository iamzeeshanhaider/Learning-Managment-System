@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Locations"
        previous=""
        previousLink=""
        current="Locations"
    />
@endsection
@include('jambasangsang.backend.locations.partials.data-table')
@endsection


