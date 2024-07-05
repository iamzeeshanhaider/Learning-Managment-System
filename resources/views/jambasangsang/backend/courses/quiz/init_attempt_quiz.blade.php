@extends('layouts.backend.quiz_layout')
@section('content')
    <div class="m-auto d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="mx-auto col-md-10 col-lg-10">
            <div class="border-0 shadow card">
                <div class="p-5">
                    <div class="row align-items-center">
                        <div class="border-0 col-md-6 card">
                            <img src="{{ $quiz->course->image() }}" alt="Course" height="150">
                        </div>
                        <div class="border-0 shadow col-md-6 card">
                            <div class="p-3">
                                <div class="text-center">
                                    <h3 class="text-capitalize card-title"><b>{{ $quiz->title }}</b></h3>
                                    <p class="pb-3 card-text">{{ $quiz->description }}</p>
                                </div>

                                <ul class="list-group">
                                    @if ($quiz->duration)
                                        <li class="list-group-item">
                                            <div class="row border-bottom">
                                                <div class="col col-md-4">Quiz Duration</div>
                                                <div class="col border-left">
                                                    {{ sprintf('%02d:%02d', $quiz->duration / 60, $quiz->duration % 60) }}
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    @if ($quiz->start_time)
                                        <li class="list-group-item">
                                            <div class="row border-bottom">
                                                <div class="col col-md-4">Start Date</div>
                                                <div class="col border-left">
                                                    @if ($quiz->start_time >= now()->addHours(1))
                                                        <span data-expire="{{ $quiz->start_time }}"
                                                            class="m-1 {{ $quiz->start_time->isFuture() ? 'iro-countdown text-success' : 'text-info' }}">
                                                            {{ $quiz->start_time->format('j/m/Y - H:i A') }}
                                                        </span>
                                                    @else
                                                        <span class="m-1 text-info">
                                                            {{ $quiz->start_time->format('j/m/Y - H:i A') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    @if ($quiz->end_time)
                                        <li class="list-group-item">
                                            <div class="row border-bottom">
                                                <div class="col col-md-4">End Date</div>
                                                <div class="col border-left">
                                                    <span data-expire="{{ $quiz->end_time }}"
                                                        class="m-1 {{ !$quiz->start_time->isFuture() && $quiz->end_time->isFuture() ? 'iro-countdown text-success' : 'text-info' }}">
                                                        {{ $quiz->end_time->format('j/m/Y - H:i A') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col col-md-4">Attempts</div>
                                            <div class="col border-left">
                                                {{ sprintf('%01d/%01d', getAttempts($quiz), $quiz->attempts) }}</div>
                                        </div>
                                    </li>
                                </ul>

                                <div class="mt-3">
                                    @if ($quiz->start_time && $quiz->start_time <= now()->addHours(1))
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#quizConfirmationModal">Start Quiz</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="quizConfirmationModal" tabindex="-1" role="dialog"
                    aria-labelledby="quizConfirmationModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="">
                                    <div class="p-5 text-center">
                                        <h1 class="">
                                            <strong>Warning:</strong>
                                        </h1>
                                        <p class="">
                                            Once you start the quiz, you cannot refresh the page, go back, or cancel.
                                            Please ensure you are in a environment with a stable internet connection.
                                            <br>
                                            <br>
                                            <span class="text-danger">
                                                Note: This is your
                                                {{ numberFormatter(getAttempts($quiz) + 1) }} attempt
                                            </span>
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button type="button" class="mx-2 btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <a href="{{ route('student.quiz.attempt', ['batch_user' => $batch_user->id, 'quizzes' => $quiz->slug, 'action' => 'attempt']) }}"
                                            class="mx-2 btn btn-primary">Yes, Start Quiz</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
