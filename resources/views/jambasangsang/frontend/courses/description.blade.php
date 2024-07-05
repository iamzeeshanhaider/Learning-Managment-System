<div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
    <div class="overview-description">
        <div class="single-description pt-3">
            <h6>@lang('Course Summary')</h6>
            <p>{{ $course->course_master->description }}</p>
        </div>
        <div class="single-description pt-3">
            <h6>@lang('Location')</h6>
            <p>{{ $course->location->name }}</p>
        </div>
        <div class="single-description pt-3">
            <h6>@lang('Module')</h6>
            <p>{{ $course->module->name }}</p>
        </div>
    </div>
</div>
