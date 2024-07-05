@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
<x-bread-crumb pageTitle='Ticket Categories' previous="" previousLink="" current="Ticket Categories" />

@endsection

@include('jambasangsang.backend.support.category.partials.data-table')

@endsection
