@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle='Activity Logs'
        previous=""
        previousLink=""
        current="Activity Logs"
    />
@endsection

@include('jambasangsang.backend.activity_logs.partials.data-table')

@endsection


