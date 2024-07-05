@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb pageTitle='Attendance' previous="" previousLink="" current="Attendance" />
@endsection

<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">@lang('Attendance List')</strong>
                </div>
                <div class="card-body">
                    <livewire:backend.attendance-table />
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
