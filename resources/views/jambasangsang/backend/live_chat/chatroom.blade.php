@extends('layouts.backend.master')
@section('content')
    <div class="card-header bg-light">
        <a href="{{ route('live_chat.create') }}"
           class="pull-right btn btn-sm btn-success">@lang('Request New Chat')</a>
    </div><br>
@livewire('chat.main')

@endsection
