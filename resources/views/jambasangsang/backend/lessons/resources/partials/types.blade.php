@if (in_array($row->extention, ['mp4', 'mp4', 'webm', 'mkv', '3gp', 'pdf', 'jpg', 'jpeg', 'png', 'gif', 'tiff']) ||
        $row->type === \App\Enums\LessonResourceType::Embed)
    <a onclick="handleGeneralModal(this)"
        data-link="{{ route('lesson.resource.show', ['lesson' => $this->lesson->slug, 'resource' => $row->slug]) }}"
        title="Preview Resource" class="text-white px-3">
        <span class="w-50 badge badge-pill badge-{{ $row->type_color }}">
            {{ strtoupper($row->extention ?? $row->type) }} <i class="fa fa-{{ $row->type_icon }}"></i>
        </span>
    </a>
@else
    <a href="{{ $row->file() }}" target="_blank" title="Preview Resource" class="text-white px-3"
        {{ $row->extention === 'zip' ? 'download' : '' }}>
        <span class="w-50 badge badge-pill badge-{{ $row->type_color }}">
            {{ strtoupper($row->type ?? $row->extention) }}
            <i class="fa fa-{{ $row->type_icon }}"></i>
        </span>
    </a>
@endif
