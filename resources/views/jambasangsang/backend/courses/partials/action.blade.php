<div class="btn-group">
    <a href="{{ route('lessons.index', ['course' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        title="View Lessons">Lessons ({!! formatCount($row->lessons_count) !!})</a>
    <a href="{{ route('users.index', ['group' => 'student', 'course' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        title="View Lessons">Students ({!! formatCount($row->students_count) !!})</a>
    <a href="{{ route('quiz.index', ['course' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        title="Manage Quiz">
        Quiz ({!! formatCount($row->quizCount()) !!})
    </a>
    <a onclick="handleGeneralModal(this)"
        class="text-white btn btn-sm btn-primary"
        data-link="{{ route('courses.edit', ['course' => $row->slug, 'courseMaster' => $row->course_master_id, 'module' => $row->module_id]) }}">
        <i class="fa fa-edit"></i>
    </a>
    <a onclick="handleGeneralModal(this)"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('courses.show', ['course' => $row->slug]) }}">
        <i class="fa fa-eye"></i>
    </a>
    <a onclick="handleGeneralModal(this)"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        title="Enroll Students" data-link="{{ route('students.bulk_enrol.init', ['course' => $row->slug]) }}">
        <i class="fa fa-user-plus"></i>
    </a>
    {{-- <a href="{{ route('courses.show', [$row->slug]) }}" class="text-white btn btn-sm btn-primary"><i class="fa fa-eye"></i></a> --}}
    {{-- <x-buttons.delete
        :action="route('courses.destroy', $row->slug)"
        title="Are you sure you want to delete this Course?"
    /> --}}
</div>
