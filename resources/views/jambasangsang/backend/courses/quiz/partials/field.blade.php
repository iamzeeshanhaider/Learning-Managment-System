@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb
        pageTitle="Quiz"
        previous="Lessons"
        previousLink="{{ route('lessons.index') }}"
        current="Quizzes List"
    />
@endsection
@include('jambasangsang.backend.courses.quiz.partials.data-table')
@endsection


<div class="animated fadeIn">
    <livewire:backend.quiz.create-quiz :course="$course">
    {{-- <form
        action="{{ isset($quiz) ? route('lesson.quiz.update', ['lesson' => $lesson->slug, 'quiz' => $quiz->slug]) : route('lesson.quiz.store', ['lesson' => $lesson->slug]) }}"
        method="POST" enctype="multipart/form-data" onsubmit="$('#quiz-button').attr('disabled', true)">
        @csrf
        @if (isset($quiz))
            @method('put')
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-success">
                    <x-editor label="Question" id="quiz_question" fieldName="question" placeholder="Quiz Question"
                        value="{!! isset($quiz) ? $quiz->question : old('question') !!}" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-success">
                    <x-editor label="Instruction" id="quiz_instruction" fieldName="instruction"
                        placeholder="Quiz instructions" value="{!! isset($quiz) ? $quiz->instruction : old('instruction') !!}" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-success">
                    <label for="obtainable_score" class="mb-1 control-label">@lang('Obtainable Score')</label>
                    <input id="obtainable_score" name="obtainable_score" type="number"
                        class="form-control obtainable_score valid" autocomplete="name" required min="0"
                        value="{{ old('obtainable_score', isset($quiz) ? $quiz->obtainable_score : '') }}">
                    <span class="help-block field-validation-valid" data-valmsg-for="obtainable_score"
                        data-valmsg-replace="true"></span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <x-select.lesson :selected="isset($quiz) ? $quiz->lesson_id : $lesson->id" :readonly="true" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <x-select.status :selected="isset($quiz) ? $quiz->status : \App\Enums\GeneralStatus::Enabled" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <x-select.quiz-type :selected="isset($quiz) ? $quiz->type : old('type')" />
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="start_time" class="mb-1 control-label">@lang('Quiz Start Time')</label>
                    <input id="start_time" name="start_time" type="datetime-local" required
                        value="{{ isset($quiz) ? $quiz->start_time->format('Y-m-d H:i:s') : old('start_time') }}"
                        class="form-control start_time @error('start_time') is-invalid @enderror"
                        autocomplete="start_time">
                </div>
                @error('start_time')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="end_time" class="mb-1 control-label">@lang('Quiz End Time')</label>
                    <input id="end_time" name="end_time" type="datetime-local"
                        value="{{ isset($quiz) && $quiz->end_time ? $quiz->end_time->format('Y-m-d H:i:s') : old('end_time') }}"
                        class="form-control end_time @error('end_time') is-invalid @enderror" autocomplete="end_time">
                </div>
                @error('end_time')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

        </div>
        <div>
            <button id="quiz-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="quiz-button-sending">
                    @isset($quiz)
                        @lang('Update Quiz')
                    @else
                        @lang('Create Quiz')
                    @endisset
                </span>&nbsp;
                <i class="fa fa-arrow-right fa-lg"></i>
            </button>
        </div>
    </form> --}}
</div>

{{-- @section('script')
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
        CKEDITOR.replace('.ckeditor');
    </script>
@endsection --}}
