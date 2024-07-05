@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Events"
        previous=""
        previousLink=""
        current="Events"
    />
@endsection
@include('jambasangsang.backend.events.partials.data-table')
@endsection


