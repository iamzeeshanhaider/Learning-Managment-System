<div class="hover:bg-green-700">
    @if ($event['type'] == 'external')
        <div @if ($eventClickEnabled) wire:click.stop="onEventClick('{{ $event['slug'] }}')" @endif
            class="px-3 py-2 bg-white border rounded-lg shadow-md cursor-pointer">
            <a href="{{ $event['url'] }}" target="_blank">
                <p class="text-sm font-medium">
                    {{ $event['title'] }}
                </p>
                <p class="mt-2 text-xs">
                    {{ $event['description'] ?? 'No description' }}
                </p>
            </a>
        </div>
    @else
        @if (auth()->user()->isAdmin())
            <div @if ($event['url']) onclick="handleGeneralModal(this)" data-link={{ $event['url'] }} @endif
                class="px-3 py-2 bg-white border rounded-lg shadow-md cursor-pointer">
                <p class="text-sm font-medium">
                    {{ $event['title'] }}
                </p>
                <p class="mt-2 text-xs">
                    {{ $event['description'] ?? 'No description' }}
                </p>
            </div>
        @else
            <div @if ($eventClickEnabled) wire:click.stop="onEventClick('{{ $event['slug'] }}')" @endif
                class="px-3 py-2 bg-white border rounded-lg shadow-md cursor-pointer">
                <a @if ($event['url']) @if (auth()->user()->isAdmin()) href="{{ $event['url'] }}" @else onclick="handleGeneralModal(this)" data-link={{ $event['url'] }} @endif
                    @endif>
                    <p class="text-sm font-medium">
                        {{ $event['title'] }}
                    </p>
                    <p class="mt-2 text-xs">
                        {{ $event['description'] ?? 'No description' }}
                    </p>
                </a>
            </div>
        @endif
    @endif
</div>
