@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Courses Group"
        previous=""
        previousLink=""
        current="Courses Group"
    />
@endsection
@include('jambasangsang.backend.course_master.partials.data-table')
@endsection


