@props([
    'course' => '',
    'id' => -1,
])
<div class="col-lg-12">
    <div class="mb-4 single-course">
        <div class="row no-gutters">
            <div class="col-md-6">
                <div class="thum">
                    <div class="image" style="max-height: 320px">
                        <img src="{{ $course->image() }}" alt="Course">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cont">
                    <a href="{{ route('student.courses.show', ['batch' => $course->pivot->batch_id, 'course' => $course]) }}"
                        class="h6 text-truncate" title="{{ $course->title ?? $course->course_master->name }}"
                        style="width: 95%;">
                        {{ $course->title ?? $course->course_master->name }}
                    </a>
                    <div class="mb-3 d-none">
                        <div class="course-instructor d-flex align-items-center">
                            <div class="thum" title="Tutor">
                                <div class="rounded-circle bg-secondary"
                                    style="height: 32px; width: 32px; vertical-align: middle; background-image: url('{{ $course->instructor->avatar }}'); background-position: center;  background-repeat: no-repeat; background-size: cover;">
                                </div>
                            </div>
                            <div class="mx-2 name">
                                <a href="javascript:void(0)">
                                    <b>Instructor:</b>
                                    <h6>{{ $course->instructor->name }}</h6>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!--  row  -->
    </div>
</div>
