@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')

<x-bread-crumb pageTitle='Support Ticket (10:00AM to 05:00PM)' previous="" previousLink="" current="Support Ticket" />

@endsection

@include('jambasangsang.backend.support.tickets.partials.data-table')

@endsection
