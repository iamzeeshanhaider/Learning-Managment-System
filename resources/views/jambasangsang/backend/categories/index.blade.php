@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle='Categories'
        previous=""
        previousLink=""
        current="Categories"
    />
@endsection

@include('jambasangsang.backend.categories.partials.data-table')
@endsection


