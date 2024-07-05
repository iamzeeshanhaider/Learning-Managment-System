<div class="border-0">
    <div class="card border-0">
        @php
            $previousResource = getNextOrPreviousResource($resource, true);
            $nextResource = getNextOrPreviousResource($resource);
        @endphp

        @if ($previousResource || $nextResource)
            <div class="d-flex justify-content-between align-items-center">
                @if ($previousResource)
                    <a @if (in_array($previousResource->extention, ['mp4', 'webm', 'mkv', '3gp', 'pdf', 'jpg', 'jpeg', 'png', 'gif', 'tiff']) ||
                            $previousResource->type === \App\Enums\LessonResourceType::Embed) onclick="handleGeneralModal(this)" data-link="{{ route('lesson.resource.show', ['lesson' => $previousResource->lesson->slug, 'resource' => $previousResource->slug]) }}"
                        @else
                        href="{{ $previousResource->file() }}" target="{{ $previousResource->extention === 'zip' ? '_self' : '_blank' }}"
                        {{ $previousResource->extention === 'zip' ? 'download' : '' }} @endif
                        class="btn-sm btn btn-primary text-white" title="Preview Resource" data-bs-dismiss="modal">

                        <i class="ti-arrow-left pr-2"></i>
                    </a>
                @endif

                @if ($nextResource)
                    <a @if (in_array($nextResource->extention, ['mp4', 'webm', 'mkv', '3gp', 'pdf', 'jpg', 'jpeg', 'png', 'gif', 'tiff']) ||
                            $nextResource->type === \App\Enums\LessonResourceType::Embed) onclick="handleGeneralModal(this)" data-link="{{ route('lesson.resource.show', ['lesson' => $nextResource->lesson->slug, 'resource' => $nextResource->slug]) }}"
                        @else
                        href="{{ $nextResource->file() }}" target="{{ $nextResource->extention === 'zip' ? '_self' : '_blank' }}"
                        {{ $nextResource->extention === 'zip' ? 'download' : '' }} @endif
                        class="btn-sm btn btn-primary text-white ml-auto" title="Preview Resource" data-bs-dismiss="modal">

                        <i class="ti-arrow-right pl-2"></i>
                    </a>
                @endif
            </div>
        @endif
    </div>
    @switch($resource->type)
        @case(\App\Enums\LessonResourceType::Embed)
            <div class="embed-responsive embed-responsive-16by9">
                {!! $resource->embed_code !!}
            </div>
        @break

        @case(\App\Enums\LessonResourceType::File)
            @if (in_array($resource->extension, ['mp4', 'webm', 'mkv', '3gp']))
                <div class="embed-responsive embed-responsive-16by9">
                    <video allow="fullscreen" frameBorder="0" width="100%" height="700" controls controlsList="nodownload">
                        <source src="{{ $resource->file() }}" />
                    </video>
                </div>
            @elseif ($resource->extension === 'pdf')
                <div class="embed-responsive embed-responsive-16by9">
                    <embed class="embed-responsive-item" src="{{ $file . '#toolbar=0&navpanes=0&scrollbar=0' }}"
                        allowfullscreen loading="lazy" name="{{ $resource->name }}" width="100%" />
                </div>
            @else
                <img class="" src="{{ $resource->file() . '#toolbar=0&navpanes=0&scrollbar=0' }}"
                    style="width: 100%; height: auto;" />
            @endif
        @break

    @endswitch
</div>
