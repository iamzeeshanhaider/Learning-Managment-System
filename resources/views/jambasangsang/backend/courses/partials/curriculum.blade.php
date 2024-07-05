<div class="curriculam-cont">
    <div class="title">
        <h6>
            {{ $course->title }}
            <br>
        </h6>
    </div>
    <div class="card bg-light border-0 p-3" id="lessonAccordion">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h4 class="my-3">{{ $folder ? 'Resources' : 'Lessons' }}</h4>
            @if ($folder)
                <a href="{{ route('student.courses.show', ['batch' => $course->pivot->batch_id, 'course' => $course, 'l_view' => request('l_view')]) }}"
                    class="btn btn-sm btn-primary">
                    <i class="ti-arrow-left"></i> Go Back</a>
            @endif
        </div>
        <hr>
        <div class="">
            @if ($folder ? count($resources) : count($course->lessons))
                @foreach ($folder ? $resources : $course->lessons as $key => $item)
                    @if ($folder)
                        @if (resourceIsVisible($course->pivot->id, $item))
                            <div class="col-md-4 iro_card">
                                <livewire:backend.lesson.resource wire:key="{{ $item->slug }}"
                                    resource="{{ $item->id }}" courseUser="{{ $course->pivot->id }}" />
                            </div>
                        @endif
                    @else
                        <livewire:backend.lesson.show wire:key="{{ $key }}" lesson="{{ $item->id }}"
                            view="{{ $l_view }}" courseUser="{{ $course->pivot->id }}" />
                    @endif
                @endforeach
            @else
                <div class="p-5 text-center">
                    No {{ $folder ? 'Resources' : 'Lessons' }} Found
                </div>
            @endif
        </div>
        <hr>
        @if ($folder && count($resources))
            @php
                $previousFolder = getNextOrPreviousFolder($folder, true);
                $nextFolder = getNextOrPreviousFolder($folder);
            @endphp

            @if ($previousFolder || $nextFolder)
                <div class="d-flex justify-content-between align-items-center">
                    @if ($previousFolder)
                        <a href="{{ request()->fullUrlWithQuery(['r_view' => $previousFolder->id]) }}"
                            class="btn btn-sm btn-primary">
                            <i class="ti-arrow-left"></i>
                            <span class="pl-1">Previous Folder: {{ str_limit(ucwords($previousFolder->name), 20) }}</span>
                        </a>
                    @endif

                    @if ($nextFolder)
                        <a href="{{ request()->fullUrlWithQuery(['r_view' => $nextFolder->id]) }}"
                            class="btn btn-sm btn-primary ml-auto">
                            <span class="pr-1">Next Folder: {{ str_limit(ucwords($nextFolder->name), 20) }}</span>
                            <i class="ti-arrow-right"></i>
                        </a>
                    @endif
                </div>
            @endif

        @endif

    </div>

</div> <!-- curriculam cont -->
