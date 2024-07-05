@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle='Chat Requests'
        previous=""
        previousLink=""
        current="Chat Request"
    />
@endsection

@include('jambasangsang.backend.chat_requests.partials.data-table')

@endsection


