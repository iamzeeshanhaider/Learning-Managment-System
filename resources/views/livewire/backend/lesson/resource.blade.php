<div class="resource_card my-3 border-0">
    <div class="backgroundEffect"></div>
    <div class="pic">
        <div class="text-center w-100 mx-auto p-3">
            @include('jambasangsang.backend.lessons.partials.icons')
        </div>
    </div>
    <div class="content">
        <p class="title" title="{{ $resource->name }}">
            <b>{{ str_limit($resource->name, 80) }}</b>
        </p>
        <div class="d-flex align-items-center justify-content-between mt-3 pb-3">
            <div>
                @if (in_array($resource->extention, ['mp4', 'webm', 'mkv', '3gp', 'pdf', 'jpg', 'jpeg', 'png', 'gif', 'tiff']) ||
                        $resource->type === \App\Enums\LessonResourceType::Embed)
                    <a onclick="handleGeneralModal(this)" class="btn btn-primary"
                        data-link="{{ route('lesson.resource.show', ['lesson' => $resource->lesson->slug, 'resource' => $resource->slug]) }}"
                        title="Preview Resource">
                        <i class="fa fa-eye pr-2"></i> Preview
                    </a>
                @else
                    <a href="{{ $resource->file() }}" target="{{ $resource->extention === 'zip' ? '_self' : '_blank' }}"
                        title="Preview Resource" class="btn btn-primary"
                        {{ $resource->extention === 'zip' ? 'download' : '' }}>
                        <i class="fa fa-eye pr-2"></i> Preview
                    </a>
                @endif

            </div>
            <div class="form-group foot">
                <small>
                    <input type="checkbox" wire:model="isCompleted" wire:change="markCompleted"
                        id="resource__{{ $resource->slug }}">
                    <label for="resource__{{ $resource->slug }}"
                        class=""><small>{{ $isCompleted ? 'Completed' : 'Mark Completed' }}</small></label>
                </small>
            </div>
        </div>
    </div>
</div>
