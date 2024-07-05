<div class="my-3 border-0 resource_card">
    <div class="backgroundEffect"></div>
    <div class="pic">
        <img class="" src="{{ asset('jambasangsang/backend/images/quiz.png') }}" alt="{!! $quiz->question !!}">
        <div class="d-flex justify-content-between">
            @if ($quiz->start_time)
                <div class="start_date">
                    <span class="text">{{ $quiz->start_time->isFuture() ? 'Starts' : 'Started' }}</span>
                    <span class="day">{{ $quiz->start_time->format('d') }}</span>
                    <span class="month">{{ $quiz->start_time->format('F') }}</span>
                    <span class="year">{{ $quiz->start_time->format('Y') }}</span>
                    <span class="time">{{ $quiz->start_time->format('H:i A') }}</span>
                </div>
            @endif
            @if ($quiz->end_time)
                <div class="end_date">
                    <span class="text">{{ $quiz->end_time->isFuture() ? 'Ends' : 'Ended' }}</span>
                    <span class="day">{{ $quiz->end_time->format('d') }}</span>
                    <span class="month">{{ $quiz->end_time->format('F') }}</span>
                    <span class="year">{{ $quiz->end_time->format('Y') }}</span>
                    <span class="time">{{ $quiz->end_time->format('H:i A') }}</span>
                </div>
            @endif
        </div>
    </div>
    <div class="content">
        <div class="mt-2 text-left small font-weight-bold">
            {{ str_limit($quiz->title, 40) }}
        </div>
        <div class="mt-3 d-flex align-items-start justify-content-between small">
            <a class="btn btn-primary btn-sm {{ $has_more_attempts ? '' : 'disabled' }}"
                href="{{ route('student.quiz.attempt', ['batch_user' => $batchUser->id, 'quizzes' => $quiz->slug, 'action' => 'init']) }}" target="_blank">
                Take Quiz<span class="pl-2 fa fa-arrow-right"></span>
            </a>
            <div class="form-group">
                <input type="checkbox" wire:model="isCompleted" id="resource__{{ $quiz->slug }}" readonly disabled>
                <label for="resource__{{ $quiz->slug }}" class=""
                    readonly><small>{{ $isCompleted ? 'Submitted' : '' }}</small></label>
            </div>
        </div>
        <div class="pb-1 foot small d-flex justify-content-between align-items-center">
            <span>{{ getAttempts($quiz) }} of {{ $total_attempts }} attempts</span>
            @if (getAttempts($quiz))
            <span>Score: {{ $student_score }} / {{ $quiz->obtainable_points }}</span>
            @endif
        </div>
        @if ($submission && $submission->grade)
            <div class="addon">
                <div class="btn btn-primary">
                    Grade: {{ $submission->grade }}
                </div>
            </div>
        @endif
    </div>
</div>
