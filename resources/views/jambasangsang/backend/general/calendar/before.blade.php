<div class="mb-2 d-flex justify-content-between">
    <div>
        <h4><strong>{{ $startsAt->format('F Y') }}</strong></h4>
    </div>
    <div>
        <button type="button" class="btn btn-sm btn-secondary" wire:click='goToCurrentMonth' title="Current Month">This Month</i></button>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-sm btn-secondary" wire:click='goToPreviousMonth' title="Previous Month"><i class="ti-angle-left"></i></button>
            <button type="button" class="btn btn-sm btn-secondary" wire:click='goToNextMonth' title="Next Month"><i class="ti-angle-right"></i></button>
        </div>
    </div>
</div>
