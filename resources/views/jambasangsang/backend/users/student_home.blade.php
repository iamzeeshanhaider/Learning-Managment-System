<div class="col-lg-8">
    @forelse ($numberOfCoursesAndStudents as $studentCourse)
        <div class="col-md-12 col-sm-6 iro_card">
            <div class="p-3 border-0 card iro_card">
                <div class="card-body">
                    <a
                        href="{{ route('student.courses.show', ['batch' => $studentCourse->pivot->batch_id, 'course' => $studentCourse->pivot->course_id]) }}">
                        <div class="stat-widget-one d-flex">
                            <div class="stat-icon" style="width: 160px; height: 140px; background-size: cover; background-position: center; background-image: url('{{ $studentCourse->image() }}')"></div>
                            <div class="stat-content">
                                <div class="stat-text" title="{{ $studentCourse->title }}">
                                    <b>Course Title:</b>
                                    {{ str_limit($studentCourse->title, 30) }}
                                </div>
                                <div class="stat-text"><b>Batch:</b> {{ $studentCourse->getBatch()->name }}</div>
                                <div class="d-flex justify-content-between align-items-center">
                                    {{--<div class="d-flex align-items-center" title="Number of Students">
                                        <i class="pr-1 ti-user text-success border-success"></i>
                                        {!! formatCount($studentCourse->students_count) !!}
                                    </div>--}}

                                    <div class="d-flex align-items-center" title="Lessons">
                                        <i class="pr-1 ti-list text-success border-success"></i>
                                        {!! formatCount($studentCourse->lessons_count) !!}
                                    </div>

                                    <div class="d-flex align-items-center" title="Quiz">
                                        <i class="pr-1 fa fa-tasks text-success border-success"></i>
                                        {!! formatCount($studentCourse->quizzes_count) !!}
                                    </div>

                                    <div class="d-flex align-items-center" title="Location">
                                        <i class="pr-1 ti-location-pin text-success border-success"></i>
                                        <small>{{ $studentCourse->location->name }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="p-5 mx-auto text-center col-12">
            You are not enrolled to a course yet
        </div>
    @endforelse
</div>

<div class="col-lg-4">
    <div class="border-0 iro_static_scollable card" style="height: 80vh;">
        <div class="p-3">
            <h6>This Week
                <i class="fa fa-question-circle-o" title="This following quiz starts or are due this week"></i>
            </h6>
            @foreach ($numberOfCoursesAndStudents as $course)
                @foreach ($course->quizzes as $quiz_key => $quiz)
                    <livewire:backend.lesson.quiz wire:key="{{ $quiz->slug }}" quiz="{{ $quiz->id }}"
                        batchUser="{{ $course->pivot->id }}" />
                {{-- <div class="p-5 text-center">
                    You do not have any quiz due this week 🎉
                </div> --}}
                @endforeach
            @endforeach
        </div>
    </div>
</div>
