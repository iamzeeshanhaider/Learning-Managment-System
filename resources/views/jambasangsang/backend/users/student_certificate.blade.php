@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb pageTitle="{{ ucwords($user->name) }} - Certificate" previous="Users"
        previousLink="{{ url()->previous() }}" current="{{ ucwords($user->name) }}" />
@endsection
<div class="card border-0">
    <div class="card-title border-0">
        <div class="text-right">
            <a class="btn btn-sm btn-primary text-white" href="{{ route('users.show', ['group' => 'student', 'user' => $user->slug, 'v' => 'record']) }}"><i
                    class="fa fa-arrow-left"></i>
                @lang('Go Back')</a>
        </div>
    </div>

    @include('jambasangsang.backend.certificate.show')
</div>
@endsection
