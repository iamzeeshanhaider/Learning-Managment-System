@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb pageTitle="Lessons Resources" previous="Resource Collection"
        previousLink="{{ route('lesson.folder.index', ['lesson' => $lesson->slug]) }}" current="Lesson Resources" />
@endsection
<div class="col-md-12">
    <div class="card border-0">
        <div class="card-header bg-light border-bottom">
            <strong class="card-title" title="{{ $lesson->name }}">@lang('Resources for:')
                {{ str_limit($lesson->name, 80) }}</strong>
            @if ($folder)
                <a onclick="handleGeneralModal(this)"
                    data-link="{{ route('lesson.resource.create', ['lesson' => $lesson->slug, 'folder' => $folder->slug]) }}"
                    type="button" class="text-white pull-right btn btn-sm btn-success">@lang('New Lesson Resource')</a>
            @endif
        </div>
        <div class="card-body">
            <livewire:backend.lesson-resource-table :lesson="$lesson" :folder="$folder" />
        </div>
    </div>
</div>
@endsection
