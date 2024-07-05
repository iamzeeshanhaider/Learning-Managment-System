@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Courses"
        previous=''
        previousLink=""
        current="Courses"
    />
@endsection
@include('jambasangsang.backend.courses.partials.data-table')
@endsection


