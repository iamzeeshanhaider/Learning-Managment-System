<div>
    {!! $truncatedContent !!}
    @if (strlen($content) > $limit)
        ... <button wire:click="toggleExpand" class="btn btn-link text-decoration-none btn-sm mx-0 px-0">
            {{ $expanded ? 'Show less' : 'Show more' }}
        </button>
    @endif
</div>
