<div class="btn-group">
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('modules.edit', $row->slug) }}">
        <i class="fa fa-edit"></i>
    </a>
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        title="Preview" data-link="{{ route('modules.show', $row->slug) }}">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('courses.index', ['module' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}" title="View Courses">Courses
        ({!! formatCount($row->courses_count) !!})</a>

    @if ($row->status === \App\Enums\GeneralStatus::Enabled)
        <x-buttons.delete :action="route('modules.destroy', $row->slug)" title="Are you sure you want to delete this Module?" />
    @endif

</div>
