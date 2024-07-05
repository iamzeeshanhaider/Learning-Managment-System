@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb pageTitle="Resource Collections" previous="Lessons" previousLink="{{ route('lessons.index') }}"
        current="Resource Collections" />
@endsection
@if ($resource_not_in_folder)
    <div class="text-right px-3">
        <a href="{{ route('lesson.resource.unlisted', ['lesson' => $lesson->slug]) }}" class="small">
            View Resources Not Assigned to A folder
        </a>
    </div>
@endif
<div class="container">
    @include('jambasangsang.backend.lessons.folders.partials.data')
</div>
@endsection
