<div class="card">
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-md-8">
                <div class="postcard__text t-dark">
                    <div class="postcard__title blue">
                        <p><b>{{ __('Question:') }}</b></p>
                        {!! $quiz->question !!}
                    </div>
                    <div class="postcard__bar"></div>
                    @if ($quiz->instruction)
                        <div class="postcard__preview-txt">
                            <p class="cursor-pointer" type="button" data-toggle="collapse" data-target="#quizInstruction"
                                aria-expanded="false" aria-controls="quizInstruction"><b>{{ __('Instructions') }}</b> <i
                                    class="fa fa-info-circle" title="Click to view Instrutions"></i></p>
                            <div class="collapse" id="quizInstruction">
                                {!! $quiz->instruction !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="postcard__text t-dark">
                    <div class="postcard__preview-txt mt-3">
                        <p><b>{{ __('Submitted:') }}</b> {{ $submission->created_at->diffForHumans() }}</p>
                        <p><b>{{ __('Student Id:') }}</b> {{ $submission->student->bio->student_id ?? 'Not Set' }}</p>
                        <p><b>{{ __('Course Title:') }}</b> {{ $submission->quiz->lesson->course->title ?? 'Not Set' }}
                        </p>
                        <p><b>{{ __('Obtainable Score:') }}</b> {{ $submission->quiz->obtainable_score }}</p>
                        <p><b>{{ __('Obtained Grade:') }}</b> {{ $submission->grade ?? 'Not Graded' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div class="postcard__title blue">
                <p><b>{{ __('Student Submission:') }}</b></p>
            </div>
            @switch($quiz->type)
                @case(\App\Enums\QuizTypes::Text)
                    <div class="form-group">
                        <textarea class="form-control" id="take_quiz_submission" name="value" rows="5" readonly>{{ $submission->value }}</textarea>
                    </div>
                @break

                @case(\App\Enums\QuizTypes::FileUpload)
                    <a href="{{ $submission->file() }}" target="_blank">{{ $submission->file }}</a>
                @break
            @endswitch
        </div>

        <div>
            <div class="text-right">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#gradeSubmission"
                    aria-expanded="false" aria-controls="gradeSubmission">
                    Grade Submission
                </button>
            </div>

            <div class="collapse" id="gradeSubmission">
                <div class="card card-body">
                    <form
                        action="{{ route('submission.update', ['quiz' => $quiz->slug, 'submission' => $submission->id]) }}"
                        method="POST" onsubmit="$('#submission-button').attr('disabled', true)">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="grade" class="mb-1 control-label">@lang('Grade')</label>
                                    <input id="grade" name="grade" type="number" class="form-control valid"
                                        required min="0" max="{{ $quiz->obtainable_score ?? 0 }}"
                                        value="{{ old('grade', $submission->grade ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="feedback" class="mb-1 control-label">@lang('Feedback')</label>
                                    <textarea name="feedback" class="form-control" id="feedback" rows="5">{{ old('feedback', $submission->feedback ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="form-group">
                                <label for="notify_student">
                                    <input type="checkbox" name="notify_student" value="1"> Notify Student
                                </label>
                            </div>
                        </div>

                        <div>
                            <button id="submission-button" type="submit" class="btn btn-lg btn-primary btn-block">
                                @lang('Save') &nbsp; <i class="fa fa-arrow-right fa-lg"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
