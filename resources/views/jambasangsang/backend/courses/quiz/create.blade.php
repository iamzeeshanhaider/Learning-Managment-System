@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb pageTitle="Quiz" previous="Courses" previousLink="{{ route('courses.index') }}" current="Create Quiz" />
@endsection
    <livewire:backend.quiz.create-quiz :course="$course" :quiz="$quiz">
@endsection
