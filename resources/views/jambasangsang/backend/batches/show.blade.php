@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle='Batche View'
        previous="Batches"
        previousLink="{{ route('batches.index') }}"
        current="{{ $batch->name }}"
    />
@endsection

<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">@lang('Preveiw Batch ') - {{ $batch->name }}</strong>
                    <a
                        onclick="handleGeneralModal(this)"
                        data-link="{{ route('batches.edit', $batch->slug) }}"
                        type="button"
                        class="text-white pull-right btn btn-sm btn-success"
                    >@lang('Edit Batch')</a>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <h5 class="mt-3 card-title">Name:</h5>
                        <span class="card-title">{!! $batch->name !!}</span>

                        <h5 class="mt-3 card-title">Description:</h5>
                        <span class="card-title">{!! $batch->description !!}</span>

                        <div class="weather-category twt-category">
                            <hr>
                            <ul>
                                <li>
                                    <a href="{{ route('users.index', ['group' => 'student', 'batch_filter' => $batch->slug]) }}" title="Linked Courses">
                                        <span class="h5">{{ $batch->students->count() }}</span>
                                        <br>
                                        Enrolled Students
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="">
                                        {{--  --}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">@lang('Manage Meet Sessions')</strong>
                </div>
                <div class="card-body">
                    <livewire:backend.google.event student="null" batch="{{ $batch->id }}" />
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


