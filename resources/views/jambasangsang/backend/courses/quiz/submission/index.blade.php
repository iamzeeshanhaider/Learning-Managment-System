@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Quiz Submissions"
        previous="Quiz"
        previousLink="{{ route('quiz.index') }}"
        current="Quiz Submission List"
    />
@endsection
@include('jambasangsang.backend.courses.quiz.submission.partials.data-table')
@endsection


