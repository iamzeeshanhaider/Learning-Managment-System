<span class="iro_editor-content">
    {!! \Str::limit(html_entity_decode(strip_tags($value)), 42) !!}
    @if (strlen(strip_tags($value)) > 42)
    <a onclick="handleGeneralModal(this)" class="text-primary btn btn-sm"
        data-link="{{ route('courses_masters.show', $row->slug) }}" title="Preview">
        <small>more</small>
    </a>
    @endif
</span>
