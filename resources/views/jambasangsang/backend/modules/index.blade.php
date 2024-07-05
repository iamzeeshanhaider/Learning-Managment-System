@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Modules"
        previous=""
        previousLink=""
        current="Modules"
    />
@endsection
@include('jambasangsang.backend.modules.partials.data-table')
@endsection


