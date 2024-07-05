<div class="btn-group">
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary"
        data-link="{{ route('batches.edit', $row->slug) }}" title="Edit Batch">
        <i class="fa fa-edit"></i>
    </a>
    <a href="{{ route('batches.show', $row->slug) }}" class="text-white btn btn-sm btn-primary" title="Preview">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('users.index', ['group' => 'student', 'batch_filter' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary" title="View Lessons">Students ({!! formatCount($row->students_count) !!})</a>
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary" title="Enroll Students"
        data-link="{{ route('students.bulk_enrol.init', ['batch' => $row->slug]) }}">
        <i class="fa fa-user-plus"></i>
    </a>
</div>

