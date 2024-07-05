<div class="d-flex justify-content-between align-items-center">

    <div>
        <a href="#" class="pt-3">
            <small class="">
                <b>Enrolled Courses:</b> {!! formatCount(count($courses)) !!}
            </small>
        </a>
    </div>

    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary" title="Enroll Students"
        data-link="{{ route('students.bulk_enrol.init', ['student' => $user->slug]) }}">
        Enroll <i class="ml-1 fa fa-plus"></i>
    </a>
</div>

<div id="student_batch_accordion" class="mt-3">

    @forelse ($courses as $key => $course)
        <div class="card" id="course_group_container">
            <a class="{{ $key === 0 ? 'active' : '' }} card-title px-3 py-2 mb-0" data-toggle="collapse"
                href="#collapse_group_{{ $key }}" role="button" aria-expanded="false"
                aria-controls="collapse_group_{{ $key }}" title="{{ $course->title }}">
                <b>Course Title:</b> {{ str_limit($course->title, 80) }} <i class="fa fa-exclamation-circle"
                    data-toggle="tooltip" title="Click to see progress"></i>
            </a>

            <div class="collapse {{ $loop->first ? 'show' : '' }} p-3" id="collapse_group_{{ $key }}"
                aria-labelledby="heading_group_{{ $key }}" data-parent="#course_group_container">
                <i class="text-info">Lesson Progress Report</i>

                {{-- Display Progress based on lesson --}}
                <div class="px-2 py-4">
                    @forelse ($course->lessons as $lesson_key => $lesson)
                        <a class="{{ $loop->first ? 'active' : '' }}" data-toggle="collapse"
                            href="#collapse_lesson_{{ $lesson_key }}" role="button" aria-expanded="false"
                            aria-controls="collapse_lesson_{{ $lesson_key }}">
                            <div class="d-flex justify-content-between align-items-center ">
                                <small title="{{ $lesson->name }}">{{ str_limit($lesson->name, 90) }}
                                    <i class="fa fa-exclamation-circle" data-toggle="tooltip"
                                        title="Click to see progress on individual resources"></i>
                                </small>
                            </div>
                            <div class="mb-3">
                                {!! getFormattedProgress($course->pivot->id, $lesson) !!}
                            </div>
                        </a>

                        {{-- Display Lesson Resources --}}
                        <div class="p-3 collapse" id="collapse_lesson_{{ $lesson_key }}">
                            @forelse ($lesson->resources as $resource_key => $resource)
                                <livewire:backend.lesson.student-resource :courseUser='$course->pivot->id' :resource='$resource' />
                            @empty
                                {{-- Redirect to create lesson resource --}}
                                @if (auth()->user()->hasRole('Admin'))
                                    <a href="{{ route('lesson.folder.index', $lesson->slug) }}"
                                        class="text-white btn btn-sm btn-primary" target="_blank"
                                        title="Add Lesson Resource">
                                        Add Lesson Resource <i class="ml-1 fa fa-plus"></i>
                                    </a>
                                @endif
                            @endforelse
                        </div>
                        {{-- End Display Lesson Resources --}}
                    @empty
                        {{-- Redirect to create lesson --}}
                        @if (auth()->user()->hasRole('Admin'))
                            <a href="{{ route('lessons.index') }}" class="text-white btn btn-sm btn-primary"
                                target="_blank" title="Add Lessons">
                                Add Lesson <i class="ml-1 fa fa-plus"></i>
                            </a>
                        @endif
                    @endforelse
                </div>
                {{-- End Display Progress based on lesson --}}

                <div class="text-right" id="resource_action">
                    {{-- Unenroll Student from course --}}
                    @if (hasCertificate($user, $course))
                        <a class="text-white btn btn-sm btn-success" title="Manage Certificate"
                            href="{{ route('certificate.student_certificate', ['student' => $user->id, 'course' => $course->id]) }}">
                            Manage Certificate <i class="ml-1 fa fa-file"></i>
                        </a>
                    @endif
                    @if (!auth()->user()->isStudent())
                        <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-danger"
                            title="Un-Enroll Students"
                            data-link="{{ route('students.bulk_enrol.init', [
                                'student' => $user->slug,
                                'course' => $course->slug,
                                'action' => 'unenrol',
                            ]) }}">
                            Un-Enroll From Course <i class="ml-1 fa fa-plus"></i>
                        </a>
                    @endif
                    {{-- Unenroll Student from course --}}
                </div>
            </div>
        </div>
    @empty
        <div class="p-5 text-center">
            <p class="5">
                Student has not been enrolled for any course
            </p>

            <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary" title="Enroll Students"
                data-link="{{ route('students.bulk_enrol.init', ['student' => $user->slug]) }}">
                Enroll Now <i class="ml-1 fa fa-plus"></i>
            </a>
        </div>
    @endforelse

    {{-- <x-slot:paginator>
        {{ $courses->links('vendor.pagination.iro-custom') }}
    </x-slot> --}}

</div>
