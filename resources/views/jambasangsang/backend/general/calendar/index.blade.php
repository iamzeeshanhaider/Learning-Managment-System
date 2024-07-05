@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb pageTitle="Calendar" previous="" previousLink="" current="Calendar" />
@endsection
<livewire:general-calendar
    before-calendar-view="/jambasangsang/backend/general/calendar/before"
    :drag-and-drop-enabled="false"
    :event-click-enabled="false"
/>
@endsection
