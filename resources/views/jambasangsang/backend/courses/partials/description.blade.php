<div class="row">
    <div class="col-lg-8">
        <div class="single-course-left mt-30">
            <div class="title">
                <h3>{{ $course->title }}</h3>
                <small>{{ $course->course_master->name }}</small>
            </div> <!-- title -->

            <div class="single-course-image">
                <img src="{{ $course->image() }}" alt="Courses">
            </div> <!-- corses single image -->

        </div>

    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-12 col-md-6">
                <div class="course-features mt-30">
                    <h4>@lang('Course Features') </h4>
                    <ul>
                       {{-- <li><i class="fa fa-clock-o"></i>@lang('Start Date') :
                            <span>{{ $course->start_date->format('Y-m-d') }}</span>
                        </li>
                        <li><i class="fa fa-clock-o"></i>@lang('End Date') :
                            <span class="{{ $course->end_date && $course->end_date->isFuture() ? 'iro-countdown text-success' : '' }}"
                                data-expire="{{ $course->end_date ?? '' }}">{{ $course->end_date ? $course->end_date->format('Y-m-d') : '' }}</span>
                        </li>--}}
                        <li><i class="fa fa-clone"></i>@lang('Lectures') :
                            <span>{{ count($course->lessons) }}</span>
                        </li>
                        {{--<li><i class="fa fa-clone"></i>@lang('Module') :
                            <span title="{{ $course->module->name }}">{{ str_limit($course->module->name, 50) }}</span>
                        </li>--}}
                        <li><i class="fa fa-map-marker"></i>@lang('Location') :
                            <span>
                                <a href="#locationInfo" title="{{ $course->location->name }}" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="locationInfo">
                                    {{ str_limit($course->location->name, 50) }}
                                    <i title="Click to view more" class="fa fa-exclamation-circle text-info"></i>
                                </a>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="overview-description">
    <div class="pt-3 single-description collapse" id="locationInfo">
        <h6>@lang('Location Info')</h6>
        {!! $course->location->description !!}
    </div>
    <div class="single-description">
        <h6>@lang('Course Summary')</h6>
        <p>{!! $course->course_master->description !!}</p>
    </div>
</div>
