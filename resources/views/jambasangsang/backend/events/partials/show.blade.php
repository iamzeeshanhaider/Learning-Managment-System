<div class="card p-2 border-0 shadow">
    <div class="row card-body">
        <div class="col-md-9">
            <img class="card-img-top" src="{{ $event->image() }}" alt="" width="100%" style="width: 100%; min-height: 300px;">
            <div class="">
                <h3 class="card-title my-3">{{ $event->title }}</h3>
                <p>{!! $event->content !!}</p>
            </div>
        </div>
        <div class="col border-left">
            <div class="mb-3">
                <span>Date</span>
                <p class="card-text pl-3">{{ $event->date }}</p>
            </div>
            <div class="mb-3">
                <span>Status</span>
                <p class="card-text pl-3">{{ $event->status_name }}</p>
            </div>
            <div class="mb-3">
                <span>Group</span>
                <p class="card-text pl-3">{{ $event->group }}</p>
            </div>
            @if ($event->group == \App\Enums\EventGroup::ByBatch && count($event->batch) > 0)
                <div class="mb-3">
                    <span>Batches</span>
                    @foreach ($event->batch as $batch)
                        <p class="card-text pl-3">&check; {{ $batch->name }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
