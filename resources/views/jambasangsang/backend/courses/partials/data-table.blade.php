@section('css')
    {{--  --}}
@endsection

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header bg-light border-bottom">
                    <strong class="card-title">
                        @lang('Course List')
                        @if (isset($courseMaster))
                            For: {{ $courseMaster->name }}
                        @endif
                        @if (isset($module))
                            For: {{ $module->name }}
                        @endif
                    </strong>
                    <div class="d-flex pull-right">
                        @if (isset($courseMaster) || isset($module))
                            <a href="{{ route('courses_masters.index') }}" class="mx-2 btn btn-sm btn-primary"> <small><i
                                        class="fa fa-filter"></i> Clear Filter</small></a>
                        @endif
                        <a onclick="handleGeneralModal(this)"
                            data-link="{{ route('courses.create', isset($courseMaster) ? ['cm' => $courseMaster->slug] : '', isset($module) ? ['module' => $module->slug] : '') }}"
                            type="button" class="text-white btn btn-sm btn-success">@lang('New Course')</a>
                    </div>

                </div>
                <div class="card-body">
                    <livewire:backend.course-table
                        courseMaster="{{ isset($courseMaster) ? $courseMaster->id : $courseMaster }}"
                        module="{{ isset($module) ? $module->id : $module }}" />
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--  --}}
@endsection
