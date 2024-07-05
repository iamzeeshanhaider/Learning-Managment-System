@section('css')
    {{--  --}}
@endsection

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-light border-bottom d-flex align-items-center justify-content-between">
                    <div class="">
                        <strong class="card-title">
                            @lang('Quizzes List')
                            @if (isset($course))
                                For: {{ $course->title ?? '' }}
                            @endif
                        </strong>
                    </div>
                    <div class="p-2">
                        <a href="{{ $filterByBatch ? request()->fullUrlWithoutQuery('batch_filter') : request()->fullUrlWithQuery(['batch_filter' => 'true']) }}"
                            class="small">
                            <b>{{ $filterByBatch ? 'Clear' : '' }} Filter by Batch</b>
                        </a>
                    </div>
                    <div class="">
                        <a href="{{ route('quiz.create', isset($course) ? ['course' => $course->slug] : '') }}"
                            class="text-white btn btn-sm btn-success">@lang('New Quiz')</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:backend.quiz-table course="{{ !is_null($course) ? $course->id : $course }}" :filterByBatch="$filterByBatch" />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
