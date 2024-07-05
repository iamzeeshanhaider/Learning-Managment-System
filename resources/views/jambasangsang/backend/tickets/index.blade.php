@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
<x-bread-crumb pageTitle='Support Ticket List' previous="" previousLink="" current="Support Tickets" />

@endsection

<div class="row">
    <div class="col-md-12 ">
        <div class="panel panel-default">
            <div class="panel-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($tickets->isEmpty())
                    <p>There are currently no tickets.</p>
                @else
                    @include('jambasangsang.backend.tickets.table')
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
