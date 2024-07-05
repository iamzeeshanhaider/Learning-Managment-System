<div>
    <div class="custom-drop-select dropup" id="batch-select">
        <a class="dropdown-toggle text-dark" href="#" data-toggle="dropdown" id="batch" aria-haspopup="true"
            aria-expanded="false">
            <b>Current Batch:</b> {{ str_limit(getActiveBatch()->name, 50) }}
            <i data-toggle="tooltip" title="Click to change batch" class="fa fa-exclamation-circle text-success"></i>
        </a>

        <div class="dropdown-menu border-0 shadow" aria-labelledby="batch">
            {{-- @if (!$is_user_batch)
                <ol wire:click="clearActiveBatch" title="{{ __('All Students') }}"
                    class="dropdown-item {{ !getActiveBatch() === 'all' ? 'text-success' : '' }}">{{ __('All Students') }}
                    (*)</ol>
            @endif --}}

            @forelse ($batches as $batch)
                <ol wire:click="setActiveBatch({{ $batch }})" title="{{ $batch->name }}"
                    class="dropdown-item cursor-pointer {{ getActiveBatch()->slug === $batch->slug ? 'text-success' : '' }}">
                    {{ str_limit($batch->name, 80) }} @if (!$is_user_batch)
                        ({!! formatCount($batch->students->count()) !!})
                    @endif
                </ol>
            @empty
                <ol class="dropdown-item">
                    <span class="">{{ $is_user_batch ? 'Student is not enrolled' : 'No Batch found' }}</span>
                </ol>
            @endforelse
        </div>
    </div>
</div>
