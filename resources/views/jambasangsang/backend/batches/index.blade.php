@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle='Batches'
        previous=""
        previousLink=""
        current="Batches"
    />
@endsection

@include('jambasangsang.backend.batches.partials.data-table')

@endsection


