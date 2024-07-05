<div>
    <div class="shadow card iro_card {{ $view === $lesson->slug ? 'border-top border-info' : 'border-0' }}">
        <div class="p-4 border-0 bg-light card-header" id="headingOne{{ $lesson->id }}">
            <a href="{{ route('student.courses.show', ['batch' => $courseUser->batch_id, 'course' => $courseUser->course_id, 'l_view' => $lesson->slug]) }}"
                class="d-flex justify-content-between align-items-center">
                <span>
                    <i class="fa fa-file-o"></i>
                    <span class="head" title="{{ $lesson->name }}">{{ str_limit($lesson->name, 90) }}</span>
                </span>
                <span>
                    <span class="font-weight-bold time d-none d-md-block">
                        <i class="fa fa-clock-o"></i>

                        @switch($progress)
                            @case(0)
                                <span class="text-info">{{ $total_resources ? 'Not Started' : 'No Resources' }}:
                                    {!! formatCount($progress) !!} / {!! formatCount($total_resources) !!}</span>
                            @break

                            @case($total_resources)
                                <span class="text-success">Completed: {!! formatCount($progress) !!} / {!! formatCount($total_resources) !!}</span>
                            @break

                            @default
                                <span class="text-warning">In Progess: {!! formatCount($progress) !!} / {!! formatCount($total_resources) !!}</span>
                        @endswitch
                        <i
                            class="fa fa-{{ $view === $lesson->slug ? 'caret-down' : 'caret-up' }} {{ $view === $lesson->slug ? 'text-success' : '' }}"></i>
                    </span>
                </span>
            </a>
        </div>

        <div class="collapse {{ $view === $lesson->slug ? 'show' : '' }}">
            <div class="card-body">
                <div class="">
                    <strong class="h5">Learning Outcome:</strong>
                    <br>
                    {!! $lesson->outcome !!}
                </div>

                @if ($total_resources)
                    <hr>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <strong class="h5">Resources:</strong>
                            <a href="#" class="text-info" data-toggle="modal"
                                data-target="#progressCompletionHelp" title="Help with progress completion">Your Progress <i class="fa fa-question-circle-o"></i></a>
                        </div>
                        <br>
                        <section id="publication-part" class="gray-bg">
                            <div class="container">
                                <div class="row align-items-center">
                                    @foreach ($lesson->folders as $folder_key => $folder)
                                        @if ($folder->is_published && $folder->resources->isNotEmpty())
                                            <x-course.folder.grid :folder="$folder" route="{!! request()->fullUrlWithQuery(['r_view' => $folder->id]) !!}" />
                                        @endif
                                    @endforeach
                                </div> <!-- row -->
                            </div> <!-- container -->
                        </section>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Resource Info Modal -->
    <div class="modal fade" id="progressCompletionHelp" tabindex="-1" role="dialog"
        aria-labelledby="progressCompletionHelpTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    A tick next to the resource is used to show when the resource is completed
                </div>
            </div>
        </div>
    </div>
</div>
