@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="{{ ucwords($user->name) }} - Dashboard"
        previous="Users"
        previousLink="{{ url()->previous() }}"
        current="{{ ucwords($user->name) }}"
    />
@endsection
    @include('jambasangsang.backend.users.partials.show_data')
@endsection
