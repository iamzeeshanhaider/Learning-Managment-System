<div class="btn-group">
    @if ($this->folder)
        <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary"
            data-link="{{ route('lesson.resource.edit', ['lesson' => $this->lesson->slug, 'folder' => $this->folder->slug, 'resource' => $row->slug]) }}"
            title="Edit Lesson Resource">
            <i class="fa fa-edit"></i>
        </a>
        @if (in_array($row->extention, ['mp4', 'mp4', 'webm', 'mkv', '3gp', 'pdf', 'jpg', 'jpeg', 'png', 'gif', 'tiff']) || $row->type === \App\Enums\LessonResourceType::Embed)
            <a onclick="handleGeneralModal(this)"
                class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
                data-link="{{ route('lesson.resource.show', ['lesson' => $this->lesson->slug, 'folder' => $this->folder->slug, 'resource' => $row->slug]) }}"
                title="Edit Lesson Resource">
                <i class="fa fa-eye"></i>
            </a>
        @else
            <a href="{{ $row->file() }}" target="_blank" title="Preview Resource"
                class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
                {{ $row->extention === 'zip' ? 'download' : '' }}>
                <i class="fa fa-eye"></i>
            </a>
        @endif
        @if (is_disabled($row->status))
            {{-- <x-buttons.delete :id="$row->slug" :action="route('lesson.resource.destroy', [
                'lesson' => $this->lesson->slug,
                'folder' => $this->folder->slug,
                'resource' => $row->slug,
            ])" title="Are you sure you want to delete this Lesson?" /> --}}
        @endif
    @else
        <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary"
            data-link="{{ route('lesson.resource.init_add_to_folder', ['lesson' => $this->lesson->slug, 'resource' => $row->slug]) }}"
            title="Edit Lesson Resource">
            <i class="fa fa-plus"></i> Move to Folder
        </a>
    @endif


</div>
