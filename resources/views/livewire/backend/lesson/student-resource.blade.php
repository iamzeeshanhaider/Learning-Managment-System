<div class="mb-3">
    <div class="row justify-content-between align-items-center">
        <div class="col-8">
            <p class="small">
                <strong>Resource Name:</strong> {{ $resource->id }}
                <br>
                Folder: {{ $resource->folder->name }} ({{ $resource->folder->is_published ? 'published' : 'un-published'}})
            </p>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-4">
                    <div class="form-check form-switch small text-left">
                        <input class="form-check-input" type="checkbox" wire:model="isHidden" role="switch"
                            id="resource__{{ $resource->slug }}" wire:change="markHidden">
                        <label class="form-check-label"
                            for="resource__{{ $resource->slug }}">{{ $isHidden ? 'Hidden' : 'Visible' }}</label>
                    </div>
                </div>
                <div class="col-4 border-right border-left">
                    <small class="">{!! getStatus($courseUser->id, $resource) !!}</small>
                </div>
                <div class="col-4">
                    <small class="badge badge-pill badge-{{ $resource->type_color }}">{{ ucwords($resource->type) }}</small>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
