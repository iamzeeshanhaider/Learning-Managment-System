<span class="iro_editor-content">
    {!! \Str::limit(html_entity_decode(strip_tags($value)), 50) !!}
    @if (strlen(strip_tags($value)) > 50)
    <a href="{{ route('tickets.show', $row->slug) }}" class="text-primary" title="Preview">
        <small>more</small>
    </a>
    @endif
</span>
