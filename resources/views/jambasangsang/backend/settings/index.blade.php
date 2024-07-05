@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Settings"
        previous=""
        previousLink=""
        current="Settings"
    />
@endsection

@include('jambasangsang.backend.settings.table')

@endsection
