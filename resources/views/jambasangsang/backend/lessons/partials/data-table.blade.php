@section('css')
    {{--  --}}
@endsection

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">
                        @lang('Lesson List')
                        @if (isset($course))
                            For: {{ $course->title ?? '' }}
                        @endif
                    </strong>
                    <div class="pull-right">
                        @if (isset($course))
                            <a href="{{ route('lessons.index') }}" class="mx-2 btn btn-sm btn-primary"> <small><i
                                        class="fa fa-filter"></i> Clear Filter</small></a>
                        @endif
                        <a onclick="handleGeneralModal(this)"
                            data-link="{{ route('lessons.create', isset($course) ? ['course' => $course->slug] : '') }}"
                            type="button" class="text-white btn btn-sm btn-success">@lang('New Lesson')</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:backend.lesson-table course="{{ isset($course) ? $course->id : $course }}" />
                </div>
            </div>
        </div>
    </div>

</div>

@section('script')
    {{--  --}}
@endsection
