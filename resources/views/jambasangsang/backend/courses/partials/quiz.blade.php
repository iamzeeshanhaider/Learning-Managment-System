<div class="curriculam-cont">
    <div class="title">
        <h6>
            {{ $course->title }}
            <br>
            {{-- <small>
                @if ($course->start_date->isPast())
                    <span class="text-success">@lang(' Lecture In Progress')</span>
                @else
                    @lang(' Lecture Will Start in ')<span class="iro-countdown"
                        data-expire="{{ $course->start_date }}">{{ $course->start_date->diffForHumans() }}</span>
                @endif
            </small> --}}
        </h6>
    </div>
    <div class="" id="">

        @if (count($course->quizzes))
            <h4 class="my-3">Quiz:</h4>

            <hr>
            <div class="mb-3">
                <section id="publication-part" class="pt-115 pb-120 gray-bg">
                    <div class="container">
                        <div class="row">
                            @foreach ($course->quizzes as $quiz_key => $quiz)
                                <div class="col-lg-4 col-md-6">
                                    <livewire:backend.lesson.quiz wire:key="{{ $quiz->slug }}"
                                        quiz="{{ $quiz->id }}" batchUser="{{ $course->pivot->id }}" />
                                </div>
                            @endforeach
                        </div> <!-- row -->
                    </div> <!-- container -->
                </section>
            </div>
        @else
            <div class="p-5 text-center">
                No Quiz Found
            </div>
        @endif
    </div>
</div> <!-- curriculam cont -->
