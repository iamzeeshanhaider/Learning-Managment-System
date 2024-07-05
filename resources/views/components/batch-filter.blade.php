@props([
    'filterByBatch' => false,
])
<div>
    <a href="{{ $filterByBatch ? request()->fullUrlWithoutQuery('batch_filter') : request()->fullUrlWithQuery(['batch_filter' => 'true']) }}"
        class="small">
        <b>{{ $filterByBatch ? 'Clear' : '' }} Filter by Batch</b>
    </a>
</div>
