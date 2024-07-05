<div class="btn-group">
    <a onclick="handleGeneralModal(this)"
        class="text-white btn btn-sm btn-primary"
        data-link="{{ route('courses_masters.edit', $row->slug) }}" title="Edit Course Master">
        <i class="fa fa-edit"></i>
    </a>
    <a onclick="handleGeneralModal(this)"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('courses_masters.show', $row->slug) }}" title="Preview Course Master">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('courses.index', ['cm' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        title="View Courses">Courses ({!! formatCount($row->courses_count) !!})</a>

    {{-- Delete action not allowed at the moment --}}
    {{-- <x-buttons.delete
        :action="route('courses_masters.destroy', $row->slug)"
        title="Are you sure you want to delete this Course Master?"
    /> --}}
</div>
