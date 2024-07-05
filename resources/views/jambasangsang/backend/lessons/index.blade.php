@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Lessons"
        previous=""
        previousLink=""
        current="Lessons List"
    />
@endsection
@include('jambasangsang.backend.lessons.partials.data-table')
@endsection


