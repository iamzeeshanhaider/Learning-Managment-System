<div class="btn-group">
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary"
        data-link="{{ route('lessons.edit', $row->slug) }}" title="Edit Lesson">
        <i class="fa fa-edit"></i>
    </a>
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('lessons.show', $row->slug) }}" title="Preview Lesson">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('lesson.folder.index', ['lesson' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}" title="Manage Lesson Resources">
        Folders ({!! formatCount($row->folders_count) !!})
    </a>
    {{-- Delete action not allowed at the moment --}}
    {{-- <x-buttons.delete
        :action="route('lessons.destroy', $row->slug)"
        title="Are you sure you want to delete this Lesson?"
    /> --}}
</div>
