@extends('layouts.backend.master')
@section('content')
@section('breadcrumbs')
    <x-bread-crumb pageTitle='' previous="" previousLink="" current="Live Chat" />
@endsection

<div class="card-header bg-light">
    <strong class="card-title">@lang('Start Live Chat with Team')</strong>
</div>


@livewire('live-chat-wire')

{{-- @livewire('chat.create-chat') --}}
{{-- @livewire('chat.main')  --}}

@endsection
