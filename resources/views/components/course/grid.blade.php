@props([
    'course' => '',
    'id' => -1,
])
<div class="col-lg-4 col-md-6 mb-3 iro_card">
    <a href="{{ route('student.courses.show', ['batch' => $course->pivot->batch_id, 'course' => $course]) }}"
        style="display: block;">
        <div class="mb-3 single-course mt-30">
            <div class="thum">
                <div class="image">
                    <img src="{{ $course->image() }}" alt="Course">
                </div>
            </div>
            <div class="cont">
                <a href="{{ route('student.courses.show', ['batch' => $course->pivot->batch_id, 'course' => $course]) }}"
                    class="h6 text-truncate" title="{{ $course->title }}" style="width: 95%;">
                    {{ $course->title ?? $course->course_master->name }}
                </a>
                <div class="my-2 d-none">
                    <div class="course-instructor d-flex align-items-center justify-content-between"
                        title="Tutor Information">
                        <div class="d-flex align-items-center">
                            <div class="thum" title="Tutor">
                                <div class="rounded-circle bg-secondary"
                                    style="height: 32px; width: 32px; vertical-align: middle; background-image: url('{{ $course->instructor->avatar }}'); background-position: center;  background-repeat: no-repeat; background-size: cover;">
                                </div>
                            </div>
                            <div class="mx-1 name">
                                <a href="javascript:void(0)">
                                    <h6>{{ $course->instructor->name . ' - Instructor' }}</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
