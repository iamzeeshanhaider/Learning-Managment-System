@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb pageTitle="Quiz" previous="Courses" previousLink="{{ route('courses.index') }}" current="Quizzes List" />
@endsection
@include('jambasangsang.backend.courses.quiz.partials.data-table')
@endsection
