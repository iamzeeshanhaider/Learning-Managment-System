@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Lessons Resources"
        previous="Lessons"
        previousLink="{{ route('lesson.resource.show', ['lesson' => $lesson->slug, 'resource' => $lesson_resource->slug]) }}"
        current="Lessons - {{ $lesson_resource->name }}"
    />
@endsection
{{-- Show in modal based on type --}}
@switch($lesson_resource->type)
    @case(\App\Enums\LessonType::Document)
        {{-- Display Document --}}
        Display Document
        @break
    @case(\App\Enums\LessonType::Slide)
        {{-- Display Slide --}}
        Display Slide
        @break
    @case(\App\Enums\LessonType::Video)
        {{-- Display Video --}}
        Display Video
        @break
    @default

@endswitch
{{ $lesson_resource }}
@endsection


