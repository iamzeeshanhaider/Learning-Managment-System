@section('css')
    {{--  --}}
@show

<div class="animated fadeIn">
    <form action="{{ isset($course) ? route('courses.update', ['course' => $course->slug]) : route('courses.store') }}"
        method="post" enctype="multipart/form-data" onsubmit="$('#course-button').attr('disabled', true)">
        @if (isset($course))
            @method('put')
        @endif
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="title" class="mb-1 control-label">@lang('Course Title')</label>
                    <input id="title" name="title" type="text" required
                        value="{{ isset($course) ? $course->title : '' }}" maxlength="120"
                        class="form-control title @error('title') is-invalid @enderror" autocomplete="title">
                </div>
                @error('title')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <div class="form-group">
                    <x-select.users name="instructor_id" group="Instructor" :selected="isset($course) ? $course->instructor_id : old('instructor_id')" />
                </div>
                @error('instructor_id')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <div class="form-group">
                    <x-select.course-master :selected="isset($course)
                        ? $course->course_master_id
                        : (isset($courseMaster)
                            ? $courseMaster->id
                            : old('course_master_id'))" :readonly="isset($courseMaster) && $courseMaster->id ? true : false" />
                </div>
                @error('course_master_id')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            {{-- TODO: display is set to none for now - take note --}}
            {{-- <div class="col-6 d-none">
                <div class="form-group">
                    <x-select.module :selected="isset($course) ? $course->module_id : (isset($module) ? $module->id : old('module_id'))" :readonly="isset($module) && $module->id ? true : false" :required="false" />
                </div>
                @error('module_id')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div> --}}
            {{-- TODO: display is set to none for now - take note --}}

            <div class="col-6">
                <div class="form-group">
                    <x-select.location :selected="isset($course) ? $course->location_id : old('location_id')" />
                </div>
                @error('location_id')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <div class="form-group">
                    <x-select.status :selected="isset($course) ? $course->status : \App\Enums\GeneralStatus::Enabled" />
                </div>
                @error('status')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="price" class="mb-1 control-label">@lang('Course Price')</label>
                    <input id="price" name="price" type="number" min="0" required
                        value="{{ isset($course) ? $course->price : 0 }}"
                        class="form-control price @error('price') is-invalid @enderror" autocomplete="price">
                </div>
                @error('price')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="start_date" class="mb-1 control-label">@lang('Course Start')</label>
                    <input id="start_date" name="start_date" type="date" required
                        value="{{ isset($course) ? $course->start_date->format('Y-m-d') : now()->toDateTimeString() }}"
                        class="form-control start_date @error('start_date') is-invalid @enderror" autocomplete="start">
                </div>
                @error('start_date')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="end_date" class="mb-1 control-label">@lang('Course Finished')</label>
                    <input id="end_date" name="end_date" type="date"
                        value="{{ isset($course) && $course->end_date ? $course->end_date->format('Y-m-d') : old('end_date') }}"
                        class="form-control end_date @error('end_date') is-invalid @enderror" autocomplete="end_date">
                </div>
                @error('end_date')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>

            <div class="{{ isset($course) ? 'col-8' : 'col-12' }}">
                <div class="form-group">
                    <label for="image" class="mb-1 control-label">@lang('Feature Image')</label>
                    <input id="image" name="image" type="file" accept="image/png, image/gif, image/jpeg"
                        value="{{ isset($course) ? $course->image : old('image') }}"
                        class="form-control-file image @error('image') is-invalid @enderror" autocomplete="image">
                </div>
                @error('image')
                    <div class="help-block field-validation-valid alert alert-danger">
                        {{ $message }}</div>
                @enderror
            </div>


            @isset($course)
                <div class="col-md-4 form-group">
                    <label for="image" class="mb-1 control-label">@lang('Preview Image')</label>
                    <img src="{{ $course->image() }}" alt="">
                </div>
            @endisset
        </div>

        <div>
            <button id="course-button" type="submit" class="btn btn-lg btn-primary btn-block">
                <span id="category-button-sending">
                    @isset($course)
                        @lang('Update Course')
                    @else
                        @lang('Create Course')
                    @endisset
                </span>&nbsp;
                <i class="fa fa-arrow-right fa-lg"></i>
            </button>
        </div>
    </form>
</div>
