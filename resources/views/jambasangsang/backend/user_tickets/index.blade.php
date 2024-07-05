@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
<x-bread-crumb pageTitle='User Support Tickets' previous="" previousLink="" current="User Support Tickets" />

@endsection
    @include('jambasangsang.backend.user_tickets.table')
    @endsection

